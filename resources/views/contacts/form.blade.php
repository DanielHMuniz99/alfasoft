@include("main")
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <h1>{{ isset($contact) ? 'Edit' : 'Add' }} Contact</h1>
                            <form method="POST" action="{{ isset($contact) ? route('contacts.update', $contact) : route('contacts.store', $person) }}">
                                @csrf
                                @if(isset($contact))
                                    @method('PUT')
                                @endif
                                <label>Country:</label>
                                <select id="country_code" name="country_code" class="form-control">
                                    @foreach ($countries as $code => $label)
                                        <option value="{{ $label['code'] }}" {{ (old('country_code', $contact->country_code ?? '') == $code) ? 'selected' : '' }}>
                                            {{ $label["name"] }} ({{ $label['code'] }})
                                        </option>
                                    @endforeach
                                </select>
                                <label>Number:</label>
                                <input class="form-control" type="text" name="number" value="{{ old('number', $contact->number ?? '') }}">
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
<script>
    $(document).ready(function() {
        $('#country_code').select2({
            placeholder: "Select a country",
            width: '100%'
        });
    });
</script>
@if ($errors->any())
<script>
    @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}", "Error");
    @endforeach
</script>
@endif
