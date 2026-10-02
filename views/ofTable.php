<?php
include '../lib/db.php';

//echo($_GET['filter_order_date_start']); exit;
$ofs = db::getOfs($_GET['filter_customer_name'],
                $_GET['filter_order_date_start'],
                $_GET['filter_order_date_enlevement'],
                $_GET['filter_order_week_fab'],
                $_GET['filter_cde'],
                $_GET['filter_ref'],
                $_GET['filter_date_commande'],
                $_GET['filter_status']
);
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
                        foreach ($ofs as $of) {
                            ?>
                            <tr>
                                <td><?= $of['num_sage'] ?></td>
                                <td><?= $of['name'] ?></td> 
                                <td><?= $of['reference'] ?></td>
                                <td><?= $of['date_commande'] ?></td>
                                <td><?= $of['shipping_date'] ?></td>
                                <td><?= $of['removal_date'] ?></td>
                                <td><?= $of['sfab'] ?></td> 
                                <td><?= $of['semb'] ?></td> 
                                <td><?= $of['balancelle'] ?></td>
                                <td><?= $of['status'] ?></td>
                                <td style="text-align:right;" class="not-printed">
                                    <a href="./fabForm.php?id_fab_form=<?= $of['id_fab_form'] ?>" class="btn btn-sm btn-primary material-icons" style="font-size:1rem">edit</a>
                                    <a target="_blank" href="./id.php?id_fab_form=<?= $of['id_fab_form'] ?>" class="btn btn-sm btn-secondary material-icons" style="font-size:1rem">article</a>
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



