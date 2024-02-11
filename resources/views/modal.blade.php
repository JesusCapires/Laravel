<div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Título del modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="contenido-dinamico" class="contenido-inicial">
                    ...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(content) {

        $('#contenido-dinamico').html(content);
        $('#miModal').modal('show');

    }
</script>
