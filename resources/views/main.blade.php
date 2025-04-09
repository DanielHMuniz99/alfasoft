@include('head')
<body id="body">
    <section class="tabs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-outer">
                        <div class="tab-list">
                            <ul>
                                <li>
                                    <a href="{{ route('people.index') }}">
                                        <img style="height: 50px;" src="{{ asset('images/laravel.svg') }}" alt="Home">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>