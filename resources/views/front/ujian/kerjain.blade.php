@extends('layouts.front')

@section('page')
<div class="row d-flex justify-content-center">
    <div class="page-header mb-4">
    
        <h2 class="h1">{{ $exam->judul }}</h2>

    </div>
    <div class="col-md-7">
        <form action="{{ route('ujian.storeJawaban', ['kelas' => $kelas->id, 'exam' => $exam->slug, 'soal' => $soal->id]) }}" method="post">
        @csrf
            <div class="card" id="app">
                <div class="card-header">
                    Soal ke-{{ $nomorSoal }} dari {{ $totalSoal }}

                    <div class="card-action ml-auto">
                        <timer 
                            v-bind:starttime="{{ $start }}"
                            v-bind:endtime="{{ $end }}"
                        ></timer>
                    </div>
                </div>
                <div class="card-body">
                    {!! $soal->konten !!}

                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                        @foreach ($answers as $answer)
                        <label class="form-selectgroup-item flex-fill">
                            <input type="{{ $choice }}" 
                                name="jawaban[]" 
                                value="{{ $answer->id }}" 
                                class="form-selectgroup-input"
                                @foreach ($jawabanUser as $jwb)
                                    @if ($answer->id == $jwb['id']) checked @endif
                                @endforeach
                            >
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                                <div class="mr-3">
                                    <span class="form-selectgroup-check"></span>
                                </div>
                                <div>
                                    {!! $answer->redaksi !!}
                                </div>
                            </div>
                        </label>
                        @endforeach

                    </div>

                </div>
                <div class="card-footer">
                    <div class="btn-list">
                    
                        @if ($prevSoal)
                        <a href="{{ route('ujian.kerjain', ['kelas' => $kelas->id, 'exam' => $exam->slug, 'soal' => $prevSoal]) }}" class="btn btn-info">
                            <i class="fas fa-chevron-circle-left"></i>
                            <span class="ml-1">Sebelumnya</span>
                        </a>
                        @endif

                        <input type="submit" class="btn btn-success" value="Jawab">
                        
                        @if ($nextSoal != request('soal'))
                        <a href="{{ route('ujian.kerjain', ['kelas' => $kelas->id, 'exam' => $exam->slug, 'soal' => $nextSoal]) }}" class="btn btn-info">
                            <span class="mr-1">Selanjutnya</span> 
                            <i class="fas fa-chevron-circle-right"></i>
                        </a>
                        @endif 

                    </div>

                </div>
            </div>
        </form>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Direktori Soal
            </div>
            <div class="card-body">
                <div class="btn-list justify-content-center">
                @foreach ($exam->questions->all() as $key => $question)

                    <a href="{{ route('ujian.kerjain', [
                            'kelas' => $kelas->id,
                            'exam' => $exam->slug,
                            'soal' => $question->id
                            ]) }}" 
                        class="btn btn-light btn-sm @if (request('soal') == $question->id) active @endif ">
                        {{ ++$key }}
                    </a>
        
                @endforeach
                </div>

            </div>
        </div>
        @if($nextSoal == request('soal'))
        <div class="col d-flex justify-content-center">
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#selesaiUjian">
                <i class="fas fa-check-circle"></i>
                <span class="ml-1">Selesai</span>
            </button>
        </div>
        @endif

    </div>
</div>

<!-- Selesai Ujian -->
<div class="modal fade" id="selesaiUjian" tabindex="-1" role="dialog" aria-labelledby="selesaiUjianLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"">
    <div class="modal-content">
      
      <div class="modal-body">
        Apakah Anda yakin?
      </div>
      <div class="modal-footer">
        <form action="{{ route('ujian.submit', ['kelas' => $kelas->id, 'exam' => $exam->slug]) }}" method="post" id="submitUjian">
        @csrf
            <input type="hidden" name="kelas" value="{{ $kelas->id }}">
            <input type="hidden" name="slug" value="{{ $exam->slug }}">
            <input type="submit" value="Ya, saya sudah selesai" class="btn btn-success"> 
        </form>
        <button type="button" class="btn btn-white" data-dismiss="modal">Belum, kembali ke ujian</button>
      </div>
    </div>
  </div>
</div>
<!-- END Selesai Ujian -->
<script type="text/javascript" src="/js/app.js"></script>
@endsection