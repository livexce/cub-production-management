<?php
include 'header.php';
?>
<main>
    <div class="container">
        <h1>Gestion des texture2</h1>
        <div class="row bg-light rounded-3 dodiv">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" style="width:200px">Code</span>
                    <input type="text" class="form-control" id="inputparamTypeText1" value="">
                </div>
                <center><button class="btn btn-primary" id="save">Enregistrer</button></center>
            </div>
            <div class="col-md-6" id="all-param-text2"></div>
        </div>
    </div> 
</main>
<br>
<br>

<script>

    getParamTeintText2s();

    function getParamTeintText2s() {
        $.ajax({
            url: "views/all-param-text2.php",
            success: function (result) {
                $('#all-param-text2').html(result);
            }
        });
    }

    $('#save').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'addParamTeintText2',
                value: $('#inputparamTypeText1').val()
            },
            success: function (result) {
                $('#inputparamTypeText1').val('');
                getParamTeintText2s();
            }
        });
    });


</script>
<?php include 'footer.php';
?>

