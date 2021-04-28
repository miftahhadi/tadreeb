@extends('admin.exam.main')

@section('examContent')
    <div>
        <a href="{{ route('admin.ujian.kelas', ['ujian' => $ujian->id]) }}" class="d-flex align-items-center">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="5" y1="12" x2="19" y2="12" /><line x1="5" y1="12" x2="9" y2="16" /><line x1="5" y1="12" x2="9" y2="8" /></svg>
            </span>
            <span>Daftar kelas</span>
        </a>
        <h2>Kelas: {{ $data['kelas']->nama }}</h2>
        <div class="text-muted mb-4">
            <div>
                Kode kelas: {{ $data['kelas']->kode }}
            </div>
            <div>
                Grup: {{ $data['kelas']->group->nama }}
            </div>
        </div>

    </div>

    <div id="app">
        <exam-record-table
            :record-data="{{ json_encode($data) }}"
        ></exam-record-table>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush