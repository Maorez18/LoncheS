@extends('theme.base')

@section('css')
@endsection

@section('content')
    @include('theme.header2')
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-12 px-md-4">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 rounded-4 p-3">
                    <div class="row mb-5">
                        <div class="col text-center">
                            <h2>Crear ingrediente</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="{{route('ingredient.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('ingredient') is-invalid @enderror" id="ingredient" name="ingredient" placeholder="Nombre ingrediente" value="{{ old('ingredient', $ingredient->ingredient ?? '') }}">
                                            <label for="ingredient">Nombre del ingrediente</label>
                                            @error('ingredient')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="categorySelect" aria-label="Floating label select example" name="category">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ (old('category') == $category->id || (isset($ingredient) && $ingredient->category_id == $category->id)) ? 'selected' : '' }}>
                                                        {{ $category->category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="categorySelect">Categoria del ingrediente</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control @error('calories') is-invalid @enderror" id="calories" name="calories" placeholder="Calorias" min="0" step="0.1" value="{{ old('calories', $ingredient->calories ?? '') }}">
                                            <label for="calories">Calorias</label>
                                            @error('calories')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control @error('protein') is-invalid @enderror" id="protein" name="protein" placeholder="Proteina" min="0" step="0.1" value="{{ old('protein', $ingredient->protein ?? '') }}">
                                            <label for="protein">Proteina</label>
                                            @error('protein')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control @error('carbo') is-invalid @enderror" id="carbo" name="carbo" placeholder="Carbohidratos" min="0" step="0.1" value="{{ old('carbo', $ingredient->carbohydrates ?? '') }}">
                                            <label for="carbo">Carbohidratos</label>
                                            @error('carbo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control @error('fiber') is-invalid @enderror" id="fiber" name="fiber" placeholder="Fibra" min="0" step="0.1" value="{{ old('fiber', $ingredient->fiber ?? '') }}">
                                            <label for="fiber">Fibra</label>
                                            @error('fiber')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control @error('sodium') is-invalid @enderror" id="sodium" name="sodium" placeholder="Sodio" min="0" step="0.1" value="{{ old('sodium', $ingredient->sodium ?? '') }}">
                                            <label for="sodium">Sodio</label>
                                            @error('sodium')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control @error('fat') is-invalid @enderror" id="fat" name="fat" placeholder="Grasas saturadas" min="0" step="0.1" value="{{ old('fat', $ingredient->saturated_fat ?? '') }}">
                                            <label for="fat">Grasas saturadas</label>
                                            @error('fatz')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="form-group col-lg-8">
                                        <div class="mb-3">
                                            <label for="photo" class="mb-2">Imagen</label>
                                            <input type="file" class="form-control" id="photo" name="photo" accept=".png, .jpg, .jpeg, .webp, .svg" onchange="previewImage(event)">
                                            @if (isset($ingredient))
                                                <span class="text-muted">@if ($ingredient->photo != NULL){{$ingredient->photo}}</span> @else Seleciona un archivo</span>@endif
                                            @else
                                                <span class="text-muted">Seleciona un archivo</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        @if (isset($ingredient))
                                            <div id="imagePreview" class="my-3 rounded imagePreview" style="@if($ingredient->photo != NULL) background-image: url('{{url('/')}}/uploads/ingredients/{{$ingredient->photo}}') @else background-image: url('{{asset('assets/img/examplePicture.webp')}}') @endif;"></div>
                                        @else
                                            <div id="imagePreview" class="my-3 rounded imagePreview"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-end">
                                        <a href="{{route('inventory.index')}}" class="mx-3">Cancelar</a>
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
    <script src="{{asset('js/admin/previewImage.js')}}"></script>
@endpush
