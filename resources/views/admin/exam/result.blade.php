@extends('admin.exam.main')

@section('examContent')
    <div>
        <ol class="breadcrumb small" aria-label="breadcrumbs">
            @foreach ($data['navs'] as $nav)
                <li class="breadcrumb-item"><a href="{{ $nav['href'] }}">{{ $nav['name'] }}</a></li>                
            @endforeach
        </ol>
  
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
        @if ($data['mode'] == 'users-list')
            <exam-record-table
                :exam="{{ $ujian }}"
                :record-data="{{ json_encode($data) }}"
            ></exam-record-table>
        @elseif ($data['mode'] == 'records-by-user')
            <user-exam-record-table
                :data="{{ json_encode($data['records']) }}"
                :user="{{ json_encode($data['user']) }}"
                :kelas-id="{{ $data['kelas']->id }}"
                :ujian-id="{{ $ujian->id }}"
            ></user-exam-record-table>            
        @endif

    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush