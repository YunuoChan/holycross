@extends('layouts.app')

@section('head')
    <title>HCC | Login</title>

    <link href="{{ asset('/css/login-page.css') }}" rel="stylesheet" type="text/css">
@stop


@section('content')
<div class="bg-sy" style="background-image: url('/img/hcc-bg.jpg');">
    <div class="bg-opacity">
        <div class="container container-flex">
            <div class="row justify-content-center">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-lg-6 d-none d-lg-inline-block">
                                <div class="account-block rounded-right">
                                    <div class="overlay rounded-right"></div>
                                    <div class="account-testimonial">
                                        <h4 class="text-white mb-4">HCC </h4>
                                        <p class="lead text-white">"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."</p>
                                        <p>- HCC</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="mb-5">
                                        <h1 class="text-theme">Admin Login</h1>
                                    </div>
        
                                    <h6 class="h5 mb-0">Welcome back!</h6>
                                    <p class="text-muted mt-2 mb-5">Enter your email address and password to access admin panel.</p>
        
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        {{-- EMAIL --}}
                                        <div class="group">      
                                          
                                            <input id="email" class="@error('email') is-invalid @enderror" type="text"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label class="input-label">Email address</label>
                                        </div>
                                        {{-- PASSWORD --}}
                                        <div class="group mb-3">     
                                            <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="off">
    
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label class="input-label">Password</label>
                                        </div>
                                        <div class="form-group mb-5">
                                            <div class="form-check">
                                                
                                                <input class="form-check-input" type="checkbox" Placeholder="Password" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                                
                                            </div>
                                        </div>
                                        <div class="mt-5 pt-3 d-flex justify-content-end">
                                            <div class="w-50">
                                                <button type="submit" class="button login__submit justify-content-between">
                                                    <span class="button__text">{{ __('Login') }}</span>
                                                    <i class="button__icon fas fa-chevron-right"></i>
                                                </button>
                
                                                {{-- @if (Route::has('password.request'))
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif --}}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
        
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
