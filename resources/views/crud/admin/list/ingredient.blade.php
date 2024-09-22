@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">
@endsection

@section('content')
    <?php $item=NULL ?>
    <div class="row">
        @include('theme.admin.header')
        @include('theme.admin.aside3')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><span class="material-symbols-outlined">grocery</span> Ingredientes</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{route('ingredients.index')}}" class="btn btn-sm btn-outline-secondary" id="btnlistingredient">Lista</a>
                        <a href="{{route('ingredients.create')}}" class="btn btn-sm btn-outline-secondary" id="btnnewingredient">Nuevo</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row p-3">
                        <div class="col">
                            <h2>Listado ingredientes</h2>
                            <form method="GET" action="{{ route('ingredients.index') }}">
                                <div class="row mb-3">
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre" value="{{ request('search') }}">
                                    </div>
                                    <div class="accordion mb-3 col-3" id="accordionCategories" style="position: relative;">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingCategories">
                                                <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false" aria-controls="collapseCategories">
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
                                                                    {{ $category->category }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-primary">Filtrar</button>
                                        <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Limpiar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row px-3">
                        @forelse ($ingredients as $item)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <div class="card" style="width: 100%;">
                                    <img src="@if($item->photo) {{ url('/uploads/ingredients/'.$item->photo) }} @else {{ asset('assets/img/examplePicture.webp') }} @endif" class="card-img-top" alt="{{ $item->ingredient }}">
                                    <div class="card-body text-center">
                                        <h6 class="card-title" style="font-size: 1rem;">{{ $item->ingredient }}</h6>
                                        <p class="card-text" style="font-size: 0.7rem;">{{ $item->category ? $item->category->category : 'N/A' }}</p>
                                        <a href="{{ route('ingredients.edit', $item) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete" data-id="{{ $item->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col">
                                <div class="alert alert-warning" role="alert">
                                    No se encontraron ingredientes.
                                </div>
                            </div>
                        @endforelse
                    </div>
                    {{$ingredients->links()}}
                </div>
            </div>
        </main>
    </div>

    <!-- Modals -->
    @if ($item != NULL)
        @include('modals.delete-ingredient')
    @endif
    @include('modals.modals')
    @include('modals.error')
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
        @if(session('error'))
        $('#modalerror').modal('show');
        setTimeout(function() {
            $('#modalerror').modal('hide');
        }, 2000);
        @endif
        $('#modal-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que disparó el modal
            var id = button.data('id'); // Extraer la información del data-* attribute

            // Actualizar la acción del formulario con el ID correcto
            var form = $(this).find('#deleteForm');
            var action = "{{ route('ingredients.destroy', '') }}/" + id;
            form.attr('action', action);
        });
    });
</script>
@endpush
