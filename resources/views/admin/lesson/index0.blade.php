@extends('admin.general.index-items')

@section('pageTitle')
    Pelajaran
@endsection

@section('tableHeading')
    <th class="w-1">ID</th>
    <th>Judul</th>
    <th>Kategori</th>
    <th class="w-2"></th>
@endsection

@section('tableBody')
    @forelse ($lessons as $lesson)
        <tr>
          <td>{{ $lesson->id }}</td>
          <td>{{ $lesson->judul }}</td>
          <td>Tes</td>
          <td class="text-right">
            <div class="btn-list flex-nowrap">
                <a href="{{ route('pelajaran.show', $lesson->slug) }}" class="btn btn-sm btn-primary">Buka</a>

                {{-- <button type="button"
                        class="btn btn-danger btn-sm"
                        data-toggle="modal"
                        data-id="{{ $lesson->id }}"
                        data-target="#hapusData"
                >Hapus</button> --}}

                <a href="{{ route('pelajaran.edit', $lesson->slug) }}" class="btn btn-sm btn-white">Edit</a>

                <form action="{{ route('pelajaran.destroy', $lesson->slug) }}" method="post">
                    @method('DELETE')
                    @csrf

                    <input type="submit" class="btn btn-danger btn-sm" value="Hapus">
                    
                </form>
            </div>

          </td>
        </tr>
    @empty
        <tr>
          <td colspan="4">Belum ada pelajaran</td>
        </tr>
    @endforelse
@endsection

@section('pagination')
<div class="d-inline-flex">
    {{ $lessons->onEachSide(1)->links() }}
</div>

@endsection