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

            <h2 class="mt-4 text-center">Masuk</h2>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="card card-md">
                        @csrf

                        <div class="card-body">
                            <div class="mb-3">
                                
                                <label class="form-label">Usernamme</label>
                                
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

                            <div class="mb-2">
                                <label class="form-check">
                                  
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                  
                                    <span class="form-check-label"> Ingat saya</span>
                                </label>
                              </div>

                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                            </div>

                        </div>

                    </form>
                    @if (Route::has('password.request'))
                        <div class="text-center text-muted">
                            <a href="{{ route('password.request') }}" tabindex="-1">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
