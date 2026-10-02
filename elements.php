<?php
include 'header.php';
?>
<main>
    <div class="container">
        <h1>Gestion des Elements</h1>
        <div class="row bg-light rounded-3 dodiv">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" style="width:200px">Element</span>
                    <input type="text" class="form-control" id="inputElement" name="">
                </div>
                <center><button class="btn btn-primary" id="save">Enregistrer</button></center>
            </div>
            <div class="col-md-6" id="all-element"></div>
        </div>
    </div> 
</main>
<br>
<br>

<script>

    getElements();

    function getElements() {
        $.ajax({
            url: "views/all-element.php",
            success: function (result) {
                $('#all-element').html(result);
            }
        });
    }

    $('#save').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'addElement',
                name: $('#inputElement').val()
            },
            success: function (result) {
                $('#inputElement').val('');
                getElements();
            }
        });
    });


</script>
<?php include 'footer.php';
?>

