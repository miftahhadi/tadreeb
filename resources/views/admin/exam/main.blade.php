@extends('admin.main')

@section('content')

    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.ujian.index') }}">Ujian</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">
            {{ $ujian->judul }}
        </a></li>
    </ol>

    <div>
        <h2 class="h1 font-weight-bold">{{ $ujian->judul }}</h2>
        <p>{!! $ujian->deskripsi !!}</p>
    
        <ul class="list-inline">
            <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
            <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
        </ul>
    </div>

    <div class="mt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="{{ route('admin.ujian.show', $ujian->slug) }}" class="nav-link @if (strpos(Route::currentRouteName(), 'show')) active @endif">Konten</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.ujian.hasil', $ujian->slug) }}" class="nav-link @if (strpos(Route::currentRouteName(), 'hasil')) active @endif">Hasil</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Pengaturan</a>
            </li>
        </ul>

        <div class="content-tab mt-4">
            <div class="tab-pane">
                
                @yield('examContent')

            </div>
        </div>
    </div>

    @yield('newQuestion')
    
@endsection
