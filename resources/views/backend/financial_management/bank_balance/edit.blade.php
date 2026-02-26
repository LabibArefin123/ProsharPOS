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
            <form action="{{ route('bank_balances.update', $bank_balance->id) }}" method="POST" data-confirm="edit">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>User Name</strong></label>
                        <select name="user_id" id="user_name_select"
                            class="form-control @error('user_id') is-invalid @enderror">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $bank_balance->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Username</strong></label>
                        <input type="text" id="username_field" value="{{ $bank_balance->user->username }}"
                            class="form-control" readonly style="background:#e9ecef;">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Email</strong></label>
                        <input type="text" id="email_field" value="{{ $bank_balance->user->email }}" class="form-control"
                            readonly style="background:#e9ecef;">
                    </div>

                    {{-- Balance --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Balance (BDT)</strong></label>
                        <input type="number" name="balance" class="form-control @error('balance') is-invalid @enderror"
                            value="{{ old('balance', $bank_balance->balance) }}">
                        <small>
                            <p>[Current Balance in this software: ৳ {{ $bank_balance->system_balance }}]</p>
                        </small>
                        @error('balance')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Balance (USD)</strong></label>
                        <input type="number" name="balance"
                            class="form-control @error('balance_in_dollars') is-invalid @enderror"
                            value="{{ old('balance_in_dollars', $bank_balance->balance_in_dollars) }}">
                        @error('balance_in_dollars')
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
    {{--  Start of user credential js --}}
    <script>
        const nameSelect = document.getElementById('user_name_select');

        const usernameField = document.getElementById('username_field');
        const emailField = document.getElementById('email_field');

        // Convert user data to JS object
        const users = @json($users);

        nameSelect.addEventListener('change', function() {
            const selectedUser = users.find(u => u.id == this.value);

            if (selectedUser) {
                usernameField.value = selectedUser.username;
                emailField.value = selectedUser.email;
            }
        });
    </script>
    {{--  End of user credential js --}}
@stop
