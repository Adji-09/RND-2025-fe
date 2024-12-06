<div id="modalAlertSuccessPassword" class="modal fade zoomIn" tabindex="-1" aria-labelledby="zoomInModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomInModalLabel">Success</h5>
            </div>
            <div class="modal-body text-center">
                <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="loop" colors="primary:#0AB39C,secondary:#FFFFFF" style="width:100px;height:100px"></lord-icon>
                <h5 class="mt-3">
                    @if (session()->has('success_password'))
                        {{ session()->get('success_password') }}
                    @endif
                </h5>

                <div class="hstack gap-2 justify-content-center">
                    <a href="{{ route('logout') }}" class="btn btn-warning waves-effect waves-light">
                        <i class="ri-logout-box-line align-middle me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
