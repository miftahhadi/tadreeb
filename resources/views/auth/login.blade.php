@extends('base')

@section('body-class')
    border-top-wide border-primary d-flex flex-column  
@endsection

@section('main')
    <div class="flex-fill d-flex flex-column justify-content-center py-4">
        <div class="container-tight py-6">

            <div class="text-center mb-4">
                <img src="{{ settings('app_logo') }}" height="50" alt="">
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    Username atau password salah
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="card card-md mx-4">
                @csrf

                <div class="card-body">

                    <h2 class="card-title text-center mb-4">Login ke {{ settings('app_name') }}</h2>

                    <div class="mb-3">
                        
                        <label class="form-label">Username</label>
                        
                        <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username Anda" autocomplete="off">
                        
                    </div>

                    <div class="mb-2">
                        <label class="form-label">
                            Password
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        </div>
                    </div>

                    {{-- <div class="mb-2">
                        <label class="form-check">
                            
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            
                            <span class="form-check-label"> Ingat saya</span>
                        </label>
                    </div> --}}

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </div>

                </div>

            </form>
                {{-- @if (Route::has('password.request'))
                    <div class="text-center text-muted">
                        <a href="{{ route('password.request') }}" tabindex="-1">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif --}}

                </div>
        
        </div>
    </div>
</div>
@endsection
