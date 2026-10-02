<?php
include 'header.php';
?>
<main>
    <div class="container">
        <h1>Emballage</h1>
        <div class="row bg-light rounded-3 dodiv">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" style="width:200px">Code</span>
                    <input type="text" class="form-control" id="inputparamembal" value="">
                </div>
                <center><button class="btn btn-primary" id="save">Enregistrer</button></center>
            </div>
            <div class="col-md-6" id="all-param-embal"></div>
        </div>
    </div> 
</main>
<br>
<br>

<script>

    getParamEmbals();

    function getParamEmbals() {
        $.ajax({
            url: "views/all-param-embal.php",
            success: function (result) {
                $('#all-param-embal').html(result);
            }
        });
    }

    $('#save').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'addParamEmbal',
                value: $('#inputparamembal').val()
            },
            success: function (result) {
                $('#inputparamembal').val('');
                getParamEmbals();
            }
        });
    });


</script>
<?php include 'footer.php';
?>

