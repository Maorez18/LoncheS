<div class="modal fade" id="modalerror" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        @if($errors->has('error'))
                            <h5>{{ $errors->first('error') }}</h5>
                        @elseif(session('error'))
                            <h5>{{ session('error') }}</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
