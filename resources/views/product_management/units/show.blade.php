@extends('adminlte::page')

@section('title', 'Unit Details')

@section('content_header')
    <h1 class="m-0 text-dark">Unit Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">

                {{-- Unit Name --}}
                <div class="form-group col-md-6">
                    <label for="name">Unit Name</label>
                    <input type="text" id="name" class="form-control" value="{{ $unit->name }}" readonly>
                </div>

                {{-- Short Name --}}
                <div class="form-group col-md-6">
                    <label for="short_name">Short Name</label>
                    <input type="text" id="short_name" class="form-control" value="{{ $unit->short_name }}" readonly>
                </div>

                {{-- Created By --}}
                <div class="form-group col-md-6">
                    <label for="created_by">Created By</label>
                    <input type="text" id="created_by" class="form-control" value="{{ $unit->createdBy->name ?? 'N/A' }}"
                        readonly>
                </div>

                {{-- Created At --}}
                <div class="form-group col-md-6">
                    <label for="created_at">Created At</label>
                    <input type="text" id="created_at" class="form-control"
                        value="{{ $unit->created_at->format('d M, Y h:i A') }}" readonly>
                </div>

                @if ($unit->updated_by)
                    {{-- Updated By --}}
                    <div class="form-group col-md-6">
                        <label for="updated_by">Updated By</label>
                        <input type="text" id="updated_by" class="form-control"
                            value="{{ $unit->updatedBy->name ?? 'N/A' }}" readonly>
                    </div>

                    {{-- Updated At --}}
                    <div class="form-group col-md-6">
                        <label for="updated_at">Updated At</label>
                        <input type="text" id="updated_at" class="form-control"
                            value="{{ $unit->updated_at->format('d M, Y h:i A') }}" readonly>
                    </div>
                @endif

            </div>

            <div class="mt-3 d-flex justify-content-end gap-2">
                <a href="{{ route('units.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Unit
                </a>
            </div>
        </div>
    </div>
@stop
