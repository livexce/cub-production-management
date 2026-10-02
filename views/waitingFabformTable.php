<?php
include '../lib/db.php';

$reception = db::getReception($_GET['id_reception']);

$waitingFabforms = db::getFabFormReceiptWaiting($reception['id_reception']);

//echo '<pre>';
//var_dump($waitingFabforms);
//exit;
?>
<div class="container">
    <div class="col-lg-12 mx-auto bg-light rounded-3" style="font-size:14px;padding:15px;">
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>N°cde</th>
                            <th>Client</th>
                            <th>Référence</th>
                            <th>Date cde</th>
                            <th>Date liv.</th>
                            <th>Date enlév.</th>
                            <th>Semaine fab.</th>
                            <th>Semaine emb.</th>
                            <th>Nb de bal.</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($waitingFabforms as $waitingFabform) {
                            ?>
                            <tr>
                                <td><?= $waitingFabform['num_sage'] ?></td>
                                <td><?= $waitingFabform['name'] ?></td> 
                                <td><?= $waitingFabform['reference'] ?></td>
                                <td><?= $waitingFabform['date_commande'] ?></td>
                                <td><?= $waitingFabform['shipping_date'] ?></td>
                                <td><?= $waitingFabform['removal_date'] ?></td>
                                <td><?= $waitingFabform['sfab'] ?></td> 
                                <td><?= $waitingFabform['semb'] ?></td> 
                                <td><?= $waitingFabform['balancelle'] ?></td>
                                <td><?= $waitingFabform['status'] ?></td>
                                <td style="text-align:right;" class="not-printed">
                                    <?php if ($waitingFabform['status'] == 'En attente de réception' && $reception['reception_status'] != 'Validé') { ?>
                                        <a class="btn btn-sm btn-primary material-icons receipt" id_fab_form="<?= $waitingFabform['id_fab_form'] ?>" style="font-size:1.4rem">login</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('.receipt').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'receiptFabfom',
                id_fab_form: $(this).attr('id_fab_form'),
                id_reception: $('#id_reception').val()
            },
            success: function (result) {
                location.reload();
            }
        });
    });
</script>



