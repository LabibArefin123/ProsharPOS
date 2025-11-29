@extends('adminlte::page')

@section('title', 'Edit System Information')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit System Information</h1>

        <a href="{{ route('system_informations.index') }}" class="btn btn-warning btn-sm shadow rounded-pill px-3 py-2">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('system_informations.update', $systemInformation->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $systemInformation->name) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $systemInformation->title) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Slogan</label>
                        <input type="text" name="slogan" class="form-control"
                            value="{{ old('slogan', $systemInformation->slogan) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $systemInformation->description) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Photo</label>
                        <input type="file" name="photo" class="form-control">

                        @if ($systemInformation->photo)
                            <div class="mt-2">
                                <img src="{{ asset('upload/system_information/' . $systemInformation->photo) }}"
                                    class="img-thumbnail" style="max-width: 200px; border-radius: 10px;">
                            </div>
                        @endif
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success px-4">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
@stop
