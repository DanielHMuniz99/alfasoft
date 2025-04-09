@include("main")
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row mb-4">
                                <div class="col-md-4 text-center">
                                    <div class="profile-img">
                                        <img src="{{ $person->avatar }}" alt="" class="img-fluid rounded-circle" style="max-width: 150px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="profile-head">
                                        <h4>{{ $person->name }}</h4>
                                        <h6 class="text-muted">{{ $person->email }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-start justify-content-end">
                                    @auth
                                        <a class="btn btn-primary" href="{{ route('people.edit', $person) }}">Edit Profile</a>
                                    @endauth
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5>Contacts</h5>
                                        @auth
                                            <a href="{{ route('contacts.create', ['person' => $person->id]) }}" class="btn btn-sm btn-success">
                                                Add Contact
                                            </a>
                                        @endauth
                                    </div>

                                    @if($person->contacts->isEmpty())
                                        <p class="text-muted">No contacts registered.</p>
                                    @else
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($person->contacts as $contact)
                                                    <tr>
                                                        <td class="align-middle">({{ $contact->country_code }}) {{ $contact->number }}</td>
                                                        <td class="align-middle">
                                                            <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-warning">Edit</a>
                                                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("footer")
