@extends('admin.main')

@section('content')

    @include('admin._item-header')

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
                            name="akun[nama]" 
                            value="{{ old('nama') ?? $user->name }}"
                    >

                    @error('akun.nama')
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
                            name="akun[email]"
                            value=" {{ old('email') ?? $user->email }}"
                    >

                    @error('akun.email')
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
                            name="akun[username]"
                            value="{{ old('username') ?? $user->username}}"
                    >

                    @error('akun.username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror  

                </div>
            </div>
            
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label required">Password</label>
                <div class="col">
                <button type="button" class="btn" data-toggle="modal" data-target="#changePasswordModal">
                    Ubah Password
                </button>  

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
                                    value="admin"
                                    @if ($user->role->name == 'admin') checked @endif
                            >
                            <span class="form-check-label">Administrator</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" 
                                    type="radio" 
                                    name="role" 
                                    value="teacher"
                                    @if ($user->role->name == 'teacher') checked @endif
                            >
                            <span class="form-check-label">Teacher</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" 
                                    type="radio" 
                                    name="role" 
                                    value="student" 
                                    @if ($user->role->name == 'student') checked @endif
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
                                name="profil[gender]" 
                                value="1"
                                @if ($user->profile->gender == 'Laki-laki') checked @endif
                        >
                        <span class="form-check-label">Laki-laki</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" 
                                type="radio" 
                                name="profil[gender]" 
                                value="2"
                                @if ($user->profile->gender == 'Perempuan') checked @endif
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
                            name="profil[tanggal_lahir]" 
                            id="tanggal_lahir" 
                            value="{{ old('tanggal_lahir') ?? $user->profile->getTanggalLahirDateString() }}"
                    >

                </div>
            </div>
            
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">WhatsApp</label>
                <div class="col">
                    <input type="text" 
                            class="form-control @error('whatsapp') is-invalid @enderror" 
                            placeholder="Masukkan whatsapp" 
                            name="profil[whatsapp]"
                            value="{{ old('whatsapp') ?? $user->profile->whatsapp}}"
                    >

                    @error('profil.whatsapp')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror  

                </div>
            </div>

            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Telegram</label>
                <div class="col">
                    <input type="text" 
                            class="form-control @error('telegram') is-invalid @enderror" 
                            placeholder="Masukkan telegram" 
                            name="profil[telegram]"
                            value="{{ old('telegram') ?? $user->profile->telegram}}"
                    >

                    @error('profil.telegram')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror  

                </div>
            </div>

            <div class="btn-list mt-4">
                <a href="{{ route('admin.user.index') }}" class="btn btn-white">Batal</a>
                <input type="submit" value="Simpan" class="btn btn-success">
            </div>
    
        </div>
        
    </form>

    <div id="app">
        <modal id="changePasswordModal" :classes="['modal-dialog-centered']">
            <template #header>
                Ubah Password
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </template>
            <template #body>
                <password-change-form user-id="{{ $user->id }}"></password-change-form>
            </template>
        </modal>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush