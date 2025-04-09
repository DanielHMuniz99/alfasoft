@include("main")
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <h1>{{ isset($person) ? 'Edit' : 'Add' }} Person</h1>
                            <form method="POST" action="{{ isset($person) ? route('people.update', $person) : route('people.store') }}">
                                @csrf
                                @if(isset($person))
                                    @method('PUT')
                                @endif
                                <label>Name:</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $person->name ?? '') }}"
                                >

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label>Email:</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $person->email ?? '') }}"
                                >

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <hr>
                                <button type="submit" class="form-control btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("footer")
@if ($errors->any())
<script>
    @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}", "Error");
    @endforeach
</script>
@endif
