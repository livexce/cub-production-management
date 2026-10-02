<?php
include 'header.php';
?>
<main>
    <div class="container">
        <h1>Gestion des codes</h1>
        <div class="row bg-light rounded-3 dodiv">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" style="width:200px">Code</span>
                    <input type="text" class="form-control" id="inputparamTypeCode" value="">
                </div>
                <center><button class="btn btn-primary" id="save">Enregistrer</button></center>
            </div>
            <div class="col-md-6" id="all-param-code"></div>
        </div>
    </div> 
</main>
<br>
<br>

<script>

    getParamTeintCodes();

    function getParamTeintCodes() {
        $.ajax({
            url: "views/all-param-code.php",
            success: function (result) {
                $('#all-param-code').html(result);
            }
        });
    }

    $('#save').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'addParamTeintCode',
                value: $('#inputparamTypeCode').val()
            },
            success: function (result) {
                $('#inputparamTypeCode').val('');
                 getParamTeintCodes();
            }
        });
    });


</script>
<?php include 'footer.php';
?>

