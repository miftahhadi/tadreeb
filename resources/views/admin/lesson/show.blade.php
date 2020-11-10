@extends('admin.main')

@section('content')
<div id="app">

    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pelajaran.index') }}">Pelajaran</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">
            {{ $pelajaran->judul }}
        </a></li>
    </ol>

    <h2 class="h1 font-weight-bold">{{ $pelajaran->judul }}</h2>
    <p>
        {{ $pelajaran->deskripsi }}
    </p>

    <ul class="list-inline">
        <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
        <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
    </ul>

    <div class="row mb-2">
        <div class="col-auto">
            <h2>Konten Pelajaran</h2>
        </div>    
        <div class="col-auto ml-auto">
    
            <button type="button" 
                    class="btn btn-primary" 
                    data-toggle="modal" 
                    data-target="#tambahBaru"
            >

              <i class="fas fa-plus"></i> 
              <span class="ml-2">Tambah Section Baru</span>
            
            </button>
    
        </div>
    </div>

    <div class="box">
        <div class="card">
          <div class="table-responsive">
  
            <table class="table table-vcenter table-hover card-table">
  
              <thead>
                <tr>
                    <th>Judul Bagian</th>
                    <th class="w-2"></th>
                </tr>
              </thead>
  
              <tbody>
  
                @forelse ($sections as $key => $section)
                    <tr>
                        <td>{{ $section->judul }}</td>
                        <td class="text-right">
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('admin.section.show', ['pelajaran' => $pelajaran->slug, 'section' => $section->id]) }}" class="btn btn-light btn-sm">Buka</a>
                                <a href="#" class="btn btn-light btn-sm">Edit</a>

                                <form action="" method="post">
                                    @csrf

                                    <input type="hidden" name="soal" value="">
                                    <input type="submit" class="btn btn-danger btn-sm" value="Hapus">
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada konten pelajaran</td>
                    </tr>
                @endforelse
  
              </tbody>
  
            </table>
  
          </div>
        </div>
    </div>

    <div class="modal fade" 
        id="tambahBaru" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="tambahBaruLabel" 
        aria-hidden="true"
    >

        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ ucfirst($item)}} Baru</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>

            </div>
            
            <div class="modal-body">
                    
                <item-baru-form 
                    judul="{{ $judul }}" 
                    item="{{ $item }}" 
                    action="{{ $action }}" 
                >
                    @csrf
                
                </item-baru-form>
                    
            </div>
            </div>
        </div>
    </div>
   
</div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush

