@extends('layouts.base')

@section('main')

<div class="page">

    @include('front._header')

    <div class="content">

        <div class="container-xl">

            <div class="d-flex justify-content-center mb-6">

                <div class="col-md-10">

                    <div class="mb-2">
                        <span class="text-muted">
                            <a href="{{ route('dashboard') }}" class="link-secondary">Kembali ke Dashboard</a> 
                        </span>
                    </div>

                    @include('front.kelas._kelas-info')

                    <ul class="nav nav-tabs justify-content-center bg-white rounded-lg">
                        @foreach ($service->nav as $nav)
                            <li class="nav-item">
                                <a href="{{ route($nav['route'], $kelas->kode) }}" 
                                    class="nav-link @if(Route::currentRouteName() == $nav['route']) active @endif" 
                                    data-toggle="tab"
                                >{{ $nav['judul'] }}</a>
                            </li>                            
                        @endforeach
                    </ul>

                    <div class="mt-4">

                        @yield('content')

                    </div>

                </div>
            
            </div>

        </div>

    </div>

</div>


@endsection