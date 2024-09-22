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
    <div id="largeScreenContent" style="display:none;">
        @include('theme.headerlg')
    </div>
    <div id="mediumScreenContent" style="display:none;">
        @include('theme.headermd')
    </div>
    <div id="smallScreenContent" style="display:none;">
        @include('theme.headersm')
    </div>

    <?php
        use App\Models\Ingredient;
        use App\Models\Unit;

        $ingredients = Ingredient::orderBy('ingredient', 'asc')->get();
        $units = Unit::orderBy('unit', 'asc')->get();
    ?>

    <main class="container-fluid">
        <section class="row mt-3 mx-lg-5">
            <div class="col">
                <form action="{{route('recipes.search')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col btn-group">
                            <input type="text" class="form-control form-group" id="searchIngredient" placeholder="Buscar ingrediente">
                            <button type="submit" class="btn btn-form"><i class="bi bi-search"></i> </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <ul class="list-group position-absolute w-75" id="results" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></ul>
                        </div>
                    </div>
                    <div class="row mb-3 mt-2">
                        <div class="col-12 d-flex flex-wrap" id="selected-ingredients">
                            <!-- Los ingredientes seleccionados se añadirán aquí -->
                        </div>
                        <input type="hidden" name="ingredients[]" id="ingredientsInput">
                    </div>
                </form>
            </div>
        </section>
        <?php
            $lastrecipes = \App\Models\Recipe::latest()->take(4)->get();
        ?>
        <section class="row mx-lg-5 justify-content-around">
            @foreach($lastrecipes as $recipe)
                <div class="col-lg-3 col-md-3 col-6 mb-4 d-flex">
                    <div class="card w-100 h-100">
                        <img src="@if($recipe->photo) {{ url('/uploads/recipes/'.$recipe->photo) }} @else {{ asset('assets/img/examplePicture.webp') }} @endif" class="card-img-top" alt="{{$recipe->name}}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title h5-responsive">{{$recipe->name}}</h5>
                            <p class="card-text flex-grow-1">{{$recipe->description}}</p>
                            <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-form mt-auto">Ver más</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
        <section class="row mx-lg-5 my-4 hero1 rounded-5">
            <div class="col">
                <div class="row align-items-center px-lg-5 px-3 py-lg-2 py-4">
                    <div class="col-lg-6 bg-light p-4 rounded-5 text-center shadow-sm">
                        <div class="row">
                            <div class="col text-center">
                                <h2>¿Por que LoncheS?</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <p>Las loncheras saludables aseguran una nutrición balanceada para niños y adultos, mejoran la concentración, el rendimiento y promueven hábitos alimenticios sanos. Además, permiten controlar ingredientes y porciones, garantizando comidas deliciosas y equilibradas. ¡Invierte en tu salud con loncheras nutritivas!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="{{asset('assets/img/healty-cup.webp')}}" alt="img/healty-cup.webp" class="img-fluid img-paralela">
                    </div>
                </div>
            </div>
        </section>
        <section class="row mx-lg-5">
            <div class="col">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/swbfvREkyoI?si=tRAlZwEYZxZh7ywJ" class="rounded-5" allowfullscreen></iframe>
                </div>
            </div>
        </section>
    </main>
    @include('theme.footer')
@endsection

@push('js')
<script src="{{asset('js/preloader.js')}}"></script>
<script src="{{asset('js/header.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#searchIngredient').on("keyup", function(){
            var query = $(this).val();
            if(query.length === 0) {
                $("#results").empty().hide();
                return;
            }
            $.ajax({
                url: "{{ route('ingredients.search') }}",
                method: "GET",
                dataType: 'json',
                data: {
                    query: query
                },
                success: function(data){
                    $("#results").empty();
                    if(data.length > 0){
                        for(let i = 0; i < data.length; i++){
                            $("#results").append(
                                "<button type='button' class='list-group-item list-group-item-action' data-id='"+data[i].id+"' data-ingredient='"+data[i].ingredient+"'>"+data[i].ingredient+"</button>"
                            );
                        }
                        $("#results").show();
                    } else {
                        $("#results").append(
                            "<div class='list-group-item'>No hay resultados</div>"
                        );
                        $("#results").show();
                    }
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                }
            });
        });

        $(document).on('click', '.list-group-item-action', function(){
            var id = $(this).data('id');
            var ingredient = $(this).data('ingredient');
            addIngredientToDiv(id, ingredient);

            // Vaciar el input de búsqueda y ocultar la lista de resultados
            $('#searchIngredient').val('');
            $("#results").empty().hide();
        });
    });

    function addIngredientToDiv(id, ingredient) {
        if ($('#ingredient-checkbox-' + id).length == 0) {
            $('#selected-ingredients').append(`
            <div class="form-check mx-3">
                <input class="form-check-input ingredient-checkbox" type="checkbox" id="ingredient-checkbox-${id}" name="ingredients[]" value="${id}" data-ingredient="${ingredient}" checked>
                <label class="form-check-label" for="ingredient-checkbox-${id}">
                    ${ingredient}
                </label>
            </div>
        `);
            updateIngredientsInput();
        }
    }

    function updateIngredientsInput() {
        let selectedIngredients = [];
        $('.ingredient-checkbox:checked').each(function() {
            selectedIngredients.push($(this).val());
        });
        $('#ingredientsInput').val(selectedIngredients.join(','));
    }

    $(document).on('change', '.ingredient-checkbox', function(){
        if (!$(this).is(':checked')) {
            $(this).closest('.form-check').remove();
            updateIngredientsInput();
        }
    });
</script>
@endpush

