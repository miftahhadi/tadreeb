@extends('admin.main')

@section('content')
    <div id="app">
        <h2 class="h1 font-weight-bold">{{ $kelas->nama }}</h2>
        
        <p>
            {{ $kelas->deskripsi }}
        </p>

        <ul class="list-inline">
            <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
            <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
        </ul>

        <div> <!-- Satu div ini ubah jadi komponen vue--> 
            
            <ul class="nav nav-tabs">
                @foreach ($service->getNavMenu() as $key => $menu)
                    <li class="nav-item">
                        <a href="#{{ strtolower($menu) }}" 
                            class="nav-link @if ($key == 0) active @endif" 
                            data-toggle="tab"
                        >{{ $menu }}</a>
                    </li>
                @endforeach

            </ul>

            <div class="tab-content">
                @include('admin.classroom._ikhtisar')

                @include('admin.classroom._pelajaran')
        
                @include('admin.classroom._ujian')
        
                @include('admin.classroom._anggota')

                @include('admin.classroom._setting')
            </div>

        </div>

    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush