<?php
$idReception = $_GET['id_reception'];
if (!$idReception) {
    include('lib/db.php');
    $idReception = db::createEmptyReception();
    header('Location: ./reception.php?id_reception=' . $idReception);
    exit;
}

include 'header.php';

$reception = db::getReception($idReception);
?>
<main>
    <?php if (!$reception['id_customer']) { ?>
        <div class="container">
            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h1>Accueil n°<?php echo $reception['id_reception'] ?> du <?= dateFormat($reception['date_reception']) ?></h1>
                    <h2>Client</h2><hr>
                    <div class="col-6">
                        <input type="hidden" class="form-control" id="inputIdReception" value="<?php echo $reception['id_reception'] ?>">
                        <input type="hidden" class="form-control" id="inputIdCustomer" value="">
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:180px">Code</span>
                            <input type="text" class="form-control" id="inputCustomerCode" value="<?php echo $customer['code'] ?>">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:180px">Nom</span>
                            <input type="text" class="form-control" id="inputCustomerName" id="filter_customer_name" value="<?php echo $customer['name'] ?>">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:180px">Téléphone</span>
                            <input type="text" class="form-control" id="inputCustomerPhone" value="<?php echo $customer['phone'] ?>">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:180px">Email</span>
                            <input type="text" class="form-control" id="inputCustomerEmail" name="inputCustomerEmail" value="<?php echo $customer['email'] ?>">
                        </div>
                        <div class="input-group mb-2">
                            <input class="form-control btn btn-primary" id="update_customer" type="button" value="Valider">
                        </div>
                    </div>
                    <div class="col-6"> 
                        <div class="input-group mb-2">
                            <input type="text" id="search_customer" class="form-control" placeholder="Rechercher">
                        </div>
                        <div id="customer_table" style="height:200px;overflow-y:scroll"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        $customer = db::getCustomer($reception['id_customer']);
        ?>
        <div class="container">
            <h1>Accueil n°<?php echo $reception['id_reception'] ?> du <?= dateFormat($reception['date_reception']) ?> - <?= $customer['name'] ?></h1>
            <input type="hidden" id="id_reception" value="<?= $reception['id_reception'] ?>">
            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h2 style="color:black">Réceptions</h2>
                    <hr>
                    <div id="receptions"></div>
                </div>
                <br>
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h2 style="color:black">Livraisons</h2>
                    <hr>
                </div>
                <br>
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h2 style="color:black">Commentaire</h2>
                    <hr>
                    <textarea <?php if ($reception['reception_status'] == 'Validé') echo 'disabled'; ?> class="form-control" id="comment" rows="5"><?= $reception['comment'] ?></textarea>
                </div>
            </div>
            <div class="" style="position: fixed;right: 0px;bottom: 20px;width: 100px;height: 100px;">
                <button type="button" id="update_comment" class="btn btn-primary material-icons" style="font-size:2.5rem;margin-bottom: 5px">save</button>
                <button type="button" id="validate" class="btn btn-success material-icons" style="font-size:2.5rem;margin-bottom: 5px">done</button>
            </div>
        </div>
    <?php } ?>
</main>
<script>
    $(document).ready(function () {
        getCustomers();
        getReceptions();
    });

    $("#search_customer").keyup(function () {
        getCustomers();
    });

    $('#update_customer').click(function () {
        if ($('#inputIdCustomer').val() !== '') {
            $.ajax({
                url: "lib/ajax.php",
                data: {
                    function: 'updateReceptionCustomer',
                    id_reception: $('#inputIdReception').val(),
                    id_customer: $('#inputIdCustomer').val()
                },
                success: function (result) {
                    location.reload();
                }
            });
        } else {
            alertDO("Veuillez choisir un client");
        }
    });
    $('#validate').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'validateReception',
                id_reception: $('#id_reception').val()
            },
            success: function (result) {
                location.reload();
            }
        });
    });
    $('#update_comment').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'updateReceptionComment',
                id_reception: $('#id_reception').val(),
                comment: $('#comment').val()
            },
            success: function (result) {
                location.reload();
            }
        });
    });

    function getCustomers() {
        $('#customer_table').html('<center><img src="img/loading.gif" style="width:60px"></center>');
        $.ajax({
            url: "views/customerTable.php",
            data: {
                search_customer: $('#search_customer').val()
            },
            success: function (result) {
                $('#customer_table').html(result);
            }
        });
    }

    function getReceptions() {
        $('#receptions').html('<center><img src="img/loading.gif" style="width:60px"></center>');
        $.ajax({
            url: "views/waitingFabformTable.php",
            data: {
                id_reception: $('#id_reception').val()
            },
            success: function (result) {
                $('#receptions').html(result);
            }
        });
    }
</script>

<?php include 'footer.php'; ?>
