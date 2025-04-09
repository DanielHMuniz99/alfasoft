@include("main")
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <h1 class="mb-3">People List</h1>
                            @auth
                                <a href="{{ route('people.create') }}" class="btn btn-primary mb-3">Add New Person</a>
                            @endauth
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($people as $person)
                                        <tr>
                                            <td>{{ $person->name }}</td>
                                            <td>{{ $person->email }}</td>
                                            <td>
                                                @auth
                                                    <a href="{{ route('people.show', $person) }}" class="btn btn-sm btn-info">View</a>
                                                    <a href="{{ route('people.edit', $person) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('people.destroy', $person) }}" method="POST" style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                @endauth
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("footer")

@push('scripts')
<!-- DataTables -->

<script>
    $(document).ready(function () {
        // $('#people-table').DataTable();
    });
</script>
@endpush
