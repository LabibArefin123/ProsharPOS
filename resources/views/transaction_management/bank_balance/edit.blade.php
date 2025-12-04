@extends('adminlte::page')

@section('title', 'Edit Bank Balance')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Bank Balance</h3>
        <a href="{{ route('bank_balances.index') }}"
            class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
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
                <form action="{{ route('bank_balances.update', $bank_balance->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        {{-- User --}}
                        <div class="col-md-6 form-group">
                            <label><strong>User</strong></label>
                            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $bank_balance->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Balance --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Balance (BDT)</strong></label>
                            <input type="number" name="balance" class="form-control @error('balance') is-invalid @enderror"
                                value="{{ old('balance', $bank_balance->balance) }}">
                            @error('balance')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
