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

    <div class="row mb-2">
        <div class="col-auto">
            <h2>Daftar Soal</h2>
        </div>    
        <div class="col-auto ml-auto">
    
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahSoal">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>    
                </span> 
                Buat Soal Baru
            </button>  
    
        </div>
    </div>

    <div class="box">
        <div class="card">
          <div class="table-responsive">
  
            <table class="table table-vcenter table-hover card-table">
  
              <thead>
                <tr>
                    <th class="w-1">No</th>
                    <th width="50%">Soal</th>
                    <th>Tipe</th>
                    <th class="w-2"></th>
                </tr>
              </thead>
  
              <tbody>
  
                @forelse ($ujian->questions as $key => $question)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{!! $question->konten !!}</td>
                        <td>{{ $question->tipe }}</td>
                        <td class="text-right">
                            <div class="btn-list flex-nowrap">
                                {{-- <show-question-button soal-id="{{ $question->id }}" exam-id="{{ $ujian->id }}"></show-question-button> --}}
                                <a href="{{ route('admin.ujian.soal.edit', ['ujian' => $ujian->slug, 'soal' => $question->id]) }}" class="btn btn-light btn-sm">Edit</a>

                                {{-- <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#unlinkSoal" data-soal="{{ $question->id }}">Buang</a> --}}

                                <form action="{{ route('admin.ujian.soal.unassign', ['ujian' => $ujian->slug]) }} " method="post">
                                    @csrf

                                    <input type="hidden" name="soal" value="{{ $question->id }}">
                                    <input type="submit" class="btn btn-danger btn-sm" value="Hapus">
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="4">Belum ada soal</td>
                </tr>
                @endforelse
  
              </tbody>
  
            </table>
  
          </div>
        </div>
    </div>

    <!-- Tambah Soal -->
    @include('admin.exam._new-question-modal')

    <script>
        function showChoices(that) {
          if (that.value == "multiple" || that.value == "single") {
            document.getElementById("choices").disabled = false;
          } else {
            document.getElementById("choices").disabled = true;
          }
        }
    </script>
    
@endsection
