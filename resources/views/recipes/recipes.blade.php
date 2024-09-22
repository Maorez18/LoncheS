@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/form-group.css')}}">
@endsection

@section('content')
    <div id="preloader">
        <div class="spinner">
            <div class="loader"></div>
        </div>
    </div>

    @include('theme.header2')

    <main class="container my-5">
        <div class="row">
            <!-- Aside para los filtros -->
            <aside class="col-md-3 mb-4">
                <form method="GET" action="{{ route('recipes.index') }}">
                    <div class="row mb-3">
                        <div class="col-lg-12 mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre" value="{{ request('search') }}">
                        </div>
                        <div class="accordion mb-3 col-12" id="accordionCategories" style="position: relative;">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCategories">
                                    <button class="accordion-button p-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false" aria-controls="collapseCategories">
                                        Categorías
                                    </button>
                                </h2>
                                <div id="collapseCategories" class="accordion-collapse collapse" aria-labelledby="headingCategories" data-bs-parent="#accordionCategories" style="position: absolute; z-index: 999; background: white;">
                                    <div class="accordion-body">
                                        <div class="d-flex flex-wrap">
                                            @foreach($categories as $category)
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" id="category-{{ $category->id }}"
                                                           @if(in_array($category->id, request()->input('category', []))) checked @endif>
                                                    <label class="form-check-label" for="category-{{ $category->id }}">
                                                        {{ $category->type_recipe }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="{{ route('recipes.index') }}" class="btn btn-secondary">Limpiar</a>
                        </div>
                    </div>
                </form>
            </aside>

            <!-- Listado de recetas -->
            <div class="col-md-9">
                <h1 class="mb-4">Listado de Recetas</h1>
                <div class="recipe-list">
                    @foreach($recipes as $recipe)
                        <div class="recipe-card row align-items-center mb-3 border-bottom">
                            <div class="recipe-content col-12 col-md-3 d-flex justify-content-center">
                                <img src="@if($recipe->photo) {{ url('/uploads/recipes/'.$recipe->photo) }} @else {{ asset('assets/img/examplePicture.webp') }} @endif" class="recipe-img rounded mb-3 mb-md-0" alt="Receta" style="width: 100%; height: 150px; object-fit: cover;">
                            </div>
                            <div class="col-12 col-md-9">
                                <div class="m-3 text-md-left">
                                    <h5 class="recipe-name">{{$recipe->name}}</h5>
                                    <p class="recipe-time">Tiempo de preparación: {{$recipe->time}} minutos</p>
                                    <p class="recipe-description">{{$recipe->description}}</p>
                                    <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-form mt-auto">Ver más</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>


    @include('theme.footer')

@endsection

@push('js')
    <script src="{{asset('js/preloader.js')}}"></script>
    <script src="{{asset('js/header.js')}}"></script>
    <script src="{{asset('js/admin/stepsRecipe.js')}}"></script>
@endpush
