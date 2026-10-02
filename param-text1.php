<?php
include 'header.php';
?>
<main>
    <div class="container">
        <h1>Gestion des texture1</h1>
        <div class="row bg-light rounded-3 dodiv">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" style="width:200px">Code</span>
                    <input type="text" class="form-control" id="inputparamTypeText" value="">
                </div>
                <center><button class="btn btn-primary" id="save">Enregistrer</button></center>
            </div>
            <div class="col-md-6" id="all-param-text1"></div>
        </div>
    </div> 
</main>
<br>
<br>

<script>

    getParamTeintText1s();

    function getParamTeintText1s() {
        $.ajax({
            url: "views/all-param-text1.php",
            success: function (result) {
                $('#all-param-text1').html(result);
            }
        });
    }

    $('#save').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'addParamTeintText1',
                value: $('#inputparamTypeText').val()
            },
            success: function (result) {
                $('#inputparamTypeText').val('');
                 getParamTeintText1s();
            }
        });
    });


</script>
<?php include 'footer.php';
?>

