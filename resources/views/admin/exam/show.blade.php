@extends('admin.main')

@section('content')

    {{-- Konten --}}

    <h2 class="h1 font-weight-bold">{{ $ujian->judul }}</h2>
    <p>{{ $ujian->deskripsi }}</p>

    <ul class="list-inline">
        <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
        <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
    </ul>

    <div class="row mb-2">
        <div class="col-auto">
            <h2>Daftar Soal</h2>
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
                                <a href="{{ route('ujian.soal.edit', ['ujian' => $ujian->slug, 'soal' => $question->id]) }}" class="btn btn-light btn-sm">Edit</a>

                                {{-- <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#unlinkSoal" data-soal="{{ $question->id }}">Buang</a> --}}

                                <form action="{{ route('ujian.soal.unassign', ['ujian' => $ujian->slug]) }} " method="post">
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
    <div class="modal fade" 
        id="tambahSoal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="tambahSoalLabel" 
        aria-hidden="true"
    >
        <div class="modal-dialog modal-sm" role="document">
            <form action="{{ route('ujian.soal.create', ['ujian' => $ujian->slug]) }}" method="get">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih tipe soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"></path>
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                            @foreach($questionTypes as $question)
                            <label class="form-selectgroup-item flex-fill">
                                <input type="radio" name="type" value="{{ $question['value'] }}" class="form-selectgroup-input" onclick="showChoices(this);">
                                <div class="form-selectgroup-label d-flex align-items-center p-3">
                                    <div class="mr-3">
                                        <span class="form-selectgroup-check"></span>
                                    </div>
                                    <span class="form-selectgroup-label-content">
                                        <span>{{ $question['type'] }}</span>
                                    </span>
                                </div>
                            </label>
                            @endforeach

                            <div class="mt-2">
                                <label for="choices" class="form-label">Jumlah pilihan</label>
                                <input type="number" class="form-control" name="choices" id="choices" value="4" disabled>
                            </div>

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Tambah Soal">
                    </div>
                </div>
            </form>
        </div>
    </div>

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
