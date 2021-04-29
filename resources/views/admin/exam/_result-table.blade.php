<div class="box mt-2">
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
            @foreach ($data['row'] as $key => $user)
                <tr>
                    <td>{{ ++$key }}</td>
                    @foreach ($data['properties'] as $property)
                        <td>{{ $user[$property] }}</td>
                    @endforeach
                    <td class="text-right flex-nowrap">
                        @if ($data['mode'] == 'showDone')
                            <a href="{{ route('admin.ujian.kelas', ['ujian' => $ujian->id, 'kelas' => $user->id]) }}">Riwayat</a>
                            <a href="#">Hapus</a>                                    
                        @elseif ($data['mode'] == 'showAll')
                            <td>{{ ($user['has_done_exam'] == 1) ? 'Sudah' : 'Belum' }}</td>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

        </table>

    </div>
    </div>
</div>   