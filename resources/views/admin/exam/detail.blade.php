@extends('admin.main')

@section('content')

    <div class="d-flex">
        <a href="{{ route('admin.ujian.kelas', ['ujian' => $exam->id, 'kelasId' => $kelas->id, 'userId' => $user->id]) }}">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="5" y1="12" x2="19" y2="12" /><line x1="5" y1="12" x2="9" y2="16" /><line x1="5" y1="12" x2="9" y2="8" /></svg>
            </span>
            Kembali
        </a>
    </div>

    @include('_lembar-jawaban')

@endsection