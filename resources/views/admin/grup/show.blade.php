@extends('admin.main')

@section('content')

<div id="app">

    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.grup.index') }}">Grup</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">
            {{ $grup->nama }}
        </a></li>
    </ol>

    <div>
        <h2 class="h1 font-weight-bold">{{ $grup->nama }}</h2>
        <p>
            {{ $grup->deskripsi }}
        </p>
    
        <ul class="list-inline">
            <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
            <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
        </ul>
    </div>


    <div class="row mb-2">
        <div class="col-auto">
            <h2>Daftar Kelas</h2>
        </div>    
        <div class="col-auto ml-auto">
    
            <button type="button" 
                    class="btn btn-primary" 
                    data-toggle="modal" 
                    data-target="#tambahBaru">
                <i class="fe fe-plus-circle"></i> Buat Kelas Baru
            </button>  
    
        </div>
    </div>

    <item-index
        item="{{ $item }}"
        fetch-url="{{ $fetchUrl }}"
        :table-heading="{{ $tableHeading }}"
        :item-properties="{{ $itemProperties }}"
        item-url="{{ $itemUrl }}"
      ></item-index>

    @include('admin.general._new-item-modal')

</div>
@endsection


@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush