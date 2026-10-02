<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="DIGI ONE - Yoan Rotru">
        <title>CUB</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    </head>
    <body style="background: none">
        <?php
        require_once('lib/db.php');

        $idFabForm = $_GET['id_fab_form'];
        $fabForm = db::getFabForm($idFabForm);
        $customer = db::getCustomer($fabForm['id_customer']);
        $items = db::getItemsForFabForm($idFabForm);
        $elements = db::getElementsForFabForm($idFabForm);
        $elementsSup = db::getElementsSupForFabForm($idFabForm);
        ?>
        <main>
            <!--<div class="container">-->
            <h1 style="color:black">Dossier n°<?php echo $fabForm['id_fab_form'] ?></h1>
            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <div class="row rounded-3" id="order_list" style="font-size:14px;margin:0 10px">
                    <div class="col-4">
                        <span>Client :&nbsp<br><strong><?php echo $customer['name'] ?></strong></span>
                    </div>
                    <div class="col-4">
                        <span>Date de liv. prév. :&nbsp<br><strong><?php echo $fabForm['shipping_date'] ?></strong></span>
                        <br>
                        <span>Date enlévement :&nbsp<br><strong><?php echo $fabForm['removal_date'] ?></strong></span>
                    </div>
                    <div class="col-4">
                        <span>N° cde Sage :&nbsp<strong><?php echo $fabForm['num_sage'] ?></strong></span>
                        <br>
                        <span>Date commande :&nbsp<strong><?php echo $fabForm['date_commande'] ?></strong></span>
                        <br>
                        <span>Référence :&nbsp<strong><?php echo $fabForm['reference'] ?></strong></span>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <table class="table table-hover table-bordered table-sm" style="border: none!important;">
                    <thead>
                        <tr>
                            <th scope="col">Famille</th>
                            <th scope="col">Référence</th>
                            <th scope="col">Désignation</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Unité</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($items as $item) {
                            ?>
                            <tr>
                                <td><?= $item['family'] ?></td>
                                <td><?= $item['reference'] ?></td>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['sell_unity'] ?></td>
                                <td><?= $item['quantity'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <table id="id_table" style="border: none!important;" class="table table-hover table-bordered table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">CDE</th>
                            <th scope="col">Livraison</th>
                            <th scope="col">Finition</th>
                            <th scope="col">Remarque</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($elements as $element) {
                            ?>
                            <tr class="element_detail" > 
                                <td><?= $element['name'] ?></td>
                                <td style="text-align:center"><?= $element['value'] ?></td>
                                <td style="text-align:center"><?= $element['livr'] ?></td>
                                <td style="text-align:center"><?= $element['finition'] ?></td>
                                <td style="text-align:center"><?= $element['comment'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        foreach ($elementsSup as $element) {
                            ?>
                            <tr class="element_detail" > 
                                <td><?= $element['name'] ?></td>
                                <td style="text-align:center"><?= $element['value'] ?></td>
                                <td style="text-align:center"><?= $element['livr'] ?></td>
                                <td style="text-align:center"><?= $element['finition'] ?></td>
                                <td style="text-align:center"><?= $element['comment'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>

                        <tr style="font-weight:bold;">
                            <td>Total</td>
                            <td id="total" style="text-align:center;">0</td>
                            <td style="border-bottom: none!important;" colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>       
        </div>
        <h1 style="color:black;font-family: 'Libre Barcode 128', sans-serif;font-size:8rem">Dossier <?php echo $fabForm['id_fab_form'] ?></h1>
    </main>
    <script>
        window.print();
    </script>
</body>
</html>