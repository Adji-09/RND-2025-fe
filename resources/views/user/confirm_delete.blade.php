<div id="modalConfirmDelete" class="modal fade zoomIn" tabindex="-1" aria-labelledby="zoomInModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomInModalLabel">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                <h4>Are you sure?</h4>
                <p class="text-muted">You want to delete this data!</p>
                <textarea id="getIdDelete" class="id_delete" hidden></textarea>

                <div class="hstack gap-2 justify-content-center">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ URL('/user/destroy') }}" onclick="location.href=this.href+'/'+document.getElementById('getIdDelete').value;return false;" class="btn btn-danger">Yes</a>
                </div>
            </div>
        </div>
    </div>
</div>
