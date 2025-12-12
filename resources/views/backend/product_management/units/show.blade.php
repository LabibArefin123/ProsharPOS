@extends('adminlte::page')

@section('title', 'Unit Details')


@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Unit Details</h3>
        <div>
            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('units.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
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

                @if ($unit->updated_by)
                    {{-- Updated By --}}
                    <div class="form-group col-md-6">
                        <label for="updated_by">Updated By</label>
                        <input type="text" id="updated_by" class="form-control"
                            value="{{ $unit->updatedBy->name ?? 'N/A' }}" readonly>
                    </div>
                @endif

            </div>
        </div>
    </div>
@stop
