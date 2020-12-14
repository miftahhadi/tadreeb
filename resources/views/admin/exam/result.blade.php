@extends('admin.exam.main')

@section('examContent')
<div class="row mb-2">
    <div class="col-auto">

        @if ($data['mode'] == 'classroomList')
            <h2>Pilih Kelas</h2>
            <p>Kelas yang mengujikan ujian {{ $ujian->judul }}:</p>
        @endif

    </div>    
</div>

<div class="box">
    <div class="card">
    <div class="table-responsive">

        <table class="table table-vcenter table-hover card-table">

        <thead>
            <tr>
                <th class="w-1">No</th>

                @foreach ($data['heading'] as $heading)
                    <th>{{ $heading }}</th>                    
                @endforeach

                <th class="w-2"></th>
            </tr>
        </thead>

        <tbody>
            @if ($data['mode'] == 'classroomList')
                @foreach ($data['row'] as $key => $kelas)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $kelas->nama }}</td>
                        <td>{{ $kelas->group->nama }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.ujian.hasil', ['ujian' => $ujian->slug, 'kelas' => $kelas->id]) }}">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            @elseif ($data['mode'] == 'showDone')
                @foreach ($data['row'] as $key => $user)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->username }}</td>
                        {{-- <td>{{ $user->pivot->printWaktuMulai() }}</td>
                        <td>{{ $user->pivot->printWaktuSelesai() }}</td>
                        <td>{{ $user->pivot->score() }}</td> --}}
                        <td class="text-right">
                            <div class="btn-list">
                            <a href="{{ route('admin.ujian.hasil', ['ujian' => $ujian->slug, 'kelas' => $user->id]) }}">Lihat</a>

                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>

        </table>

    </div>
    </div>
</div>   
@endsection