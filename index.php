<?php
include 'header.php';
$status = db::getStatus();
$status = db::getStatus();
?>
<main>
    <h1 class="not-printed">Planning de production</h1>
    <div class="container">
        <div class="col-12 mx-auto bg-light rounded-3 mb-3" style="font-size:14px;padding:15px;">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:190px">Client</span>
                        <input type="text" class="form-control" id="filter_customer_name" value="<?php if (isset($_SESSION['filter_customer_name'])) echo $_SESSION['filter_customer_name']; ?>">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:190px">N° Cde</span>
                        <input type="text" class="form-control" id="filter_cde" value="<?php if (isset($_SESSION['filter_cde'])) echo $_SESSION['filter_cde']; ?>">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:190px">Réf. Client</span>
                        <input type="text" class="form-control" id="filter_ref" value="<?php if (isset($_SESSION['filter_ref'])) echo $_SESSION['filter_ref']; ?>"
                               </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:165px">Statut</span>
                        <select class="form-select" id="filter_status">
                            <option <?php if (!isset($_SESSION['filter_status'])) echo 'selected'; ?>></option>
                            <?php
                            foreach ($status as $status)
                                if (isset($_SESSION['filter_status']) && $_SESSION['filter_status'] == $status['value'])
                                    echo '<option value="' . $status['value'] . '" selected>' . $status['value'] . '</option>';
                                else
                                    echo '<option value="' . $status['value'] . '">' . $status['value'] . '</option>';
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:190px">Date de liv. prév.</span>
                        <input type="date" class="form-control" id="filter_order_date_start" 
                               value="<?php if (isset($_SESSION['filter_order_date_start'])) echo $_SESSION['filter_order_date_start']; ?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:190px">Date d'enlévement</span>
                        <input type="date" class="form-control" id="filter_order_date_enlevement" 
                               value="<?php if (isset($_SESSION['filter_order_date_enlevement'])) echo $_SESSION['filter_order_date_enlevement']; ?>">
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:190px">Date de commande</span>
                        <input type="date" class="form-control" id="filter_date_commande"
                               value="<?php if (isset($_SESSION['filter_date_commande'])) echo $_SESSION['filter_date_commande']; ?>"
                               </div>
                    </div>
                    <div class="input-group md-3">
                        <span class="input-group-text" style="width:190px">Semaine fab.</span>
                        <input type="date" class="form-control" id="filter_order_week_fab" 
                               value="<?php if (isset($_SESSION['filter_order_week_fab'])) echo $_SESSION['filter_order_week_fab']; ?>">
                    </div>
                </div>
            </div>
            <div class="row md-3">
                <center>
                    <input type="button" id="search_button" class="btn btn-primary" value="Rechercher">
                    <input type="button" id="init_button" class="btn btn-secondary" value="Réinitialiser">
                </center>
            </div>
        </div>
    </div>
</div>

<div  id="of_table"></div>
<script>
    $(document).ready(function () {
        getOfs();
    });
    $('#search_button').click(function () {
        getOfs();
    });
    $('#init_button').click(function () {
        $('#filter_customer_name').val("");
        $('#filter_cde').val("");
        $('#filter_ref').val("");
        $('#filter_order_date_start').val("");
        $('#filter_order_date_enlevement').val("");
        $('#filter_order_week_fab').val("");
        $('#filter_date_commande').val("");
        $('#filter_status').val("");
        getOfs();
    });

    function getOfs() {
//        alert($('#filter_order_date_start').val());
        $('#of_table').html('<center><img src="img/loading.gif" style="width:60px"></center>');
        $.ajax({
            url: "views/ofTable.php",
            data: {
                filter_customer_name: $('#filter_customer_name').val(),
                filter_order_date_start: $('#filter_order_date_start').val(),
                filter_order_date_enlevement: $('#filter_order_date_enlevement').val(),
                filter_order_week_fab: $('#filter_order_week_fab').val(),
                filter_cde: $('#filter_cde').val(),
                filter_ref: $('#filter_ref').val(),
                filter_date_commande: $('#filter_date_commande').val(),
                filter_status: $('#filter_status').val()
            },
            success: function (result) {
                $('#of_table').html(result);
            }
        });
    }
</script>
</main>
<?php include 'footer.php';
?>