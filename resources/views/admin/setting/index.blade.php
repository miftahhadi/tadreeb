@extends('admin.main')

@section('content')

    <div class="page-header">
        <h2 class="page-title">Pengaturan</h2>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="#" method="post">

        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Pengaturan Umum</h3>
            </div>
            <div class="card-body">
    
                <div class="form-group mb-3 ">
                  <label class="form-label">Nama Aplikasi</label>
                  <div >
                    <input type="text" class="form-control" value="{{ settings('app_name') }}">
                  </div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-label">Logo</div>
                    <div class="form-file col-md-3">
                        <input type="file" class="form-file-input" id="customFile">
                        <label class="form-file-label" for="customFile">
                          <span class="form-file-text">Choose file...</span>
                          <span class="form-file-button">Browse</span>
                        </label>
                    </div>

                    <div class="col-md-4">
                        <img src="{{ settings('app_logo') }}" alt="App's logo" class="img-fluid my-3">
                    </div>

                </div>
              
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

@endsection