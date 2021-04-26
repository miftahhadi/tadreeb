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
            @switch($data['mode'])
                @case('showDone')
                    @foreach ($data['row'] as $key => $user)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->examData->getWaktuMulaiString() }}</td>
                            <td>{{ $user->examData->getWaktuSelesaiString() }}</td>
                            <td>{{ $user->examData->score }}</td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="1" /><circle cx="12" cy="19" r="1" /><circle cx="12" cy="5" r="1" /></svg>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" 
                                                href="{{ 
                                                        route('admin.ujian.kelas.hasil', 
                                                                [
                                                                    'ujian' => $ujian->id, 
                                                                    'kelas' => $user->id
                                                                ]
                                                            ) 
                                                        }}"
                                            >Lihat jawaban</a></li>
                                        <li><a class="dropdown-item" href="#">Lihat Riwayat</a></li>
                                        <li><a class="dropdown-item bg-danger text-white" href="#">Hapus</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @break

                @case('showNotDone')
                    @foreach ($data['row'] as $key => $user)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td class="text-right">
                            </td>
                        </tr>
                    @endforeach
                    @break

                @default
                    @foreach ($data['row'] as $key => $user)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ ($user->has_done_exam == 1) ? 'Sudah' : 'Belum' }}</td>
                            <td class="w-1">
                            </td>
                        </tr>
                    @endforeach
                    @break
            @endswitch

        </tbody>

        </table>

    </div>
    </div>
</div>   