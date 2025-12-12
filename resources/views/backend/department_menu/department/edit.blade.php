@extends('adminlte::page')

@section('title', 'Edit Department')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Department</h3>
        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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

                <form action="{{ route('departments.update', $department->id) }}" method="POST" data-confirm="edit">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        {{-- Branch --}}
                        <div class="col-md-6 form-group">
                            <label for="branch_id"><strong>Branch</strong> <span class="text-danger">*</span></label>
                            <select name="branch_id" id="branch_id"
                                class="form-control @error('branch_id') is-invalid @enderror">
                                <option value="">-- Select Branch --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ old('branch_id', $department->branch_id) == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Division --}}
                        <div class="col-md-6 form-group">
                            <label for="division_id"><strong>Division Name</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="division_id" name="division_id" class="form-control">
                                <option value="">-- Select Division --</option>
                            </select>
                            @error('division_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Department Code --}}
                        <div class="col-md-6 form-group">
                            <label for="dept_code"><strong>Department Code</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="dept_code" id="dept_code"
                                class="form-control @error('dept_code') is-invalid @enderror"
                                value="{{ old('dept_code', $department->dept_code) }}" placeholder="Enter department code">
                            @error('dept_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Department Name --}}
                        <div class="col-md-6 form-group">
                            <label for="name"><strong>Name</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $department->name) }}" placeholder="Enter department name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6 form-group">
                            <label for="phone"><strong>Phone</strong> <span class="text-danger">*</span></label>
                            <input type="number" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $department->phone) }}" placeholder="Enter phone number">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 form-group">
                            <label for="email"><strong>Email</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $department->email) }}" placeholder="Enter email address">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6 form-group">
                            <label for="address"><strong>Address</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address', $department->address) }}" placeholder="Enter address">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Contact Person --}}
                        <div class="col-md-6 form-group">
                            <label for="contact_person"><strong>Contact Person</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="contact_person" id="contact_person"
                                class="form-control @error('contact_person') is-invalid @enderror"
                                value="{{ old('contact_person', $department->contact_person) }}"
                                placeholder="Enter contact person name">
                            @error('contact_person')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Contact Phone --}}
                        <div class="col-md-6 form-group">
                            <label for="contact_phone"><strong>Contact Phone</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="contact_phone" id="contact_phone"
                                class="form-control @error('contact_phone') is-invalid @enderror"
                                value="{{ old('contact_phone', $department->contact_phone) }}"
                                placeholder="Enter contact phone">
                            @error('contact_phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            var oldBranchId = '{{ old('branch_id', $department->branch_id) }}';
            var oldDivisionId = '{{ old('division_id', $department->division_id) }}';

            function loadDivisions(branchId, selectedDivisionId = null) {
                if (branchId) {
                    $.ajax({
                        url: '{{ route('ajax.getDivisionByBranch') }}',
                        type: 'GET',
                        data: {
                            branch_id: branchId
                        },
                        success: function(data) {
                            $('#division_id').html('<option value="">-- Select Division --</option>');
                            $.each(data, function(key, value) {
                                let selected = (value.id == selectedDivisionId) ? 'selected' :
                                    '';
                                $('#division_id').append('<option value="' + value.id + '" ' +
                                    selected + '>' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#division_id').html('<option value="">-- Select Division --</option>');
                }
            }

            // Load divisions on page load (for edit page)
            loadDivisions(oldBranchId, oldDivisionId);

            // Reload divisions when branch changes
            $('#branch_id').on('change', function() {
                var branchID = $(this).val();
                loadDivisions(branchID);
            });
        });
    </script>
@endsection
