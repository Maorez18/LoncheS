@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/form-group.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">
@endsection

@section('content')
    <div class="row">
        @include('theme.admin.header')
        @include('theme.admin.aside3')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><span class="material-symbols-outlined">supervisor_account</span> Usuarios</h1>
            </div>
            <div class="row align-items-center justify-content-center mx-lg-5 mx-4 p-3">
                <div class="col">
                    <div class="row justify-content-center">
                        <div class="col-lg-9 bg-form-user rounded-3 p-3">
                            <form class="edit-profile-form" action="{{route('user.update', $user)}}" method="post">
                                @csrf
                                @if (isset($user))
                                    @method('PUT')
                                @endif
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 col-12 mt-md-3 mt-sm-4">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="nickname" class="form-label">Nombre de Usuario</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control @error('nickname') is-invalid @enderror" id="nickname" name="nickname" value="{{ old('user', $user->nickname ?? '') }}">
                                                @error('nickname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="name" class="form-label">Nombre</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('user', $user->name ?? '') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="lastname" class="form-label">Apellidos</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('user', $user->lastname ?? '') }}">
                                                @error('lastname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('user', $user->birthdate ?? '') }}">
                                                @error('birthdate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="email" class="form-label">Correo</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('user', $user->email ?? '') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col"><label for="type" class="form-label">Tipo de usuario</label></div>
                                            <div class="col-lg-8">
                                                <select class="form-select" name="type" id="type">
                                                    @foreach($types as $type)
                                                        <option value="{{ $type->id }}"
                                                                @if($user->fk_type == $type->id) selected @endif>
                                                            {{ $type->type_user }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col"><label for="status" class="form-label">Estado</label></div>
                                            <div class="col-lg-8">
                                                <select class="form-select" name="status" id="status">
                                                    @for($i=0; $i<2; $i++)
                                                        <option value="{{$i}}"
                                                                @if($user->is_active == $i) selected @endif>
                                                            @if($i==0) Inactivo @else Activo @endif
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-4 align-self-center text-lg-start text-end"><a href="{{route('users.index')}}">Cancelar</a></div>
                                            <div class="col-4 text-end"><button type="submit" class="btn btn-primary">Guardar Cambios</button></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{--<div class="row">
                        <div class="col">
                            <div class="subscription-section">
                                <h3>Gestionar Suscripción</h3>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Estado de la Suscripción</h5>
                                        <p class="card-text">Actualmente tienes una suscripción activa.</p>
                                        <button class="btn btn-warning">Actualizar Suscripción</button>
                                        <button class="btn btn-danger">Cancelar Suscripción</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>
        </main>
    </div>
@endsection

@push('js')

@endpush
