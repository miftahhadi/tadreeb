@extends('admin.main')

@section('content')

    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">User</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">
            Edit User
        </a></li>
    </ol>

    <div class="page-header">
        <div class="row">
            <div class="col-auto">
                <h3 class="h1 mt-0 mb-3">Edit User</h3>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.user.update', $user->id) }}" method="post" class="row">
        @method('PUT')
        @csrf
        
        <div class="col-md-8">
                   
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label required">Nama</label>
                        <div class="col">
                            <input type="text" 
                                    class="form-control @error('nama') is-invalid @enderror" 
                                    placeholder="Masukkan nama user" 
                                    name="data[nama]" 
                                    value="{{ old('data.nama') ?? $user->nama }}"
                            >
    
                            @error('data.nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror  
    
                        </div>
                    </div>
    
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label required">Email</label>
                        <div class="col">
                            <input type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="Masukkan email" 
                                    name="data[email]"
                                    value=" {{ old('data.email') ?? $user->email }}"
                            >
    
                            @error('data.email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror  
    
                        </div>
                    </div>
    
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label required">Username</label>
                        <div class="col">
                            <input type="text" 
                                    class="form-control @error('username') is-invalid @enderror" 
                                    placeholder="Masukkan username" 
                                    name="data[username]"
                                    value="{{ old('data.username') ?? $user->username}}"
                            >
    
                            @error('data.username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror  
    
                        </div>
                    </div>
                    
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label required">Password</label>
                        <div class="col">
                            <a href="#" class="btn btn-white">Ganti Password</a>
                        </div>
                    </div>
    
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label required">Peran</label>
                        <div class="col">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                            type="radio" 
                                            name="role" 
                                            value="Admin"
                                            @if ($user->hasRole(2)) checked @endif
                                    >
                                    <span class="form-check-label">Administrator</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                            type="radio" 
                                            name="role" 
                                            value="Teacher"
                                            @if ($user->hasRole(3)) checked @endif
                                    >
                                    <span class="form-check-label">Teacher</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                            type="radio" 
                                            name="role" 
                                            value="Student" 
                                            @if ($user->hasRole(4)) checked @endif
                                    >
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
                                <input class="form-check-input" 
                                        type="radio" 
                                        name="data[gender]" 
                                        value="1"
                                        @if ($user->gender == 'Laki-laki') checked @endif
                                >
                                <span class="form-check-label">Laki-laki</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" 
                                        type="radio" 
                                        name="data[gender]" 
                                        value="2"
                                        @if ($user->gender == 'Perempuan') checked @endif
                                >
                                <span class="form-check-label">Perempuan</span>
                            </label>
                                
                        </div>
                    </div>
                    
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Tanggal Lahir</label>
                        <div class="col">
                            <input type="date" 
                                    class="form-control" 
                                    name="data[tanggal_lahir]" 
                                    id="tanggal_lahir" 
                                    value="{{ old('tanggal_lahir') ?? $user->tanggal_lahir }}"
                            >
    
                        </div>
                    </div>
                


            <div class="btn-list mt-4">
                <a href="{{ route('admin.user.index') }}" class="btn btn-white">Batal</a>
                <input type="submit" value="Simpan" class="btn btn-success">
            </div>
    
        </div>
        
        </form>
@endsection