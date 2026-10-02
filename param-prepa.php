<?php
include 'header.php';
?>
<main>
    <div class="container">
        <h1>Gestion de Prepa</h1>
        <div class="row bg-light rounded-3 dodiv">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" style="width:200px">Prepa</span>
                    <input type="text" class="form-control" id="inputprepa" value="">
                </div>
                <center><button class="btn btn-primary" id="save">Enregistrer</button></center>
            </div>
            <div class="col-md-6" id="all-param-prepa"></div>
        </div>
    </div> 
</main>
<br>
<br>

<script>

    getParamPrepas();

    function getParamPrepas() {
        $.ajax({
            url: "views/all-param-prepa.php",
            success: function (result) {
                $('#all-param-prepa').html(result);
            }
        });
    }

    $('#save').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'addParamPrepa',
                value: $('#inputprepa').val()
            },
            success: function (result) {
                $('#inputprepa').val('');
                getParamPrepas();
            }
        });
    });


</script>
<?php include 'footer.php';
?>

