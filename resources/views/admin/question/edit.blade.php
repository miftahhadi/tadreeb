@extends('admin.main')

@section('head-script')
    @parent
    <!-- CKEditor -->
    <script src="/dist/vendor/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <ol class="breadcrumb" aria-label="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('admin.ujian.show', $ujian->slug) }}">{{ $ujian->judul }}</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">
            Edit Soal
        </a></li>
    </ol>

    <form 
        action=
        @section('form-action')
            "{{ route('admin.ujian.soal.update', ['ujian' => $ujian->slug, 'soal' => $soal->id]) }}"
        @show 
        method="post"
    >
        @method('PUT')
        @csrf


        <div class="row mt-3 mb-4">
            <h2 class="h1 font-weight-bold">{{ $ujian->judul }}</h2>
            <div class="col-auto">
                <h2 class="h2">Edit Soal</h2>
            </div>
            
            <div class="col-auto ml-auto">
                <input type="submit" value="Simpan" class="btn btn-success">
                <a href="{{ route('admin.ujian.show', $ujian->slug) }}" class="btn btn-white">Batal</a>
            </div>
        </div>

        <div class="alert alert-info" role="alert">
            Tipe soal: <strong>{{ $soal->tipe }}</strong>
        </div>

        <div class="card">
            <div class="card-header">
                Redaksi Soal
            </div>
            <div class="card-body">
        
                @error('soal[konten]')
                    <small class="text-danger">Soal belum diisi</small>
                @enderror
        
                <textarea class="form-control" name="soal[konten]" id="redaksi" placeholder="Tuliskan soal...">{!! $soal->konten !!}</textarea>
            </div>
        </div>

        <h4 class="card-title">Pilihan Jawaban</h4>
        
        @if($soal->tipe == 'Jawaban Ganda' || $soal->tipe == 'Pilihan Ganda')

            @foreach ($soal->answers as $key => $answer)

            <div class="card">
                <div class="card-header">
                    Pilihan {{ ++$key }}
                </div>
                <div class="card-body" id="cardSoal">
                    <textarea name="jawaban[{{ $answer->id }}][redaksi]">{!! $answer->redaksi !!}</textarea>
                </div> 
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="form-label">Pilihan Benar</div>
                                <label class="form-check">
                                    <input type="{{ $option }}" class="form-check-input" name="benar[]" value="{{ $answer->id }}" @if ($answer->benar == 1) checked @endif>
                                    <span class="form-check-label">Benar</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Nilai</label>
                                <input type="number" class="form-control" name="jawaban[{{ $answer->id }}][nilai]" placeholder="Nilai" value="{{ $answer->nilai }}">
                            </div>
                        </div>  

                    </div>
                </div>

            </div>
            @endforeach

            @elseif ($soal->tipe == 'Benar/Salah')

            <div class="row">
                @foreach ($soal->answers as $key => $answer)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <label class="form-check">
                                <input type="radio" class="form-check-input" name="benar[]" value="{{ $answer->id }}" @if ($answer->benar == 1) checked @endif>
                                <input type="hidden" name="jawaban[{{ $answer->id }}][redaksi]" value="{{ $answer->redaksi }}">
                                <div class="form-check-label">{{ $answer->redaksi }}</div>
                            </label>
                        </div>

                        <div class="card-footer">

                            <div class="form-group">
                                <label class="form-label">Nilai</label>
                                <input type="number" class="form-control" placeholder="Nilai" value="{{ $answer->nilai ?? 0 }}" name="jawaban[{{ $answer->id }}][nilai]">
                            </div>
            
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        @endif

    </form>
@endsection

@push('js')
    <!-- CKEditor -->
    <script>
        CKEDITOR.replaceAll();
    </script>
@endpush