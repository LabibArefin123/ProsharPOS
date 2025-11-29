@extends('adminlte::page')

@section('title', 'Add Role')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Add New Role</h1>
        <a href="javascript:history.back()" class="btn btn-warning btn-sm d-flex align-items-center gap-1">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('roles.store') }}">
        @csrf

        {{-- Role Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-tag"></i> Role Information</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="role">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Admin, HR, Manager"
                        required>
                </div>
            </div>
        </div>

        {{-- Permissions Group --}}
        <div class="mb-4">
            <h4 class="text-secondary"><i class="fas fa-shield-alt"></i> Assign Permissions (Grouped by Controller)</h4>
        </div>

        @forelse ($routes as $controller => $controllerRoutes)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0 text-uppercase text-primary">
                        <i class="fas fa-folder-open"></i> {{ ucfirst($controller) }}
                    </h5>
                    <div class="d-flex gap-2 ml-auto">
                        <button type="button" class="btn btn-sm btn-outline-primary select-all-btn"
                            data-controller="{{ \Illuminate\Support\Str::slug($controller) }}">
                            <i class="fas fa-check-double"></i> Select All
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 5%;">Select</th>
                                    <th style="width: 35%;">Permission (Route Name)</th>
                                    <th style="width: 45%;">URI</th>
                                    <th style="width: 15%;">Guard</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($controllerRoutes as $route)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $route->getName() }}"
                                                id="perm_{{ $route->getName() }}"
                                                class="perm-checkbox-{{ \Illuminate\Support\Str::slug($controller) }}">
                                        </td>
                                        <td>
                                            <label for="perm_{{ $route->getName() }}"
                                                class="mb-0">{{ $route->getName() }}</label>
                                        </td>
                                        <td><code>{{ $route->uri() }}</code></td>
                                        <td><span class="badge bg-secondary">web</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">No available routes with named permissions.</div>
        @endforelse

        <div class="text-end">
            <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-save"></i> Save Role
            </button>
        </div>
    </form>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-all-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const controller = this.getAttribute('data-controller');
                    document.querySelectorAll(`.perm-checkbox-${controller}`).forEach(cb => cb
                        .checked = true);
                });
            });
        });
    </script>
@endsection
