@include('layout.head')
<body>
    <div id="app">
        <div class="main-wrapper">
        @include('layout.nav')
        @include('layout.sidebar')
            <div class="main-content">
                <section class="section">
                    <div class="section-header justify-content-between">
                        <h1>@yield('title-content')</h1>
                        <div class="ml-auto">
                        </div>
                    </div>
                    @yield('body')
            </section>
            </div>
        </div>
    </div>
    @include('layout.footer')
        @if($errors->any("$errors"))
    @foreach ($errors->all() as $error)
        <script>
            iziToast.error({
                title: '',
                position: 'topRight',
                message: '{{ $error }}',
            });
        </script>
    @endforeach
    @endif
    @if(session()->get('success'))
    <script>
        iziToast.success({
            title: '',
            position: 'topRight',
            message:  '{{ session()->get('success') }}',
        });
        </script>
    @endif
</body>
</html>