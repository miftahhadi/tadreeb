@extends('layouts.base')

@section('main')
    <div class="page">
                
        @include('front._header')

        <div class="content">
            <div class="container-xl py-4">

                <div class="row">

                    <div class="col-md-2 d-none d-md-block">

                        @include('front._sidebar')

                    </div>

                    <div class="col-md-10 pl-4">
                        @yield('content')
                    </div>

                </div>

            </div>
        </div>

        @include('front._footer')
        
    </div>
@endsection

@prepend('js')
    <!-- Libs JS -->
    <script src="/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tabler Core -->
    <script src="/dist/js/tabler.min.js"></script>
@endprepend