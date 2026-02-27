@extends('adminlte::page')

@section('title', 'Edit Bank Deposit')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <h3 class="mb-0">Edit Bank Deposit</h3>

        <div class="d-flex align-items-center gap-3">

            <div class="text-end mr-3">
                <div>
                    <strong>System Balance:</strong>
                    <span id="system_balance_text" class="text-primary">0.00</span>
                </div>
                <div>
                    <strong>Original Balance:</strong>
                    <span id="original_balance_text" class="text-success">0.00</span>
                </div>
            </div>

            <a href="{{ route('bank_deposits.index') }}"
                class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back
            </a>

        </div>
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
            <form action="{{ route('bank_deposits.update', $bankDeposit->id) }}" method="POST" data-confirm="edit">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label><strong>User</strong></label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $bankDeposit->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="bank_balance_id">
                            <strong>Bank Balance (BDT / USD)</strong>
                            <span class="text-danger">*</span>
                        </label>

                        <select name="bank_balance_id" id="bank_balance_id"
                            class="form-control @error('bank_balance_id') is-invalid @enderror">

                            <option value="">Select Bank Balance</option>

                            @foreach ($balances as $balance)
                                <option value="{{ $balance->id }}"
                                    {{ old('bank_balance_id', $bankDeposit->bank_balance_id) == $balance->id ? 'selected' : '' }}>
                                    ৳{{ number_format($balance->balance, 2) }}
                                    —
                                    ${{ number_format($balance->balance_in_dollars, 2) }}
                                </option>
                            @endforeach
                        </select>

                        @error('bank_balance_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Deposit Amount (BDT)</strong></label>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount', $bankDeposit->amount) }}">
                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Deposit Amount (in USD)</strong></label>
                        <input type="number" name="amount_in_dollar"
                            class="form-control @error('amount_in_dollar') is-invalid @enderror"
                            value="{{ old('amount_in_dollar', $bankDeposit->amount_in_dollar) }}">
                        @error('amount_in_dollar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Deposit Date</strong></label>
                        <input type="date" name="deposit_date"
                            class="form-control @error('deposit_date') is-invalid @enderror"
                            value="{{ old('deposit_date', $bankDeposit->deposit_date) }}">
                        @error('deposit_date')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Method</strong></label>
                        <select name="deposit_method" class="form-control @error('deposit_date') is-invalid @enderror">
                            <option value="cash" {{ $bankDeposit->deposit_method == 'cash' ? 'selected' : '' }}>Cash
                            </option>
                            <option value="bank_transfer"
                                {{ $bankDeposit->deposit_method == 'bank_transfer' ? 'selected' : '' }}>
                                Bank Transfer</option>
                            <option value="cheque" {{ $bankDeposit->deposit_method == 'cheque' ? 'selected' : '' }}>
                                Cheque
                            </option>
                            <option value="mobile_banking"
                                {{ $bankDeposit->deposit_method == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking
                            </option>
                        </select>
                        @error('deposit_date')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Reference</strong></label>
                        <input type="text" name="reference_no"
                            class="form-control @error('reference_no') is-invalid @enderror"
                            value="{{ old('reference_no', $bankDeposit->reference_no) }}">
                        @error('reference_no')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control" rows="3">{{ old('note', $bankDeposit->note) }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
@stop
@section('js')
    <script>
        const balances = @json($balancesData);

        const userSelect = document.getElementById('user_id');
        const bankSelect = document.getElementById('bank_balance_id');

        const systemText = document.getElementById('system_balance_text');
        const originalText = document.getElementById('original_balance_text');

        function updateBalanceDisplay(bankId) {
            const selectedBalance = balances.find(b => b.id == bankId);

            if (selectedBalance) {
                systemText.innerText =
                    parseFloat(selectedBalance.system_balance).toFixed(2);

                originalText.innerText =
                    parseFloat(selectedBalance.original_balance).toFixed(2);
            } else {
                systemText.innerText = "0.00";
                originalText.innerText = "0.00";
            }
        }

        userSelect.addEventListener('change', function() {

            const selectedUserId = this.value;

            const userBanks = balances.filter(b => b.user_id == selectedUserId);

            bankSelect.innerHTML = '<option value="">Select Bank Balance</option>';

            if (userBanks.length === 0) {

                bankSelect.innerHTML =
                    '<option value="">No bank found for this user</option>';

                systemText.innerText = "0.00";
                originalText.innerText = "0.00";
                return;
            }

            userBanks.forEach(bank => {

                const option = document.createElement('option');
                option.value = bank.id;

                option.text =
                    'BDT ' +
                    parseFloat(bank.original_balance).toFixed(2);

                bankSelect.appendChild(option);
            });

            // Re-select correct bank after filtering
            const currentBankId =
                "{{ old('bank_balance_id', $bankDeposit->bank_balance_id) }}";

            if (currentBankId) {
                bankSelect.value = currentBankId;
                updateBalanceDisplay(currentBankId);
            }
        });

        bankSelect.addEventListener('change', function() {
            updateBalanceDisplay(this.value);
        });

        // 🔥 Trigger on page load (VERY IMPORTANT FOR EDIT)
        window.addEventListener('load', function() {
            if (userSelect.value) {
                userSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
