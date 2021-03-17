@extends('admin.exam.main')

@section('examContent')
    <div id="app">
        <exam-question
            :exam-id="{{ $ujian->id }}"
            :questions-array="{{ $questions }}"
        ></exam-question>
    </div>

    {{-- <div class="box">
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

                        @forelse ($ujian->questions as $question)
                            <tr>
                                <td class="w-1">{{ $question->pivot->urutan }}</td>
                                <td width="70%">{!! $question->konten !!}</td>
                                <td>{{ $question->tipe }}</td>
                                <td class="w-1">
                                    <div class="btn-list flex-nowrap">
                                        <a href="{{ route('admin.ujian.soal.edit', ['ujian' => $ujian->slug, 'soal' => $question->id]) }}" class="btn btn-light btn-sm">Edit</a>
                                        <button class="btn btn-danger btn-sm">Buang</button>
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
    </div>     --}}
@endsection    

@section('newQuestion')
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

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush
