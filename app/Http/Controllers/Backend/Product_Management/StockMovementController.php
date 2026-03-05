<?php

namespace App\Http\Controllers\Backend\Product_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Storage;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{

    public function index()
    {
        $movements = StockMovement::with('storage.product')->latest()->get();
        return view('backend.product_management.stock_movements.index', compact('movements'));
    }

    public function create()
    {
        $storages = Storage::with('product')->get();
        return view('backend.product_management.stock_movements.create', compact('storages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'storage_id' => 'required',
            'movement_type' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $storage = Storage::findOrFail($request->storage_id);

        // Update stock based on movement
        if ($request->movement_type == 'IN') {
            $storage->stock_quantity += $request->quantity;
        } elseif ($request->movement_type == 'OUT') {
            $storage->stock_quantity -= $request->quantity;
        } elseif ($request->movement_type == 'ADJUSTMENT') {
            $storage->stock_quantity = $request->quantity;
        }

        $storage->save();

        StockMovement::create([
            'storage_id' => $request->storage_id,
            'movement_type' => $request->movement_type,
            'quantity' => $request->quantity,
            'reference_no' => $request->reference_no,
            'note' => $request->note,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('stock_movements.index')
            ->with('success', 'Stock movement recorded successfully.');
    }

    public function show(string $id)
    {
        $movement = StockMovement::with('storage.product')->findOrFail($id);
        return view('backend.product_management.stock_movements.show', compact('movement'));
    }

    public function edit(string $id)
    {
        $movement = StockMovement::findOrFail($id);
        $storages = Storage::with('product')->get();

        return view('backend.product_management.stock_movements.edit', compact('movement', 'storages'));
    }

    public function update(Request $request, string $id)
    {
        $movement = StockMovement::findOrFail($id);

        $request->validate([
            'movement_type' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $movement->update([
            'movement_type' => $request->movement_type,
            'quantity' => $request->quantity,
            'reference_no' => $request->reference_no,
            'note' => $request->note,
        ]);

        return redirect()->route('stock_movements.index')
            ->with('success', 'Stock movement updated successfully.');
    }

    public function destroy(string $id)
    {
        $movement = StockMovement::findOrFail($id);
        $movement->delete();

        return redirect()->route('stock_movements.index')
            ->with('success', 'Stock movement deleted successfully.');
    }
}
