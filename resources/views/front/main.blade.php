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