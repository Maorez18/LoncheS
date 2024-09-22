 @extends('theme.base')

@section('content')
<div class="row justify-content-center align-items-center vh-100 auth-form">
    <section class="col-lg-4 col-10">
        <div class="row">
            <div class="col p-5 bg-light rounded-3 form-login">
                <div class="row mb-3">
                    <div class="col text-center">
                        <img src="{{asset('assets\img\login\undraw_secure_login_pdn4.svg')}}" class="img-fluid" style="width: 10em;" alt="">
                    </div>
                </div>
                <p>Por favor verifica tu correo electrónico utilizando el codigo que te hemos enviado.</p>
                <form method="POST" action="{{ route('verification.verify') }}">
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <input class="form-control mb-3 @error('code') is-invalid @enderror" type="text" name="code" placeholder="Codigo de Verificacion" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <button class="btn btn-form px-4" type="submit">Verificar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
@include('modals.success')

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            @if(session('success'))
            $('#modalsuccess').modal('show');
            setTimeout(function () {
                $('#modalsuccess').modal('hide');
            }, 2000);
            @endif
        });
    </script>
@endpush
