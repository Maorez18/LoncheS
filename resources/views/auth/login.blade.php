@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endsection

@section('content')
    <div class="row justify-content-center align-items-center vh-100 auth-form p-4">
        <section class="col-lg-4 col-md-8 col-11">
            <div class="row">
                <div class="col p-lg-5 p-4 bg-light rounded-3 form-login">
                    <div class="row mb-5">
                        <div class="col text-center">
                            <img src="{{asset('assets/img/login/undraw_login_re_4vu2.svg')}}" class="img-fluid"
                                 style="width: 11em;" alt="">
                        </div>
                    </div>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="email" name="user"
                                           aria-describedby="emailHelp" placeholder="Correo electronico" required>
                                    <label for="email">Usuario o Correo electronico</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="Contraseña" required>
                                    <label for="password">Contraseña</label>
                                </div>
                                <a class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"
                                   href="{{route('password.request')}}">Olvide mi Contraseña</a>
                            </div>
                        </div>
                        <div class="row mt-5 justify-content-between">
                            <div class="col">
                                <a class="btn btn-form" href="{{url('/')}}"><i class="bi bi-arrow-left"></i> Atras</a>
                            </div>
                            <div class="col text-end">
                                <button type="submit" class="btn btn-form">Iniciar sesion</button>
                                <br>
                                <br>
                                <a class=" link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"
                                   href="{{route('register')}}">Registrarme</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@include('modals.error')
@include('modals.success')

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            @if($errors->has('error'))
            $('#modalerror').modal('show');
            setTimeout(function () {
                $('#modalerror').modal('hide');
            }, 2000);
            @endif
            @if(session('success'))
            $('#modalsuccess').modal('show');
            setTimeout(function () {
                $('#modalsuccess').modal('hide');
            }, 2000);
            @endif
            @if(session('error'))
            $('#modalerror').modal('show');
            setTimeout(function () {
                $('#modalerror').modal('hide');
            }, 2000);
            @endif
        });
    </script>
@endpush
