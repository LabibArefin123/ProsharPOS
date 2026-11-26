{{--  Permissions DataTable --}}
<div class="table-responsive">
    <table id="dataTables" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="select-all" title="Select All">
                </th>

                <th>SL</th>
                <th>Permission Name</th>
                <th class="text-center"> Guard </th>
                <th class="text-center"> Actio </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>
                        <input type="checkbox" class="row-checkbox" value="{{ $permission->id }}">
                    </td>
                    <td>{{ $loop->iteration }} </td>
                    <td> {{ $permission->name }}</td>
                    <td class="text-center"> {{ $permission->guard_name }}</td>
                    <td class="text-center">
                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm">

                            Edit
                        </a>
                        <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-warning btn-sm">

                            Show
                        </a>

                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this permission?')">

                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
