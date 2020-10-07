@extends('admin.main')

@section('content')

    <div class="page-header">
        <h2 class="page-title">Daftar User</h2>
    </div>
    
    <div class="row mb-3">

        <div class="col">
            <div class="btn-list">
                <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> 
                    <span class="ml-2">Tambah Baru</span>
                </a>
                <a href="#" class="btn btn-success">Impor dari .CSV</a>
            </div>

        </div>

        <div class="col-auto">
            <form action="." method="get">
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
                  </span>
                  <input type="text" class="form-control form-control-rounded" placeholder="Search…">
                </div>
            </form>
        </div>

    </div>

    <div class="box">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter table-hover card-table">
                    <thead>
                        <tr>
                            <td class="w-1">ID</td>
                            <td>Nama</td>
                            <td>Username</td>
                            <td>Role</td>
                            <td>Jenis Kelamin</td>
                            <td width="30%"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->username }}</td>
                                <td></td>
                                <td>{{ $user->gender }}</td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{ route('admin.user.edit', ['user' => $user->id ]) }}" class="btn bg-light" data-toggle="tooltip" title="Edit">Edit</a>
                                        <!-- Button modal trigger-->
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-id="" data-target="#hapusData">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>Belum ada user</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection