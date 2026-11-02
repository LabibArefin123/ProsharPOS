<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemProblem;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WelcomePageController extends Controller
{
    public function index()
    {
        return view('frontend.welcome');
    }

    public function help()
    {
        return view('frontend.welcome_page.public.help');
    }


    public function system_problem_store(Request $request)
    {
        // Validate basic input and attachments.
        $validator = Validator::make($request->all(), [
            'problem_title'       => 'required|string|max:150',
            'problem_description' => 'required|string|max:5000',
            'status'              => 'required|in:low,medium,high,critical',
            'attachments'         => 'nullable|array|max:8',
            'attachments.*'       => 'file|mimes:jpg,jpeg,png,webp,pdf|max:10240',
        ]);

        // Additional validation for individual attachment sizes and dimensions.
        $validator->after(function ($validator) use ($request) {
            foreach ($request->file('attachments', []) as $index => $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                $extension = strtolower($file->getClientOriginalExtension());

                // Images: maximum 5 MB.
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    if ($file->getSize() > 5 * 1024 * 1024) {
                        $validator->errors()->add(
                            "attachments.$index",
                            'Each image must not exceed 5 MB.'
                        );

                        continue;
                    }

                    $imageInfo = @getimagesize($file->getRealPath());

                    if (!$imageInfo) {
                        $validator->errors()->add(
                            "attachments.$index",
                            'The uploaded image is invalid.'
                        );

                        continue;
                    }

                    [$width, $height] = $imageInfo;

                    if (
                        $width < 300 ||
                        $height < 200 ||
                        $width > 5000 ||
                        $height > 5000
                    ) {
                        $validator->errors()->add(
                            "attachments.$index",
                            'Images must be between 300×200 and 5000×5000 pixels.'
                        );
                    }
                }

                // PDFs: maximum 10 MB.
                if ($extension === 'pdf' && $file->getSize() > 10 * 1024 * 1024) {
                    $validator->errors()->add(
                        "attachments.$index",
                        'Each PDF must not exceed 10 MB.'
                    );
                }
            }
        });

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please check the submitted information.',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $uploadedFiles = [];

        try {
            DB::beginTransaction();

            // Generate a readable problem reference.
            do {
                $uid = 'PROSHARPOS-PROB-' . strtoupper(Str::random(8));
            } while (SystemProblem::where('problem_uid', $uid)->exists());

            // Create problem record.
            $problem = SystemProblem::create([
                'problem_uid'         => $uid,
                'problem_title'       => $request->problem_title,
                'problem_description' => $request->problem_description,
                'status'              => $request->status,
            ]);

            // Save multiple attachments.
            foreach ($request->file('attachments', []) as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                $extension = strtolower($file->getClientOriginalExtension());

                $isImage = in_array($extension, [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp'
                ]);

                $folder = $isImage
                    ? 'uploads/problem/images'
                    : 'uploads/problem/files';

                $originalName = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                );

                // Generate a unique filename.
                $timeStamp = Carbon::now()->format('His_dmy');

                $fileName = Str::slug($originalName)
                    . '_' . $timeStamp
                    . '_' . Str::lower(Str::random(6))
                    . '.' . $extension;

                // Store file using public_path().
                $file->move(public_path($folder), $fileName);

                $relativePath = $folder . '/' . $fileName;
                $absolutePath = public_path($relativePath);

                // Keep track of files for rollback cleanup.
                $uploadedFiles[] = $absolutePath;

                // Read image dimensions.
                $imageWidth = null;
                $imageHeight = null;

                if ($isImage) {
                    $imageInfo = @getimagesize($absolutePath);

                    if ($imageInfo) {
                        $imageWidth = $imageInfo[0];
                        $imageHeight = $imageInfo[1];
                    }
                }

                // Save attachment information.
                $problem->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'file_path'     => $relativePath,
                    'file_type'     => $file->getMimeType(),
                    'file_size'     => $file->getSize(),
                    'image_width'   => $imageWidth,
                    'image_height'  => $imageHeight,
                ]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success'    => true,
                    'message'    => 'Your problem has been submitted successfully.',
                    'problem_uid' => $uid,
                ], 201);
            }

            return back()->with(
                'success',
                'Your problem has been submitted successfully. Reference: ' . $uid
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            // Remove uploaded files if the database operation fails.
            foreach ($uploadedFiles as $filePath) {
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            Log::error('System problem submission failed.', [
                'error' => $e->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to submit your problem. Please try again.',
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Unable to submit your problem. Please try again.');
        }
    }
}
