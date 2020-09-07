@extends('admin.general.index-items')

@section('pageTitle')
    Ujian
@endsection

@section('tableHeading')
            <th class="w-1">ID</th>
            <th>Judul</th>
            <th>Dibuat oleh</th>
            <th class="w-2"></th>
@endsection

@section('tableBody')

    @forelse ($exams as $exam)
        <tr>
            <td>{{ $exam->id }}</td>
            <td>{{ $exam->judul }}</td>
            <td>{{ $exam->user->nama }}</td>
            <td class="text-right">
                <div class="btn-list flex-nowrap">
                    <a href="{{ route('ujian.show', $exam->slug) }}" class="btn btn-sm btn-primary">Buka</a>

                    {{-- <button type="button"
                            class="btn btn-danger btn-sm"
                            data-toggle="modal"
                            data-id="{{ $exam->id }}"
                            data-target="#hapusData"
                    >Hapus</button> --}}

                    <a href="{{ route('ujian.edit', $exam->slug) }}" class="btn btn-sm btn-white">Edit</a>
    
                    <form action="{{ route('ujian.destroy', $exam->slug) }}" method="post">
                        @method('DELETE')
                        @csrf

                        <input type="submit" class="btn btn-danger btn-sm" value="Hapus">
                        
                    </form>
                </div>

            </td>
        </tr>

    @empty
        <tr>
            <td colspan="4">Belum ada ujian</td>
        </tr>
    @endforelse
    
@endsection