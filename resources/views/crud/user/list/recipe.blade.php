@extends('theme.base')

@section('css')
@endsection

@section('content')
    <?php $item=NULL ?>
    @include('theme.header2')
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-12 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <a class="btn btn-form" href="{{route('inventory.index')}}"><i class="bi bi-arrow-left"></i> Atras</a>
                <h1 class="h2"><span class="material-symbols-outlined">restaurant_menu</span> Recetas</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{route('recipes.user')}}" class="btn btn-sm btn-outline-secondary" id="btnlistingredient">Lista</a>
                        <a href="{{route('recipe.create')}}" class="btn btn-sm btn-outline-secondary" id="btnnewingredient">Nueva</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            <div class="row px-3">
                                @forelse ($recipes as $item)
                                    <div class="col-md-4 mb-3"> <!-- Ajusta el tamaño aquí -->
                                        <div class="card card-small">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $item->name }}</h5>
                                                <p class="card-text">{{ $item->description }}</p>
                                                <h6 class="card-subtitle mb-2 text-muted">Ingredientes:</h6>
                                                <ul class="list-unstyled">
                                                    @foreach ($item->ingredients as $ingredient)
                                                        <li>{{ $ingredient->ingredient }}: {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</li>
                                                    @endforeach
                                                </ul>
                                                <p class="card-text">Tiempo: {{ $item->time }} minutos</p>
                                                <a href="{{ route('recipe.edit', $item) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> Editar</a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete" data-id="{{ $item->id }}">
                                                    <i class="bi bi-trash3-fill"></i> Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col">
                                        <div class="alert alert-warning" role="alert">
                                            No se encontraron recetas.
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            {{$recipes->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Modals -->
    @if ($item != NULL)
        @include('modals.delete-recipe')
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
            @if(session('mensaje'))
            $('#modaldelete').modal('show');
            setTimeout(function() {
                $('#modaldelete').modal('hide');
            }, 2000);
            @endif

            $('#modal-delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Botón que disparó el modal
                var id = button.data('id'); // Extraer la información del data-* attribute

                // Actualizar la acción del formulario con el ID correcto
                var form = $(this).find('#deleteForm');
                var action = "{{ route('recipes.destroy', '') }}/" + id;
                form.attr('action', action);
            });
        });
    </script>
@endpush
