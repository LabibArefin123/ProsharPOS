@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <h1>Companies</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('companies.create') }}" class="btn btn-primary">+ Add Company</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
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

            <div class="mt-3">
                {{ $companies->links() }}
            </div>
        </div>
    </div>
@stop
@section('js')
    @if (session('success') || session('error') || session('warning') || session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                @if (session('success'))
                    Toast.fire({
                        icon: 'success',
                        title: @json(session('success'))
                    });
                @elseif (session('error'))
                    Toast.fire({
                        icon: 'error',
                        title: @json(session('error'))
                    });
                @elseif (session('warning'))
                    Toast.fire({
                        icon: 'warning',
                        title: @json(session('warning'))
                    });
                @elseif (session('info'))
                    Toast.fire({
                        icon: 'info',
                        title: @json(session('info'))
                    });
                @endif
            });
        </script>
    @endif
@endsection
