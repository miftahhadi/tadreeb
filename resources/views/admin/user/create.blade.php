@extends('admin.main')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-auto">
                <h3 class="h1 mt-0 mb-3">User Baru</h3>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.user.store') }}" method="post" class="row">
        @csrf
        
        <div class="col-md-8">
                   
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label required">Nama</label>
                <div class="col">
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama user" name="user[nama]" value="{{ old('nama') ?? '' }}">

                    @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror  

                </div>
            </div>

            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label required">Email</label>
                <div class="col">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email" name="user[email]">

                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror  

                </div>
            </div>

            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label required">Username</label>
                <div class="col">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username" name="user[username]">

                    @error('username')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror  

                </div>
            </div>
            
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label required">Password</label>
                <div class="col">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="user[password]">

                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror  

                </div>
            </div>

            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label required">Peran</label>
                <div class="col">
                    <div>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role[name]" value="2">
                            <span class="form-check-label">Administrator</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role[name]" value="3">
                            <span class="form-check-label">Teacher</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role[name]" value="4" checked>
                            <span class="form-check-label">Peserta</span>
                        </label>
                    </div>

                    @error('role')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror  
                        
                </div>
            </div>

            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Jenis Kelamin</label>

                <div class="col">
            
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="user[gender]" value="1">
                        <span class="form-check-label">Laki-laki</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="user[gender]" value="2">
                        <span class="form-check-label">Perempuan</span>
                    </label>
                        
                </div>
            </div>
            
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Tanggal Lahir</label>
                <div class="col">
                    <input type="date" class="form-control" name="user[tanggal_lahir]" id="tanggal_lahir" value="{{ old('tanggal_lahir') ?? '' }}">

                </div>
            </div>
                
            <div class="btn-list mt-4">
                <a href="{{ route('admin.user.index') }}" class="btn btn-white">Batal</a>
                <input type="submit" name="submit" value="Simpan" class="btn btn-success">
            </div>
    
        </div>
        
        </form>
@endsection