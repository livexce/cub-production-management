<?php
include 'header.php';

$receptions = db::getReceptions();
?>
<main>
    <div class="container">
        <h1>Historique accueil client</h1>
        <div class="col-lg-12 mx-auto" style="padding-top:10px">
            <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Réception</th>
                            <th>Livraison</th>
                            <th>Commentaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($receptions as $reception) {
                            ?>
                            <tr>
                                <td><?= $reception['id_reception'] ?></td> 
                                <td><a href="./reception.php?id_reception=<?= $reception['id_reception'] ?>"><?= $reception['name'] ?></a></td>
                                <td><?= $reception['date_reception'] ?></td> 
                                <td><?= $reception['nb_receipt'] ?></td> 
                                <td></td> 
                                <td><?= $reception['comment'] ?></td> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script>

</script>

<?php include 'footer.php'; ?>
