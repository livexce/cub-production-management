<?php
include 'header.php';
?>
<main>
    <div class="container">
        <h1>Gestion des Types de Teinte</h1>
        <div class="row bg-light rounded-3 dodiv">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" style="width:200px">Teint</span>
                    <input type="text" class="form-control" id="inputValue" value="">
                </div>
                <center><button class="btn btn-primary" id="save">Enregistrer</button></center>
            </div>
            <div class="col-md-6" id="all-teinte-type"></div>
        </div>
    </div> 
</main>
<br>
<br>

<script>

    getParamTeintTypes();

    function getParamTeintTypes() {
        $.ajax({
            url: "views/all-teinte-type.php",
            success: function (result) {
                $('#all-teinte-type').html(result);
            }
        });
    }

    $('#save').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'addParamTeintType',
                value: $('#inputValue').val()
            },
            success: function (result) {
                $('#inputValue').val('');
                getParamTeintTypes();
            }
        });
    });


</script>
<?php include 'footer.php';
?>



