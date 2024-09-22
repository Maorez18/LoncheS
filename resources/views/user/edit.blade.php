@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/user.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bg-user.css')}}">
@endsection

@section('content')
    <div class="row align-items-center justify-content-center vh-100 mx-lg-5 mx-4 p-3">
        <div class="col">
            <div class="row justify-content-center">
                <div class="col-lg-9 bg-form-user rounded-3 p-3">
                    <form class="edit-profile-form" action="{{route('user.update', $user)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif
                        <div class="row justify-content-center">
                            <aside class="col-lg-4 col-12">
                                <div class="edit-profile-header">
                                    <img id="profileImage" src="{{ $user->photo ? asset('uploads/users/' . $user->photo) : 'https://via.placeholder.com/150' }}" alt="Foto de Perfil" style="cursor: pointer;" onclick="document.getElementById('imageUpload').click();">
                                    <h2>Editar Perfil</h2>
                                    <input type="file" id="imageUpload" style="display: none;" name="photo" accept=".png, .jpg, .jpeg, .webp, .svg" onchange="previewImage(event)">
                                </div>
                            </aside>
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
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('user', $user->email ?? '') }}" disabled>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-4 align-self-center text-lg-start text-end"><a href="{{route('profile')}}">Cancelar</a></div>
                                    <div class="col-4 text-end"><button type="submit" class="btn btn-primary">Guardar Cambios</button></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('profileImage');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush
