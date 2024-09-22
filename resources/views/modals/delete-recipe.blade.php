<div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col text-center">
                        <img src="{{ asset('assets/gif/confusion.gif') }}" class="img-fluid gif-modal" alt="edit.gif">
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <h5>¿Seguro de querer eliminar esto?</h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Si, eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>