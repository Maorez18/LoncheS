@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endsection

@section('content')
    <div class="row justify-content-center align-items-center vh-100 auth-form p-4">
        <section class="col-lg-5 col-11">
            <div class="row">
                <div class="col p-lg-5 p-4 bg-light rounded-3 form-login">
                    <div class="row mb-5">
                        <div class="col text-center">
                            <img src="{{asset('assets\img\login\undraw_undraw_undraw_undraw_sign_up_ln1s_-1-_s4bc_-1-_ee41_-1-_kf4d.svg')}}" class="img-fluid" style="width: 8em;" alt="">
                        </div>
                    </div>
                    <form id="registerForm" method="POST" action="{{ route('register') }}" onsubmit="return validateForm()">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-lg-6 col-12">
                                <label class="form-label" for="nickname">Nombre de Usuario</label>
                                <input class="form-control @error('nickname') is-invalid @enderror" type="text" id="nickname" name="nickname" value="{{ old('nickname') }}" required>
                                @error('nickname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-12">
                                <label class="form-label" for="email">Correo electrónico</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6 col-12">
                                <label class="form-label" for="name">Nombre(s)</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-12">
                                <label class="form-label" for="lastname">Apellidos</label>
                                <input class="form-control @error('lastname') is-invalid @enderror" type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6 col-12">
                                <label class="form-label" for="birthdate">Fecha de nacimiento</label>
                                <input class="form-control @error('birthdate') is-invalid @enderror" type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6 col-12">
                                <label class="form-label" for="password">Contraseña</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" aria-describedby="passwordHelpBlock" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="passwordHelpBlock" class="form-text sub-text">
                                    La contraseña debe tener al menos 1 mayúscula, 2 números y 1 carácter especial (@, *, #, $, ...).
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <label class="form-label" for="password-confirm">Confirmar Contraseña</label>
                                <input class="form-control" type="password" id="password-confirm" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-form" href="{{route('login')}}"><i class="bi bi-arrow-left"></i> Atras</a>
                            </div>
                            <div class="col text-end">
                                <button class="btn btn-form" type="submit">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
