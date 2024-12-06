<div id="modalAlertSuccess" class="modal fade zoomIn" tabindex="-1" aria-labelledby="zoomInModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomInModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="loop" colors="primary:#0AB39C,secondary:#FFFFFF" style="width:100px;height:100px"></lord-icon>
                <h4 class="mt-3">Success!</h4>
                <p class="text-muted">
                    @if (session()->has('success'))
                        {{ session()->get('success') }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
