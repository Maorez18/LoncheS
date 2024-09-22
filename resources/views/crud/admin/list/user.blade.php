@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">
@endsection

@section('content')
    <?php $item=NULL ?>
    <div class="row d-flex">
        @include('theme.admin.header')
        @include('theme.admin.aside3')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><span class="material-symbols-outlined">supervisor_account</span> Usuarios</h1>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            <div class="row p-3">
                                <div class="col">
                                    <h2>Listado usuarios</h2>
                                </div>
                            </div>
                            <div class="row px-3">
                                <div class="col">
                                    <!-- Envuelve la tabla dentro de un div table-responsive -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre de usuario</th>
                                                <th>Nombre</th>
                                                <th>Correo electronico</th>
                                                <th>Estado</th>
                                                <th>Tipo</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($users as $item)
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->nickname}}</td>
                                                    <td>{{$item->name}} {{$item->lastname}}</td>
                                                    <td>{{$item->email}}</td>
                                                    <td>@if($item->is_active == 1) Activo @else Inactivo @endif</td>
                                                    <td>{{$item->typeUser->type_user ?? 'Tipo no asignado'}}</td>
                                                    <td>
                                                        <a href="{{route('users.edit', $item)}}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete" data-id="{{ $item->id }}">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">No hay usuarios disponibles</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if($users->count())
                                {{$users->links()}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Modals -->
    @if ($item != NULL)
        @include('modals.delete-user')
    @endif
    @include('modals.modals')
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            @if(session('mensaje'))
            $('#modalcrud').modal('show');
            setTimeout(function() {
                $('#modalcrud').modal('hide');
            }, 2000);
            @endif

            $('#modal-delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Botón que disparó el modal
                var id = button.data('id'); // Extraer la información del data-* attribute

                // Actualizar la acción del formulario con el ID correcto
                var form = $(this).find('#deleteForm');
                var action = "{{ route('users.destroy', '') }}/" + id;
                form.attr('action', action);
            });
        });
    </script>
@endpush
