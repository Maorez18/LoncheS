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
                <h1 class="h2"><span class="material-symbols-outlined">restaurant_menu</span> Recetas</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{route('recipes.index')}}" class="btn btn-sm btn-outline-secondary" id="btnlistingredient">Lista</a>
                        <a href="{{route('recipes.create')}}" class="btn btn-sm btn-outline-secondary" id="btnnewingredient">Nueva</a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 rounded-4 p-3">
                    <div class="row mb-5">
                        <div class="col text-center">
                            <h2>{{ isset($recipe) ? 'Editar receta' : 'Crear receta' }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="{{ isset($recipe) ? route('recipes.update', $recipe) : route('recipes.store') }}" method="post" enctype="multipart/form-data" id="ingredientForm">
                                @csrf
                                @if (isset($recipe))
                                    @method('PUT')
                                @endif
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nombre de la Receta" value="{{ old('name', $recipe->name ?? '') }}" required>
                                            <label for="name">Nombre de la Receta</label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control @error('time') is-invalid @enderror" id="time" name="time" placeholder="Tiempo de Preparación (minutos)" value="{{ old('time', $recipe->time ?? '') }}" required>
                                            <label for="time">Tiempo de Preparación (minutos)</label>
                                            @error('time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="categorySelect" aria-label="Floating label select example" name="category">
                                                @foreach ($typerecipes as $typerecipe)
                                                    <option value="{{ $typerecipe->id }}" {{ (old('typerecipe') == $typerecipe->id || (isset($recipe) && $recipe->fk_type_recipe == $typerecipe->id)) ? 'selected' : '' }}>
                                                        {{ $typerecipe->type_recipe }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="categorySelect">Categoria de la receta</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" class="form-control" id="searchIngredient" placeholder="Buscar ingrediente">
                                        <ul class="list-group position-absolute w-75" id="results" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></ul>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <table class="table table-bordered" id="selected-ingredients">
                                            <thead>
                                            <tr>
                                                <th>Ingrediente</th>
                                                <th>Cantidad</th>
                                                <th>Unidad</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (isset($recipe))
                                                @foreach ($recipe->ingredients as $ingredient)
                                                    <tr id="selected-ingredient-{{ $ingredient->id}}">
                                                        <td>{{ $ingredient->ingredient }}</td>
                                                        <td>
                                                            <input type="text" class="form-control quantity" name="ingredients[{{ $ingredient->id }}][quantity]" value="{{ $ingredient->pivot->quantity }}" required>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" name="ingredients[{{ $ingredient->id }}][unit_id]" required>
                                                                @foreach ($units as $unit)
                                                                    <option value="{{ $unit->id }}" {{ $unit->id == $ingredient->pivot->fk_unit ? 'selected' : '' }}>
                                                                        {{ $unit->unit }} ({{ $unit->acronym }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><button type="button" class="btn btn-danger" onclick="removeIngredient({{ $ingredient->id }})">Eliminar</button></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <div class="invalid-feedback">
                                            Por favor ingresa una cantidad válida (número entero o fracción, ejemplo: 1/2).
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Descripción" required>{{ old('description', $recipe->description ?? '') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="preparation" class="form-label">Pasos de la preparación</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control @error('preparation') is-invalid @enderror" id="preparationInput" placeholder="Escribe un paso" aria-label="Escribe un paso">
                                            <button class="btn btn-outline-secondary" type="button" id="addStepBtn">Añadir Paso</button>
                                            @error('preparation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <ol class="list-group list-group-numbered" id="preparationList">
                                            @if(isset($preparations) && !empty($preparations))
                                                @foreach($preparations as $step)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div class="row w-100">
                                                            <div class="col-lg-9 col-12 ps-3">
                                                                <span class="step-text">{{ $step }}</span>
                                                            </div>
                                                            <div class="col-lg-2 col-12 d-flex">
                                                                <button type="button" class="btn btn-sm btn-warning me-2" onclick="editStep(this)">Editar</button>
                                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeStep(this)">Eliminar</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ol>
                                    </div>
                                </div>
                                <!-- Este input oculto almacenará todos los pasos concatenados -->
                                <input type="hidden" id="preparationHiddenInput" name="preparation" value="{{ isset($preparations) ? implode('@', $preparations) : '' }}">
                                <div class="row align-items-center mb-3">
                                    <div class="form-group col-lg-8">
                                        <div class="mb-3">
                                            <label for="photo" class="mb-2">Imagen</label>
                                            <input type="file" class="form-control" id="photo" name="photo" accept=".png, .jpg, .jpeg, .webp, .svg" onchange="previewImage(event)">
                                            @if (isset($recipe) && $recipe->photo)
                                                <span class="text-muted">{{ $recipe->photo }}</span>
                                            @else
                                                <span class="text-muted">Selecciona un archivo</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-end">
                                        @if (isset($recipe))
                                            <div id="imagePreview" class="my-3 rounded imagePreview" style="@if($recipe->photo != NULL) background-image: url('{{url('/')}}/uploads/recipes/{{$recipe->photo}}') @else background-image: url('{{asset('assets/img/examplePicture.webp')}}') @endif;"></div>
                                        @else
                                            <div id="imagePreview" class="my-3 rounded imagePreview"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-end">
                                        <a href="{{ route('recipes.index') }}" class="mx-3">Cancelar</a>
                                        <button type="submit" class="btn btn-lg btn-form">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $('#searchIngredient').on("keyup", function(){
                var query = $(this).val();
                if(query.length === 0) {
                    $("#results").empty();
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
                                    "<li class='list-group-item'>" +
                                        "<input class='form-check-input me-1 ingredient-checkbox' type='checkbox' value='" + data[i].id + "' data-ingredient='" + data[i].ingredient + "' id='ingredientCheckbox" + data[i].id + "'>" +
                                        "<label class='form-check-label' for='ingredientCheckbox" + data[i].id + "'>" + data[i].ingredient + "</label>" +
                                    "</li>"
                                );
                            }
                        } else {
                            $("#results").append(
                                "<div class='list-group-item'>No hay resultados</div>"
                            );
                        }
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                    }
                });
            });

            // Event delegation for dynamically added checkboxes
            $(document).on('change', '.ingredient-checkbox', function(){
                if ($(this).is(':checked')) {
                    addIngredientToTable($(this).val(), $(this).data('ingredient'));
                } else {
                    removeIngredientFromTable($(this).val());
                }
            });
        });

        function addIngredientToTable(id, ingredient) {
            if ($('#selected-ingredient-' + id).length == 0) {
                $('#selected-ingredients tbody').append(`
                    <tr id="selected-ingredient-${id}">
                        <td>${ingredient}</td>
                        <td>
                            <input type="text" class="form-control quantity" name="ingredients[${id}][quantity]" required>
                            @error('ingredients.*.quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <select class="form-control" name="ingredients[${id}][unit_id]" required>
                                @foreach ($units as $unit)
                                    <option value="{{$unit->id}}">{{$unit->unit}} ({{$unit->acronym}})</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-danger" onclick="removeIngredient(${id})">Eliminar</button></td>
                    </tr>
                `);
            }
        }

        function removeIngredient(id) {
            $('#selected-ingredient-' + id).remove();
            $('#ingredientCheckbox' + id).prop('checked', false);
        }
    </script>
    <script src="{{asset('js/admin/previewImage.js')}}"></script>
    <script src="{{asset('js/admin/stepsRecipe.js')}}"></script>
    <script>
        document.getElementById('ingredientForm').addEventListener('submit', function(event) {
            const quantityInputs = document.getElementsByClassName('quantity'); // Selecciona todos los inputs con clase 'quantity'
            const fractionRegex = /^\d+(\.\d{1,})?$|^\d+\/\d+$/; // Expresión regular para validar número entero o fracción
            let allValid = true; // Bandera para verificar si todos son válidos

            // Recorre todos los elementos con clase 'quantity'
            Array.from(quantityInputs).forEach(function(input) {
                const quantityValue = input.value.trim(); // Obtiene el valor del input actual y elimina espacios en blanco

                // Verifica si el valor es válido
                if (!fractionRegex.test(quantityValue)) {
                    allValid = false; // Si encuentra un valor inválido, cambia la bandera
                    input.classList.add('is-invalid'); // Agrega una clase para marcar el campo como inválido (puedes personalizar el estilo con CSS)
                    console.log("Inválido: " + quantityValue);
                } else {
                    input.classList.remove('is-invalid'); // Elimina la clase si es válido
                    input.classList.add('is-valid'); // Agrega una clase de éxito si es válido (opcional)
                    console.log("Válido: " + quantityValue);
                }
            });

            if (!allValid) {
                event.preventDefault(); // Prevenir el envío si algún valor es inválido
            }
        });
    </script>
@endpush
