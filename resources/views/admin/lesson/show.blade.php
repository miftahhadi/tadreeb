@extends('admin.main')

@section('content')

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
    
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahSoal">
                <i class="fe fe-plus-circle"></i> Buat Soal Baru
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
  
                {{-- @forelse ($ujian->questions as $key => $question) --}}
                    <tr>
                        <td>Bagian 1: Pendahuluan</td>
                        <td class="text-right">
                            <div class="btn-list flex-nowrap">
                                {{-- <show-question-button soal-id="{{ $question->id }}" exam-id="{{ $ujian->id }}"></show-question-button> --}}
                                <a href="" class="btn btn-light btn-sm">Edit</a>

                                {{-- <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#unlinkSoal" data-soal="{{ $question->id }}">Buang</a> --}}

                                <form action="" method="post">
                                    @csrf

                                    <input type="hidden" name="soal" value="">
                                    <input type="submit" class="btn btn-danger btn-sm" value="Hapus">
                                </form>

                            </div>
                        </td>
                    </tr>
                {{-- @empty
                <tr>
                    <td colspan="4">Belum ada soal</td>
                </tr>
                @endforelse --}}
  
              </tbody>
  
            </table>
  
          </div>
        </div>
    </div>
   
@endsection
