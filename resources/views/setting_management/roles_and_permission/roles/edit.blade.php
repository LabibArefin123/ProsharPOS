@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user-shield text-primary"></i> Edit Role: <span class="text-info">{{ $role->name }}</span></h1>
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-warning">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('roles.update', $role->id) }}">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong><i class="fas fa-edit"></i> Role Information</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required
                        value="{{ old('name', $role->name) }}">
                </div>
            </div>
        </div>

        <div class="mt-4">
            @forelse ($permissions as $group => $groupPermissions)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0 text-uppercase text-primary">
                            <i class="fas fa-folder-open"></i> {{ ucfirst($group) }}
                        </h5>
                        <div class="d-flex gap-2 ml-auto">
                            <button type="button" class="btn btn-sm btn-outline-primary select-all-btn"
                                data-group="{{ \Illuminate\Support\Str::slug($group) }}" title="Select All">
                                <i class="fas fa-check-double"></i> Select All
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger unselect-all-btn"
                                data-group="{{ \Illuminate\Support\Str::slug($group) }}" title="Unselect All">
                                <i class="fas fa-times-circle"></i> Unselect All
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($groupPermissions as $permission)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            class="form-check-input perm-{{ \Illuminate\Support\Str::slug($group) }}"
                                            id="perm_{{ $permission->id }}"
                                            {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">No permissions available to assign.</div>
            @endforelse
        </div>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Update Role
            </button>
        </div>
    </form>

@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-all-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const group = this.getAttribute('data-group');
                    document.querySelectorAll(`.perm-${group}`).forEach(cb => cb.checked = true);
                });
            });

            document.querySelectorAll('.unselect-all-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const group = this.getAttribute('data-group');
                    document.querySelectorAll(`.perm-${group}`).forEach(cb => cb.checked = false);
                });
            });
        });
    </script>
@stop
