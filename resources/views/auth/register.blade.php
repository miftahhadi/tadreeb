@extends('layouts.base')

@section('body-class')
    border-top-wide border-primary d-flex flex-column    
@endsection

@section('main')
    <div class="container">
        <div class="row justify-content-center py-6">
            <div class="col-12 col-md-8 col-lg-4">

                <div class="text-center mb-4">
                    <img src="/static/logo.svg" height="50" alt="">
                </div>

                <h2 class="mt-4 text-center">Daftarkan Akun Baru</h2>
                
                <form method="POST" action="{{ route('register') }}" class="card card-md">
                    @csrf

                    <div class="card-body">
                        <div class="mb-3">
                            
                            <label for="name" class="form-label">Nama</label>

                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama Anda">

                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required placeholder="Enter username">
    
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
    
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter email">
    
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
    
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
    
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
    
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
    
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
    
    
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
                        
                        </div>

                        <div class="form-footer">
                            <input type="submit" class="btn btn-primary btn-block" value="Daftar">
                        </div>

                    </div>
                </form>
                <div class="text-center text-muted">
                    Already have account? <a href="./sign-in.html" tabindex="-1">Sign in</a>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('js-script')
    <!-- Libs JS -->
    <script src="./dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js"></script>
@endsection