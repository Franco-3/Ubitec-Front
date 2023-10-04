@extends('backend.layouts.main')

@section('content')
{{-- <style>
    @media screen (min-width:450px) and (orientation:portrait) {
    .section-content{
      min-height: calc(100vh - 440px);
    }
}
</style> --}}
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-7 col-xl-6">
            <div class="card mb-3">
                <div class="card-header text-center fs-4">{{ __('Login') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">{{ __('EmailAddress') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label for="inputPassword" class="col-form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-12 off">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('RememberMe') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    <button type="submit" class="btn btn-primary">Entrar</button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('ForgotYourPassword?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
