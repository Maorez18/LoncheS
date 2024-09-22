@extends('theme.base')

@section('content')
<div class="container-fluid row justify-content-center align-items-center auth-form vh-100">
    <section class="col-lg-4 col-12">
        <div class="row">
            <div class="col p-lg-5 p-4 bg-light rounded-3 form-login">
                <div class="row mb-3">
                    <div class="col text-center">
                        <img src="{{asset('assets\img\login\undraw_secure_login_pdn4.svg')}}" class="img-fluid" style="width: 10em;" alt="">
                    </div>
                </div>
                <p>Por favor ingresa tu correo electronico.</p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <input class="form-control mb-3 @error('email') is-invalid @enderror" type="text" name="email" placeholder="Correo electronico" value="{{ old('nickname') }}" required>
                            @error('email')
                                <div class="invalid-feedback mb-3">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <button class="btn btn-form px-4" type="submit">Enviar</button>
                        </div>
                    </div>
                </form>
                <div class="row pt-3">
                    <div class="col">
                        <a class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" href="{{route('login')}}">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
