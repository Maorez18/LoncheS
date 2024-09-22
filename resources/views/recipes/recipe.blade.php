@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/form-group.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/recipe.css')}}">
@endsection

@section('content')
    <?php $comment=NULL ?>
    <div id="preloader">
        <div class="spinner">
            <div class="loader"></div>
        </div>
    </div>
    @include('theme.header2')
    <main class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="d-lg-none">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="mb-3">
                                {{$recipe->name}}
                            </h2>
                        </div>
                        <div class="col-12 text-center">
                            <img src="@if($recipe->photo) {{ url('/uploads/recipes/'.$recipe->photo) }} @else {{ asset('assets/img/examplePicture.webp') }} @endif" class="img-fluid recipe-image w-100 mb-3 rounded" alt="{{$recipe->name}}" style="height: 20em;">
                        </div>
                        <div class="col-12">
                            <p class="lead">{{$recipe->description}}</p>
                        </div>
                    </div>
                </div>
                <div class="d-none d-lg-block">
                    <div class="row">
                        <div class="col-6 text-center">
                            <img src="@if($recipe->photo) {{ url('/uploads/recipes/'.$recipe->photo) }} @else {{ asset('assets/img/examplePicture.webp') }} @endif" class="img-fluid recipe-image w-100 mb-3 rounded" alt="{{$recipe->name}}" style="height: 20em;">
                        </div>
                        <div class="col-5">
                            <h2 class="mb-3">
                                {{$recipe->name}}
                            </h2>
                            <p class="lead">{{$recipe->description}}</p>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col">
                        @if(auth()->check())
                            <button id="favorite-btn" class="{{ $isFavorite ? 'btn btn-danger' : 'btn btn-outline-danger' }}">
                                <i class="{{ $isFavorite ? 'bi bi-bookmark-heart-fill' : 'bi bi-bookmark-heart' }}"></i>
                                {{ $isFavorite ? 'Favorito' : 'Marcar como favorito' }}
                            </button>
                        @else
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="bi bi-bookmark-heart"></i> Inicia sesión para marcar como favorito
                            </button>
                        @endif
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h3>Ingredientes</h3>
                        <ul class="list-group mb-4">
                            @foreach ($recipe->ingredients as $ingredient)
                                @php
                                    if (Auth::check()){
                                        if (auth()->user()->fk_type==3){
                                            // Encontrar el inventario del ingrediente en la lista obtenida
                                            $ingredientInventory = $ingredientInventories->firstWhere('ingredient_id', $ingredient->id);
                                            // Obtener la unidad si el ingrediente está en el inventario
                                            $unitInventory = $ingredientInventory ? \App\Models\Unit::find($ingredientInventory->fk_unit) : null;
                                            // Obtener la cantidad en el inventario
                                            $quantityInInventory = $ingredientInventory->quantity ?? 0;
                                        }
                                    }
                                    $unit = \App\Models\Unit::find($ingredient->pivot->fk_unit);
                                @endphp
                                <li class="list-group-item">
                                    {{ $ingredient->ingredient }}: {{ $ingredient->pivot->quantity }} {{ $unit ? $unit->acronym : 'Unidad no disponible' }}
                                    @if(Auth::check())
                                        @if(auth()->user()->fk_type==3)
                                            <br>
                                            @if($quantityInInventory > 0)
                                                <span class="text-success">Tienes {{ $quantityInInventory }} {{ $unitInventory ? $unitInventory->acronym : 'Unidad no disponible' }} en tu inventario.</span>
                                            @else
                                                <span class="text-danger">No tienes este ingrediente en tu inventario.</span>
                                            @endif
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if(Auth::check())
                        @if(auth()->user()->fk_type==3)
                            <div class="col-lg-4 text-center">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <p class="fs-3">Tienes un</p>
                                    <div class="rounded-circle d-flex justify-content-center align-items-center bg-success text-white"
                                         style="width: 100px; height: 100px;">
                                        <strong class="fs-2">{{ round($percentage, 1) }}%</strong>
                                    </div>
                                    <p class="fs-3">de los ingredientes</p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Preparacion</h3>
                        <ol class="list-group list-group-numbered mb-4"  id="preparationList">
                            @foreach($preparations as $step)
                                <li class="list-group-item">
                                    {{$step}}
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <h3>Comentarios</h3>
                <div class="mb-4 col-lg-8">
                    @foreach($comments as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $comment->user->nickname }}</h5>
                                <p class="card-text">{{ $comment->comment }}</p>
                            </div>
                            @if(auth()->check() && $comment->user->id==auth()->user()->id)
                                <div class="card-footer">
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete" data-id="{{ $comment->id }}">
                                        <i class="bi bi-trash3-fill"></i> Eliminar
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mb-4 col-lg-8">
                    <form action="{{route('comments.store', $recipe)}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="comment" class="form-label fs-4">Deja tu comentario</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3"></textarea>
                            @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if(auth()->check())
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Enviar</button>
                        @else
                            <button class="btn btn-secondary" disabled><i class="bi bi-send-slash"></i> Inicia sesión para comentar</button>
                        @endif
                    </form>
                </div>
            </div>
            {{--<aside class="col-lg-4">
                <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Recetas Favoritas</h5>
                    <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-heart-fill favorite-icon"></i> Receta Favorita 1</li>
                    <li class="mb-2"><i class="bi bi-heart-fill favorite-icon"></i> Receta Favorita 2</li>
                    <li class="mb-2"><i class="bi bi-heart-fill favorite-icon"></i> Receta Favorita 3</li>
                    </ul>
                </div>
                </div>

                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Publicaciones del Usuario</h5>
                    <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-file-earmark-text"></i> Publicación 1</li>
                    <li class="mb-2"><i class="bi bi-file-earmark-text"></i> Publicación 2</li>
                    <li class="mb-2"><i class="bi bi-file-earmark-text"></i> Publicación 3</li>
                    </ul>
                </div>
                </div>
            </aside>--}}
        </div>
    </main>
@include('theme.footer')
@endsection

@if ($comment != NULL)
    @include('modals.delete-comment')
@endif
@include('modals.modals')
@include('modals.success')

@push('js')
    <script src="{{asset('js/preloader.js')}}"></script>
    <script src="{{asset('js/header.js')}}"></script>
    <script src="{{asset('js/admin/stepsRecipe.js')}}"></script>
    <script>
        $(document).ready(function () {
            @if(session('success'))
            $('#modalsuccess').modal('show');
            setTimeout(function () {
                $('#modalsuccess').modal('hide');
            }, 2000);
            @endif
        });
    </script>
    <script>
        $('#favorite-btn').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('recipes.toggleFavorite', $recipe->id) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let button = $('#favorite-btn');

                    // Cambiar las clases del botón
                    button.toggleClass('btn-danger btn-outline-danger');

                    // Cambiar el contenido del botón: ícono y texto
                    let isFavorite = button.hasClass('btn-danger');

                    // Usar html() para agregar íconos y texto dinámicamente
                    button.html(isFavorite ? '<i class="bi bi-bookmark-heart-fill"></i> Favorito'
                        : '<i class="bi bi-bookmark-heart"></i> Marcar como favorito');
                }
            });
        });
    </script>
@endpush
