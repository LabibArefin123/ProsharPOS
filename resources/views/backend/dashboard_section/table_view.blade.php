@extends('adminlte::page')

@section('title', 'View Table')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h4>📄 Table: {{ $table }}</h4>
        <a href="{{ route('dashboard.system') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <style>
            pre {
                font-size: 13px;
                color: #333;
            }
        </style>
        <div class="card-body table-responsive">
            <!-- JSON VIEW MODAL -->
            <div class="modal fade" id="jsonModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">JSON Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <pre id="jsonContent" class="bg-light p-3 rounded"></pre>
                        </div>

                    </div>
                </div>
            </div>
            <table id="dynamicTable" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr id="table-head">
                        <!-- Dynamic columns -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            let tableName = "{{ $table }}";
            let ajaxUrl = "{{ route('dashboard.system.table.view', ':table') }}"
                .replace(':table', tableName);

            $.get(ajaxUrl, function(res) {

                let columns = [];
                let headers = '';

                if (res.data.length > 0) {

                    let keys = Object.keys(res.data[0]);

                    keys.forEach(function(key) {

                        headers += `<th>${key}</th>`;

                        // ✅ SPECIAL RENDER FOR JSON FIELD
                        if (key === 'properties') {

                            columns.push({
                                data: key,
                                name: key,
                                render: function(data, type, row) {

                                    if (!data) return '';

                                    let shortText = '';

                                    try {
                                        let json = typeof data === 'string' ? JSON
                                            .parse(data) : data;
                                        shortText = JSON.stringify(json).substring(0,
                                            50) ;
                                    } catch (e) {
                                        shortText = data.substring(0, 50) + '...';
                                    }

                                    return `
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>${shortText}</span>
                                    <button class="btn btn-sm btn-light view-json"
                                        data-json='${JSON.stringify(data)}'>
                                        ⋮
                                    </button>
                                </div>
                            `;
                                }
                            });

                        } else {
                            columns.push({
                                data: key,
                                name: key
                            });
                        }

                    });

                    $('#table-head').html(headers);

                    $('#dynamicTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: ajaxUrl,
                        columns: columns,
                        pageLength: 10,
                        responsive: true,
                    });
                }
            });

        });
    </script>
    <script>
        $(document).on('click', '.view-json', function() {

            let rawData = $(this).attr('data-json');

            try {
                let parsed = typeof rawData === 'string' ? JSON.parse(rawData) : rawData;

                $('#jsonContent').text(JSON.stringify(parsed, null, 4));
            } catch (e) {
                $('#jsonContent').text(rawData);
            }

            let modal = new bootstrap.Modal(document.getElementById('jsonModal'));
            modal.show();
        });
    </script>
@endsection
