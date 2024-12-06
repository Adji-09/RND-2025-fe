<div id="modalConfirmDelete" class="modal fade zoomIn" tabindex="-1" aria-labelledby="zoomInModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomInModalLabel">Remove</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                <h5>Are you sure you want to remove this data?</h5>
                <textarea id="getIdDelete" class="id_delete" hidden></textarea>

                <div class="hstack gap-2 justify-content-center mt-3">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ URL('/profile/remove_face') }}" onclick="removeById(); location.href=this.href+'/'+document.getElementById('getIdDelete').value;return false;" class="btn btn-danger waves-effect">Yes</a>
                </div>
            </div>
        </div>
    </div>
</div>
