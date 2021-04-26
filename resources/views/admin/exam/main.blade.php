@extends('admin.main')

@section('content')

    @include('admin._item-header')

    <div class="mt-4">
        <ul class="nav nav-tabs">
            
            <li class="nav-item">
                <a href="{{ route('admin.ujian.show', $ujian->id) }}" class="nav-link @if (strpos(Route::currentRouteName(), 'show')) active @endif">Soal</a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.ujian.kelas', $ujian->id) }}" class="nav-link @if (strpos(Route::currentRouteName(), 'kelas')) active @endif">Kelas</a>
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
