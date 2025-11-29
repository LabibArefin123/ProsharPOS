@extends('adminlte::page')

@section('title', 'System Information Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>System Information Details</h1>

        <div class="d-flex gap-2">
            <a href="{{ route('system_informations.index') }}" class="btn btn-warning btn-sm shadow rounded-pill px-3 py-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <a href="{{ route('system_informations.edit', $systemInformation->id) }}"
                class="btn btn-primary btn-sm shadow rounded-pill px-3 py-2">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                <div class="col-md-6">
                    <label class="form-label fw-bold">Name:</label>
                    <input type="text" class="form-control" value="{{ $systemInformation->name }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Title:</label>
                    <input type="text" class="form-control" value="{{ $systemInformation->title }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Slogan:</label>
                    <input type="text" class="form-control" value="{{ $systemInformation->slogan }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Description:</label>
                    <textarea rows="3" class="form-control" readonly>{{ $systemInformation->description }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Photo:</label><br>
                    <img src="{{ asset('upload/system_information/' . $systemInformation->photo) }}" class="img-thumbnail"
                        style="max-width: 250px; border-radius: 10px;">
                </div>

            </div>

        </div>
    </div>
@stop
