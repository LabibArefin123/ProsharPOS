@extends('adminlte::page')

@section('title', 'Create Unit')

@section('content_header')
    <h1 class="m-0 text-dark"> Create Unit</h1>


@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('units.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Unit Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="e.g., Kilogram" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="short_name">Short Name <span class="text-danger">*</span></label>
                        <input type="text" name="short_name" id="short_name" value="{{ old('short_name') }}"
                            class="form-control @error('short_name') is-invalid @enderror" placeholder="e.g., KG" required>
                        @error('short_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to list
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
