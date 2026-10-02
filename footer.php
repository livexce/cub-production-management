<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                <button type="button" class="btn-close modal_close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="modal_text">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal_close" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<script>
    function alertDO(message) {
        $('#modal_text').html(message);
        $('#myModal').modal('show');
    }

    $('.modal_close').click(function () {
        $('#myModal').modal('hide');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>