@extends('adminlte::page')

@section('title', 'Edit Bank Withdraw')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <h3 class="mb-0">Edit Bank Withdraw</h3>

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

            <a href="{{ route('bank_withdraws.index') }}"
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

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bank_withdraws.update', $bankWithdraw->id) }}" method="POST" data-confirm="edit">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- User --}}
                    <div class="col-md-6 form-group">
                        <label><strong>User</strong></label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}"
                                    {{ $bankWithdraw->user_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Bank Balance --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Bank Balance</strong></label>
                        <select name="bank_balance_id" id="bank_balance_id" class="form-control">
                            <option value="">Select Bank Balance</option>
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Withdraw Amount (BDT)</strong></label>
                        <input type="number" step="0.01" name="amount" class="form-control"
                            value="{{ $bankWithdraw->amount }}">
                    </div>

                    {{-- Date --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Withdraw Date</strong></label>
                        <input type="date" name="withdraw_date" class="form-control"
                            value="{{ $bankWithdraw->withdraw_date }}">
                    </div>

                    {{-- Method --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Withdraw Method</strong></label>
                        <select name="withdraw_method" class="form-control">
                            <option value="cash" {{ $bankWithdraw->withdraw_method == 'cash' ? 'selected' : '' }}>
                                Cash</option>
                            <option value="bank_transfer"
                                {{ $bankWithdraw->withdraw_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                            </option>
                            <option value="cheque" {{ $bankWithdraw->withdraw_method == 'cheque' ? 'selected' : '' }}>
                                Cheque</option>
                            <option value="mobile_banking"
                                {{ $bankWithdraw->withdraw_method == 'mobile_banking' ? 'selected' : '' }}>Mobile
                                Banking</option>
                        </select>
                    </div>

                    {{-- Reference --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Reference</strong></label>
                        <input type="text" name="reference_no" class="form-control"
                            value="{{ $bankWithdraw->reference_no }}">
                    </div>

                    {{-- Note --}}
                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control" rows="3">{{ $bankWithdraw->note }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-warning">Update</button>
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

            const userBanks = balances.filter(
                b => b.user_id == selectedUserId
            );

            bankSelect.innerHTML =
                '<option value="">Select Bank Balance</option>';

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

            // 🔥 Re-select correct bank
            const currentBankId =
                "{{ old('bank_balance_id', $bankWithdraw->bank_balance_id) }}";

            if (currentBankId) {
                bankSelect.value = currentBankId;
                updateBalanceDisplay(currentBankId);
            }

        });

        bankSelect.addEventListener('change', function() {
            updateBalanceDisplay(this.value);
        });

        // Trigger on page load
        window.addEventListener('load', function() {
            if (userSelect.value) {
                userSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
