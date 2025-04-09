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

                            @if($people->count() > 0)
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
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    @endauth
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info">
                                    No people found. Would you like to <a href="{{ route('people.create') }}" class="alert-link">add the first one</a>?
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("footer")