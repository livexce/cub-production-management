<?php
include 'header.php';

$tickets = db::getTickets();
?>
<main>
    <div class="container">
        <h1>Gestionnaire de tickets <?php
            if (!isset($_GET['all']))
                echo "<a href='tickets.php?all=1' class='btn btn-light btn-sm'>Voir tout</a>";
            else
                echo "<a href='tickets.php' class='btn btn-light btn-sm'>Voir mes tickets</a>";
            ?></h1>
        <input type="hidden" id="all" value="<?php
        if (isset($_GET['all'])) {
            echo 1;
        } else {
            echo 0;
        }
        ?>">
        <div class="col-lg-12 mx-auto" style="padding-top:10px">
            <div class="row bg-light rounded-3" id="tickets" style="font-size:14px;padding:15px;">
            </div>
        </div>
    </div>
</main>
<br>
<br>

<script>
    getAllTickets();

    function getAllTickets() {
        $('#tickets').html('<center><img src="img/loading.gif" style="width:60px"></center>');
        $.ajax({
            url: "views/all-tickets.php",
            data: {
                all: $('#all').val()
            },
            success: function (result) {
                $('#tickets').html(result);
                return false;
            },
            error: function (result) {
                console.log(result);
                return false;
            }
        });
    }
</script>
<?php include 'footer.php'; ?>
