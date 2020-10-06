@extends('admin.main')

@section('content')

<div id="app">

    <h2 class="h1 font-weight-bold">{{ $grup->nama }}</h2>
    <p>
        {{ $grup->deskripsi }}
    </p>

    <ul class="list-inline">
        <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
        <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
    </ul>

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

    <div class="box">
        <div class="card">
          <div class="table-responsive">
  
            <table class="table table-vcenter table-hover card-table">
  
              <thead>
                <tr>
                    <th width="40%">Nama Kelas</th>
                    <th>Pengampu</th>
                    <th class="w-2"></th>
                </tr>
              </thead>
  
              <tbody>
                    <tr>
                        <td>Bagian 1: Pendahuluan</td>
                        <td>Belum ada</td>
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

  
              </tbody>
  
            </table>
  
          </div>
        </div>
    </div>

    @include('admin.general._new-item-modal')

</div>
@endsection


@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush