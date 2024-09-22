@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/user.css')}}">
@endsection

@section('content')
    <?php $ingredient=NULL ?>
    @include('theme.header2')
    <!-- Navbar -->
    <div class="row justify-content-center">
        <div class="col px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <a class="btn btn-form" href="{{route('profile')}}"><i class="bi bi-arrow-left"></i> Atras</a>
                <h1 class="h2"><span class="material-symbols-outlined">inventory</span> Inventario</h1>
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="{{route('ingredient.create')}}" class="btn btn-sm btn-outline-secondary" id="btnlistingredient">Nuevo ingrediente</a>
                        <a href="{{route('recipes.user')}}" class="btn btn-sm btn-outline-secondary" id="btnnewingredient">Mis recetas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <main class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h2>Inventario de Alimentos</h2>
        </div>
        <!-- Formulario para agregar alimento -->
        <div class="accordion mb-4" id="accordionNewFood">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNewFood">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNewFood" aria-expanded="true" aria-controls="collapseNewFood">
                        Añadir Nuevo Alimento
                    </button>
                </h2>
                <div id="collapseNewFood" class="accordion-collapse collapse show" aria-labelledby="headingNewFood" data-bs-parent="#accordionNewFood">
                    <div class="accordion-body">
                        <form action="{{route('inventory.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col d-grid gap-2">
                                    <label for="searchIngredient">Nombre del alimento</label>
                                    <input type="text" class="form-control form-group @error('ingredient') is-invalid @enderror" id="searchIngredient" placeholder="Alimento">
                                    @error('ingredient')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <input type="hidden" name="ingredient" id="ingredientIdInput">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <ul class="list-group position-absolute w-75" id="results" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></ul>
                                </div>
                            </div>
                            <?php
                            $units = \App\Models\Unit::orderBy('unit', 'asc')->get();
                            ?>
                            <div class="row mt-3">
                                <div class="col-lg-5 col">
                                    <input type="text" class="form-control quantity @error('quantity') is-invalid @enderror" name="quantity" placeholder="Cantidad" value="{{ old('quantity') }}" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-5 col">
                                    <select class="form-control" name="unit" required>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">
                                                {{ $unit->unit }} ({{ $unit->acronym }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col d-grid">
                                    <button type="submit" class="btn btn-form btn-block"><i class="bi bi-floppy"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de alimentos -->
        <div class="row">
            @forelse($ingredients as $ingredient)
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="card food-card">
                        <img src="@if($ingredient->photo) {{ url('/uploads/ingredients/'.$ingredient->photo) }} @else {{ asset('assets/img/examplePicture.webp') }} @endif" class="card-img-top" alt="{{ $ingredient->ingredient }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ $ingredient->ingredient }}</h6>
                            @php
                                $unit = \App\Models\Unit::find($ingredient->pivot->fk_unit);
                            @endphp
                            <p class="card-text">Cantidad: {{ $ingredient->pivot->quantity }} {{ $unit ? $unit->unit : 'Unidad no disponible' }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editIngredientModal"
                                    data-id="{{ $ingredient->id }}"
                                    data-quantity="{{ $ingredient->pivot->quantity }}"
                                    data-unit="{{ $ingredient->pivot->fk_unit }}">
                                Editar
                            </button>

                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete" data-id="{{ $ingredient->id }}">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p>No hay ingredientes en tu inventario.</p>
            @endforelse
        </div>
    </main>
    @if ($ingredient != NULL)
        @include('modals.delete-ingredient')
        @include('modals.edit-ingredient-inventory')
    @endif
    @include('modals.modals')
    @include('modals.success')
@endsection

@push('js')
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

                // Asigna el ingrediente seleccionado al input de búsqueda y el ID al input oculto
                $('#searchIngredient').val(ingredient);
                $('#ingredientIdInput').val(id);

                // Oculta la lista de resultados
                $("#results").empty().hide();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Reabrir el modal si hay errores de validación
            @if ($errors->any())
            $('#editIngredientModal').modal('show');
            @endif

            // Escuchar el evento click de los botones con clase 'edit-btn'
            $('.edit-btn').on('click', function() {
                // Obtener los datos del botón
                var ingredientId = $(this).data('id');
                var quantity = $(this).data('quantity');
                var unitId = $(this).data('unit');

                // Asignar los datos al modal
                $('#editIngredientModal #editIngredientId').val(ingredientId);
                $('#editIngredientModal #editIngredientQuantity').val(quantity);
                $('#editIngredientModal #editIngredientUnit').val(unitId);  // Selecciona la unidad correspondiente en el select

                // Actualizar el atributo action del formulario
                var formAction = '{{ route("inventory.update", ":id") }}';
                formAction = formAction.replace(':id', ingredientId);
                $('#editIngredientModal form').attr('action', formAction);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            @if(session('mensaje'))
            $('#modalcrud').modal('show');
            setTimeout(function() {
                $('#modalcrud').modal('hide');
            }, 2000);
            @endif
            @if(session('success'))
            $('#modalsuccess').modal('show');
            setTimeout(function() {
                $('#modalsuccess').modal('hide');
            }, 2000);
            @endif
            $('#modal-delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Botón que disparó el modal
                var id = button.data('id'); // Extraer la información del data-* attribute

                // Actualizar la acción del formulario con el ID correcto
                var form = $(this).find('#deleteForm');
                var action = "{{ route('inventory.destroyIngredient', '') }}/" + id;
                form.attr('action', action);
            });
        });
    </script>
@endpush
