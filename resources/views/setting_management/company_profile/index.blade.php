@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Company List</h3>
        <a href="{{ route('companies.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-plus" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Shipping Inside</th>
                        <th>Shipping Outside</th>
                        <th>Currency</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($company->logo)
                                        <img src="{{ asset('uploads/images/setting_management/company_profile/' . $company->logo) }}"
                                            width="50">
                                    @endif
                                </td>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->contact_number }}</td>
                                <td>{{ $company->shipping_charge_inside }}</td>
                                <td>{{ $company->shipping_charge_outside }}</td>
                                <td>{{ $company->currency_symbol }}</td>
                                <td>
                                    <a href="{{ route('companies.edit', $company->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ route('companies.show', $company->id) }}"
                                        class="btn btn-sm btn-warning">View</a>
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@stop
