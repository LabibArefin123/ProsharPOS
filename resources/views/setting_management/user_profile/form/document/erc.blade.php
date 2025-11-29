@php $ercIndex = 0; @endphp
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Export Registration Certificate (ERC) Information</h4>
    <button type="button" class="btn btn-success btn-sm" id="add-erc"
        @if (auth()->user()->role->name === 'demo') disabled @endif>+</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="erc-table">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>ERC License No</th>
                <th>Validity</th>
                <th>Financial Year</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="erc-wrapper">
            @foreach ($organization->documents->where('type', 'erc') ?? [] as $document)
                <tr class="erc-row">
                    <td>{{ $ercIndex + 1 }}</td>
                    <td>
                        <input type="hidden" name="documents[{{ $ercIndex }}][id]" value="{{ $document->id }}">
                        <input type="hidden" name="documents[{{ $ercIndex }}][type]" value="erc">
                        <input type="text" name="documents[{{ $ercIndex }}][number]" class="form-control"
                            value="{{ old('documents.' . $ercIndex . '.number', $document->number) }}">
                    </td>
                    <td>
                        <input type="date" name="documents[{{ $ercIndex }}][validity]" class="form-control"
                            value="{{ old('documents.' . $ercIndex . '.validity', $document->validity) }}">
                    </td>
                    <td>
                        <select name="documents[{{ $ercIndex }}][financial_year]"
                            id="financialYearSelect_{{ $ercIndex }}" class="form-control"
                            data-selected="{{ old('documents.' . $ercIndex . '.financial_year', $document->financial_year ?? '') }}"></select>
                    </td>
                    <td class="text-center">
                        @if ($document->document && file_exists(public_path('uploads/documents/company_documents/erc/' . $document->document)))
                            <a href="{{ asset('uploads/documents/company_documents/erc/' . $document->document) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> View Document
                            </a><br>
                        @else
                            <span class="text-muted">No file</span><br>
                        @endif
                        <input type="file" name="documents[{{ $ercIndex }}][document]"
                            class="form-control mt-2">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-bin">Remove</button>
                    </td>
                </tr>
                @php $ercIndex++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let ercIndex = {{ $ercIndex }};
        const maxRows = 15;

        function populateFinancialYearDropdown(select, selectedValue = null) {
            if (!select) return;
            select.innerHTML = '<option value="">Select Year</option>';
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year >= 1950; year--) {
                let option = document.createElement("option");
                option.value = `${year}-${year + 1}`;
                option.textContent = `${year}-${year + 1}`;
                if (selectedValue && selectedValue === option.value) option.selected = true;
                select.appendChild(option);
            }
        }

        // Populate existing selects
        document.querySelectorAll('#erc-wrapper.erc-row select').forEach(select => {
            populateFinancialYearDropdown(select, select.dataset.selected);
        });

        // Add new row
        document.getElementById('add-erc').addEventListener('click', function() {
            const rowCount = document.querySelectorAll('#erc-wrapper .erc-row').length;
            if (rowCount >= maxRows) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You are not allowed to give more than 15 documents',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const tbody = document.getElementById('erc-wrapper');
            const tr = document.createElement('tr');
            tr.classList.add('erc-row');

            tr.innerHTML = `
            <td></td>
            <td>
                <input type="hidden" name="documents[${ercIndex}][type]" value="erc">
                <input type="text" name="documents[${ercIndex}][number]" class="form-control">
            </td>
            <td>
                <input type="date" name="documents[${ercIndex}][validity]" class="form-control">
            </td>
            <td>
                <select name="documents[${ercIndex}][financial_year]" id="financialYearSelect_${ercIndex}" class="form-control"></select>
            </td>
            <td>
                <input type="file" name="documents[${ercIndex}][document]" class="form-control mt-1">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-bin">Remove</button>
            </td>
        `;

            tbody.appendChild(tr);
            populateFinancialYearDropdown(tr.querySelector('select'));
            ercIndex++;
            updateSL();
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-bin')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This trade document will be removed.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it'
                }).then(res => {
                    if (res.isConfirmed) {
                        e.target.closest('tr').remove();
                        updateSL();
                    }
                });
            }
        });

        function updateSL() {
            document.querySelectorAll('#erc-wrapper .erc-row').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        }
    });
</script>
