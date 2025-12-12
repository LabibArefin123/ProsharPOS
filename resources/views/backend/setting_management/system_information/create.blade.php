@extends('adminlte::page')

@section('title', 'Add System Information')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Create System Information</h1>

        <a href="{{ route('system_informations.index') }}"
            class="btn btn-warning btn-sm d-flex align-items-center gap-2 shadow rounded-pill px-3 py-2 back-btn">

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.354
                                     11.354a.5.5 0 0 0 0-.708L6.707 9H11.5a.5.5
                                     0 0 0 0-1H6.707l1.647-1.646a.5.5 0 0
                                     0-.708-.708l-2.5 2.5a.5.5 0 0
                                     0 0 .708l2.5 2.5a.5.5 0 0
                                     0 .708 0z" />
            </svg>
            <span class="fw-bold">Back to List</span>
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

            <form action="{{ route('system_informations.store') }}" method="POST" enctype="multipart/form-data"
                data-confirm="create">
                @csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Title<span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Slogan</label>
                        <input type="text" name="slogan" class="form-control" value="{{ old('slogan') }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Photo</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success px-4">Save</button>
                </div>

            </form>

        </div>
    </div>
@stop
