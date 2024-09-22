@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endsection

@section('content')
    <div class="container-fluid row justify-content-center align-items-center auth-form vh-100">
        <section class="col-lg-4 col-10">
            <div class="row">
                <div class="col p-5 bg-light rounded-3 form-login">
                    <div class="row mb-3">
                        <div class="col text-center">
                            <img src="{{ asset('assets/img/login/undraw_secure_login_pdn4.svg') }}" class="img-fluid"
                                 style="width: 10em;" alt="">
                        </div>
                    </div>
                    <p>Por favor, restablece tu contraseña utilizando el formulario a continuación.</p>
                    <form id="registerForm" method="POST" action="{{ route('password.update') }}"
                          onsubmit="return validateForm()">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input class="form-control" type="email" id="email" name="email" value="{{ $email }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" aria-describedby="passwordHelpBlock" placeholder="Nueva Contraseña" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input class="form-control" type="password" id="password_confirmation"
                                   name="password_confirmation" placeholder="Confirmar Nueva Contraseña" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-form px-4" type="submit">Restablecer Contraseña</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (session('email'))
                <div class="row">
                    <div class="col">{{session('email')}}</div>
                </div>
            @endif
        </section>
    </div>
@endsection
