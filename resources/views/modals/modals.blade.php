@if (session('mensaje'))
    @if (session('mensaje') == 'Registro exitoso' || session('mensaje') == 'Receta creada exitosamente.')
        @include('modals.success-register')
    @elseif (session('mensaje') == 'Edición exitosa')
        @include('modals.success-edit')
    @elseif (session('mensaje') == 'Registro Eliminado' || session('mensaje') == 'Comentario eliminado.')
        @include('modals.success-delete')
    @endif
@endif
