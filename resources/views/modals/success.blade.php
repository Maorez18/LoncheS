<div class="modal fade" id="modalsuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col text-center">
                        <img src="{{ asset('assets/gif/check.gif') }}" class="img-fluid gif-modal" alt="edit.gif">
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <h5>{{ session('success') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
