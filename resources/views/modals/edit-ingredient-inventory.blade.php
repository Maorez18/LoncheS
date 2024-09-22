<div class="modal fade" id="editIngredientModal" tabindex="-1" aria-labelledby="editIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIngredientModalLabel">Editar Ingrediente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventory.update', $ingredient->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="ingredient_id" id="editIngredientId">
                    <div class="mb-3">
                        <label for="editIngredientQuantity" class="form-label">Cantidad</label>
                        <input type="text" class="form-control @error('quantity') is-invalid @enderror" id="editIngredientQuantity" name="quantity" value="{{ old('quantity', $ingredient->pivot->quantity) }}" required>
                        @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="editIngredientUnit" class="form-label">Unidad</label>
                        <select class="form-control @error('unit') is-invalid @enderror" id="editIngredientUnit" name="unit" required>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit', $ingredient->pivot->fk_unit) == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit }} ({{ $unit->acronym }})
                                </option>
                            @endforeach
                        </select>
                        @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
