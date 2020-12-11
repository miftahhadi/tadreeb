@extends('admin.exam.main')

@section('examContent')
<div class="row mb-2">
    <div class="col-auto">
        <h2>Pilih Kelas</h2>
        <p>Kelas yang mengujikan ujian {{ $ujian->judul }}:</p>
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
            @if ($data['konten'] == 'kelas')
                @foreach ($data['row'] as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->group->nama }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.ujian.hasil', ['ujian' => $ujian->slug, 'kelas' => $item->id]) }}">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            @else 
                @foreach ($data['row'] as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->pivot->printWaktuMulai() }}</td>
                        <td>{{ $item->pivot->printWaktuSelesai() }}</td>
                        <td>{{ $item->pivot->score() }}</td>
                        <td class="text-right">
                            <div class="btn-list">
                            <a href="{{ route('admin.ujian.hasil', ['ujian' => $ujian->slug, 'kelas' => $item->id]) }}">Lihat</a>

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