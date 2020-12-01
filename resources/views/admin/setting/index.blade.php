@extends('admin.main')

@section('content')

    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">
            Pengaturan
        </a></li>
    </ol>

    <div class="page-header mt-2">
        <h1>Pengaturan</h1>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('admin.setting.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="card mb-2">
            <div class="card-header">
              <h3 class="card-title">Pengaturan Umum</h3>
            </div>
            <div class="card-body">
    
                <div class="form-group mb-3 ">
                  <label class="form-label">Nama Aplikasi</label>
                  <div >
                    <input type="text" class="form-control" value="{{ settings('app_name') }}" name="app_name">
                  </div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-label">Logo</div>

                    <div class="col-md-4">
                        <img src="{{ settings('app_logo') }}" alt="App's logo" class="img-fluid my-3">
                    </div>

                </div>

                <div class="form-file col-md-3">
                    <label for="logo">Ganti logo</label>
                    <input type="file" id="logo" name="logo">
                </div>
              
            </div>

            <div class="card-footer">
                <input type="submit" value="Simpan Pengaturan" class="btn btn-success">
            </div>
        </div>

    </form>

@endsection