@extends('theme.base')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/user.css')}}">
@endsection

@section('content')
    @include('theme.header2')
    <div class="container container-profile pb-3">
        <div class="profile-header row align-items-center bg-dark">
            <div class="col-md-3">
                <img src="{{ auth()->user()->photo ? asset('uploads/users/' . auth()->user()->photo) : 'https://via.placeholder.com/150' }}" alt="Foto de Perfil">
            </div>
            <div class="col-md-6">
                <h2 class="text-light">{{ auth()->user()->nickname }}</h2>
                <p>{{ auth()->user()->name }} {{ auth()->user()->lastname }}</p>
            </div>
            <div class="col-md-3 profile-actions">
                <a href="{{ route('user.edit', auth()->user()) }}" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Editar perfil</a>
            </div>
        </div>

        <?php
            $lunches = \App\Models\Lunch::where('fk_user', auth()->user()->id)
                ->where('is_favorite', true)
                ->join('recipes', 'lunches.fk_recipe', '=', 'recipes.id')
                ->select('recipes.*')
                ->get();
        ?>

        <div class="recipes-section">
            <h3>Recetas Favoritas</h3>
            <div class="portfolio">
                @forelse ($lunches as $recipe)
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="portfolio-item" style="text-decoration: none; color: #000;">
                        <img src="@if($recipe->photo) {{ url('/uploads/recipes/'.$recipe->photo) }} @else {{ asset('assets/img/examplePicture.webp') }} @endif" alt="{{ $recipe->name }}">
                        <h5>{{ $recipe->name }}</h5>
                        <p>{{ Str::limit($recipe->description, 100) }}</p>
                    </a>
                @empty
                    <p>No tienes recetas favoritas.</p>
                @endforelse
            </div>
        </div>
        <div class="profile-body row align-items-center">
            <div class="col-md-6 inventory-section">
                <div class="card disabled">
                    <div class="card-body">
                        <h5 class="card-title">Gestionar Inventario</h5>
                        <p class="card-text">Accede a la sección de inventario para gestionar tus alimentos y tus recetas.</p>
                        <a href="{{route('inventory.index')}}" class="btn btn-primary">Gestionar Inventario</a>
                    </div>
                </div>
            </div>
            @php
                $inventory = \App\Models\Inventory::where('fk_user', auth()->user()->id)->first();
                if ($inventory){
                    // Verificar si el inventario existe antes de intentar obtener los ingredientes
                    if ($inventory) {
                        $ingredients = $inventory->ingredients()->withPivot('quantity', 'fk_unit')->get();
                    } else {
                        $ingredients = collect(); // Si no hay inventario, pasar una colección vacía
                    }
                }
            @endphp
            <div class="col-md-6 inventory-section">
                <div class="card disabled">
                    <div class="card-body">
                        <h5 class="card-title">Elementos con Baja Cantidad</h5>
                        <ul class="inventory-list">
                            @if($inventory)
                                @forelse($ingredients as $ingredient)
                                    @if($ingredient->pivot->quantity<10)
                                        @php
                                            $unit = \App\Models\Unit::find($ingredient->pivot->fk_unit);
                                        @endphp
                                        <li>{{ $ingredient->ingredient }} (Cantidad: {{ $ingredient->pivot->quantity }} {{ $unit ? $unit->unit : 'Unidad no disponible' }})</li>
                                    @endif
                                @empty
                                    <p>No hay ingredientes en tu inventario.</p>
                                @endforelse
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @php
            $recipes = \App\Models\Recipe::orderBy('name', 'asc')->where('fk_creator_recipe', auth()->user()->id)->with('ingredients.unit')->paginate(7);
        @endphp
        <div class="recipes-section p-3 card disabled">
            <h3>Recetas Publicadas</h3>
            @forelse ($recipes as $item)
                <a href="{{ route('recipes.show', $item->id) }}" class="portfolio-item" style="text-decoration: none; color: #000;">
                    <img src="@if($item->photo) {{ url('/uploads/recipes/'.$item->photo) }} @else {{ asset('assets/img/examplePicture.webp') }} @endif" alt="{{ $item->name }}">
                    <h5>{{ $item->name }}</h5>
                    <p>{{ Str::limit($item->description, 100) }}</p>
                </a>
            @empty
                <div class="col">
                    <div class="alert alert-warning" role="alert">
                        No se encontraron recetas.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

@include('theme.footer')

@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hasSubscription = {{ auth()->user()->fk_type === 3 ? 'true' : 'false' }};

            if (hasSubscription) {
                document.querySelectorAll('.card.disabled').forEach(card => {
                    card.classList.remove('disabled');
                });
                document.querySelectorAll('.btn.disabled').forEach(button => {
                    button.classList.remove('disabled');
                });
            }
        });
    </script>
@endpush
