@extends('layouts.base')

@section('main')
    <div class="page">
                
        @include('front._header')

        <div class="content">

            <div class="container-xl py-4">

                @yield('content')

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