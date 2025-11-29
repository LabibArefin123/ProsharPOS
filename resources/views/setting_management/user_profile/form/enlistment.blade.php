<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Company Enlistments</h4>
    <button type="button" class="btn btn-success btn-sm" id="add-enlistment"
        @if (auth()->user()->role->name === 'demo') disabled @endif>
        + Add Enlistment
    </button>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="enlistments-table">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>Customer Name</th>
                <th>Validity</th>
                <th>Security Deposit</th>
                <th>Financial Year</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="enlistments-wrapper">
            @forelse($organization->enlistments as $key => $enlistment)
                <tr class="enlistment-row">
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <input type="hidden" name="enlistments[{{ $key }}][id]" value="{{ $enlistment->id }}">
                        @if (auth()->user()->role->name === 'demo')
                            <span>{{ $enlistment->customer_name }}</span>
                        @else
                            <input type="text" name="enlistments[{{ $key }}][customer_name]"
                                class="form-control"
                                value="{{ old('enlistments.' . $key . '.customer_name', $enlistment->customer_name) }}">
                        @endif
                    </td>

                    <td>
                        @if (auth()->user()->role->name === 'demo')
                            <span>{{ $enlistment->validity }}</span>
                        @else
                            <input type="date" name="enlistments[{{ $key }}][validity]" class="form-control"
                                value="{{ old('enlistments.' . $key . '.validity', $enlistment->validity) }}">
                        @endif
                    </td>

                    <td>
                        @if (auth()->user()->role->name === 'demo')
                            <span>{{ $enlistment->security_deposit }}</span>
                        @else
                            <input type="number" name="enlistments[{{ $key }}][security_deposit]"
                                class="form-control"
                                value="{{ old('enlistments.' . $key . '.security_deposit', $enlistment->security_deposit) }}">
                        @endif
                    </td>

                    <td>
                        @if (auth()->user()->role->name === 'demo')
                            <span>{{ $enlistment->financial_year }}</span>
                        @else
                            {{-- Store the selected value in a data attribute so JS can read it --}}
                            <select name="enlistments[{{ $key }}][financial_year]"
                                id="financialYearSelect_{{ $key }}" class="form-control"
                                data-selected="{{ old('enlistments.' . $key . '.financial_year', $enlistment->financial_year) }}">
                            </select>
                        @endif
                    </td>

                    <td class="text-center">
                        @if ($enlistment->document && file_exists(public_path('uploads/documents/users/enlistments/' . $enlistment->document)))
                            <a href="{{ asset('uploads/documents/users/enlistments/' . $enlistment->document) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> View Document
                            </a><br>
                        @else
                            <span class="text-muted">No file</span><br>
                        @endif

                        @if (auth()->user()->role->name !== 'demo')
                            <input type="file" name="enlistments[{{ $key }}][document]"
                                class="form-control mt-2">
                        @endif
                    </td>

                    <td>
                        @if (auth()->user()->role->name !== 'demo')
                            <button type="button" class="btn btn-danger btn-sm remove-enlistment">Remove</button>
                        @endif
                    </td>
                </tr>
            @empty
                {{-- No enlistments --}}
            @endforelse
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let enlistmentIndex = {{ $organization->enlistments->count() ?? 0 }};

        // Generate financial year dropdown
        function populateFinancialYearDropdown(select, selectedValue = null) {
            if (!select) return;
            select.innerHTML = '<option value="">Select Year</option>';
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year >= 1950; year--) {
                let option = document.createElement("option");
                option.value = `${year}-${year+1}`;
                option.textContent = `${year}-${year+1}`;
                if (selectedValue && selectedValue == option.value) {
                    option.selected = true;
                }
                select.appendChild(option);
            }
        }

        // Initialize existing rows (use data-selected instead of Blade vars in JS)
        document.querySelectorAll('#enlistments-wrapper .enlistment-row select').forEach((sel) => {
            populateFinancialYearDropdown(sel, sel.dataset.selected);
        });

        // Add new enlistment
        document.getElementById('add-enlistment').addEventListener('click', function() {
            Swal.fire({
                title: 'Add Enlistment',
                html: `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Customer Name</label>
                            <input type="text" id="swal_customer_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Validity</label>
                            <input type="date" id="swal_validity" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Security Deposit</label>
                            <input type="number" id="swal_security_deposit" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Financial Year</label>
                            <select id="swal_financial_year" class="form-control"></select>
                        </div>
                        <div class="col-md-6">
                            <label>Document</label>
                            <input type="file" id="swal_document" class="form-control">
                        </div>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Save',
                didOpen: () => {
                    populateFinancialYearDropdown(document.getElementById(
                        "swal_financial_year"));
                },
                preConfirm: () => {
                    return {
                        customer_name: document.getElementById('swal_customer_name').value,
                        validity: document.getElementById('swal_validity').value,
                        security_deposit: document.getElementById('swal_security_deposit')
                            .value,
                        financial_year: document.getElementById('swal_financial_year')
                            .value,
                        document: document.getElementById('swal_document').files[0] || null
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = result.value;
                    const tbody = document.getElementById('enlistments-wrapper');
                    const tr = document.createElement('tr');
                    tr.classList.add('enlistment-row');

                    const fileName = data.document ? data.document.name : 'No file';

                    tr.innerHTML = `
                        <td></td>
                        <td><input type="text" name="enlistments[${enlistmentIndex}][customer_name]" class="form-control" value="${data.customer_name}"></td>
                        <td><input type="date" name="enlistments[${enlistmentIndex}][validity]" class="form-control" value="${data.validity}"></td>
                        <td><input type="number" name="enlistments[${enlistmentIndex}][security_deposit]" class="form-control" value="${data.security_deposit}"></td>
                        <td><select name="enlistments[${enlistmentIndex}][financial_year]" id="financialYearSelect_${enlistmentIndex}" class="form-control"></select></td>
                        <td>
                            <input type="file" name="enlistments[${enlistmentIndex}][document]" class="form-control mt-1">
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-enlistment">Remove</button></td>
                    `;


                    tbody.appendChild(tr);

                    // Populate financial year for new row
                    populateFinancialYearDropdown(tr.querySelector('select'), data
                        .financial_year);

                    enlistmentIndex++;
                    updateEnlistmentSL();
                }
            });
        });

        // Remove enlistment
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-enlistment')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This enlistment will be removed.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it'
                }).then((res) => {
                    if (res.isConfirmed) {
                        e.target.closest('tr').remove();
                        updateEnlistmentSL();
                    }
                });
            }
        });

        // Update SL and input names
        function updateEnlistmentSL() {
            const rows = document.querySelectorAll('#enlistments-wrapper .enlistment-row');
            rows.forEach((row, index) => {
                row.querySelectorAll('input, select').forEach(input => {
                    let name = input.getAttribute('name');
                    if (name) {
                        name = name.replace(/enlistments\[\d+\]/, `enlistments[${index}]`);
                        input.setAttribute('name', name);
                    }
                    if (input.tagName.toLowerCase() === 'select') {
                        input.setAttribute('id', `financialYearSelect_${index}`);
                    }
                });

            });
        }
    });
</script>
