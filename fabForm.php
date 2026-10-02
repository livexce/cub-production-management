<?php
include 'header.php';
$paramTeintTypes = db::getParamTeintTypes();
$paramTeintCodes = db::getParamTeintCodes();
$paramTeintText1s = db::getParamTeintText1s();
$paramTeintText2s = db::getParamTeintText2s();
$paramPrepas = db::getParamPrepas();
$paramEmbals = db::getParamEmbals();
$status = db::getStatus();
//$sfabs = db::getSfabs();
//$sembs = db::getSEmbs();
//Récupérer l'id depuis l'URL http://localhost/cub/fabForm.php?id_fab_form=1
$idFabForm = $_GET['id_fab_form'];
if ($idFabForm) {
    $items = db::getItemsForFabForm($idFabForm);
    $fabForm = db::getFabForm($idFabForm);
    $histories = db::getHistories($idFabForm);
}
if ($fabForm['id_customer']) {
    $customer = db::getCustomer($fabForm['id_customer']);
}

$weeks = getWeeks();
?>
<main>
    <form method="post" action="saveFabForm.php" enctype="multipart/form-data" id="orderForm">
        <div class="container">
            <?php if ($idFabForm) { ?>
                <h1>Dossier n°<?php echo $fabForm['id_fab_form'] ?></h1>
            <?php } else { ?>
                <h1>Création d'un nouveau dossier</h1>
            <?php } ?>
            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h2>Client</h2><hr>
                    <div class="col-6">
                        <input type="hidden" class="form-control" name="inputIdFabForm"  id="inputIdFabForm" value="<?php echo $idFabForm ?>">
                        <input type="hidden" class="form-control" name="inputIdCustomer" id="inputIdCustomer" value="<?php echo $customer['id_customer'] ?>">
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
                    </div>
                    <div class="col-6"> 
                        <div class="input-group mb-2">
                            <input type="text" id="search_customer" class="form-control" placeholder="Rechercher">
                        </div>
                        <div id="customer_table" style="height:200px;overflow-y:scroll"></div>
                    </div>
                </div>
            </div>



            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h2>Commande</h2><hr>
                    <div class="col-4">
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Statut</span>
                            <select class="form-select" name="id_status">
                                <option value=""></option>
                                <?php foreach ($status as $status) { ?>
                                    <option value="<?php echo $status['value'] ?>"<?php if ($fabForm['status'] == $status['value']) echo "selected" ?>><?php echo $status['value'] ?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">N° cde Sage</span>
                            <input type="text" class="form-control" id="inputNumSage" name="inputNumSage" value="<?php echo $fabForm['num_sage'] ?>">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Référence</span>
                            <input type="text" class="form-control" id="inputReference" name="inputReference" value="<?php echo $fabForm['reference'] ?>">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Nb de balancelle</span>
                            <input type="number" class="form-control" id="inputBalancelle" name="inputBalancelle" value="<?php echo $fabForm['balancelle'] ?>">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Date commande</span>
                            <input type="date" class="form-control" id="inputOrderDateCommande" name="inputOrderDateCommande" value="<?php echo $fabForm['date_commande'] ?>">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Date de liv. prév.</span>
                            <input type="date" class="form-control" id="inputOrderDateshipping" name="inputOrderDateshipping" value="<?php echo $fabForm['shipping_date'] ?>">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Date enlévement</span>
                            <input type="date" class="form-control" id="inputOrderDateSremoval" name="inputOrderDateSremoval" value="<?php echo $fabForm['removal_date'] ?>">
                        </div>

                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Enlèvement</span>
                            <input type="text" class="form-control" id="inputenlev" name="inputenlev" value="<?php echo $fabForm['retrait'] ?>">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Semaine emb.</span>

                            <select class="form-select" name="inputOrderEmb">
                                <option value=""></option>
                                <?php foreach ($weeks as $week) { ?>
                                    <option value="<?php echo $week ?>" <?php if ($week == $fabForm['semb']) echo 'selected'; ?>><?php echo $week ?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width:150px">Semaine fab.</span>
                            <select class="form-select" name="inputOrderFab">
                                <option value=""></option>
                                <?php foreach ($weeks as $week) { ?>
                                    <option value="<?php echo $week ?>" <?php if ($week == $fabForm['sfab']) echo 'selected'; ?>><?php echo $week ?></option>
                                <?php } ?>
                            </select> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h2>Spécificités</h2><hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width:200px">Teinte EXT</span>
                                <select class="form-select" name="inputTeintTypeExt">
                                    <option value=""></option>
                                    <?php foreach ($paramTeintTypes as $paramTeintType) { ?>
                                        <option value="<?php echo $paramTeintType['value'] ?>" <?php if ($paramTeintType['value'] == $fabForm['teint_ext_type']) echo 'selected' ?>><?php echo $paramTeintType['value'] ?></option>
                                    <?php } ?>
                                </select> 
                                <select class="form-select" name="inputTeintCodeExt">
                                    <option value=""></option>
                                    <?php foreach ($paramTeintCodes as $paramTeintCode) { ?>
                                        <option value="<?php echo $paramTeintCode['value'] ?>"<?php if ($paramTeintCode['value'] == $fabForm['teint_ext_code']) echo 'selected' ?> ><?php echo $paramTeintCode['value'] ?></option>
                                    <?php } ?>
                                </select> 
                                <select class="form-select" name="inputTeintText1Ext">
                                    <option value=""></option>
                                    <?php foreach ($paramTeintText1s as $paramTeintText1) { ?>
                                        <option value="<?php echo $paramTeintText1['value'] ?>"<?php if ($paramTeintText1['value'] == $fabForm['teint_ext_text1']) echo 'selected' ?>><?php echo $paramTeintText1['value'] ?></option>
                                    <?php } ?>
                                </select> 
                                <select class="form-select" name="inputTeintText2Ext">
                                    <option value=""></option>
                                    <?php foreach ($paramTeintText2s as $paramTeintText2) { ?>
                                        <option value="<?php echo $paramTeintText2['value'] ?>"<?php if ($paramTeintText2['value'] == $fabForm['teint_ext_text2']) echo 'selected' ?>><?php echo $paramTeintText2['value'] ?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width:200px">Teinte INT</span>
                                <select class="form-select" name="inputTeintTypeInt">
                                    <option value=""></option>
                                    <?php foreach ($paramTeintTypes as $paramTeintType) { ?>
                                        <option value="<?php echo $paramTeintType['value'] ?>"<?php if ($paramTeintType['value'] == $fabForm['teint_int_type']) echo 'selected' ?>><?php echo $paramTeintType['value'] ?></option>
                                    <?php } ?>
                                </select> 
                                <select class="form-select" name="inputTeintCodeInt">
                                    <option value=""></option>
                                    <?php foreach ($paramTeintCodes as $paramTeintCode) { ?>
                                        <option value="<?php echo $paramTeintCode['value'] ?>"<?php if ($paramTeintCode['value'] == $fabForm['teint_int_code']) echo 'selected' ?>><?php echo $paramTeintCode['value'] ?></option>
                                    <?php } ?>
                                </select>
                                <select class="form-select" name="inputTeintText1Int">
                                    <option value=""></option>
                                    <?php foreach ($paramTeintText1s as $paramTeintText1) { ?>
                                        <option value="<?php echo $paramTeintText1['value'] ?>"<?php if ($paramTeintText1['value'] == $fabForm['teint_int_text1']) echo 'selected' ?>><?php echo $paramTeintText1['value'] ?></option>
                                    <?php } ?>
                                </select> 
                                <select class="form-select" name="inputTeintText2Int">
                                    <option value=""></option>
                                    <?php foreach ($paramTeintText2s as $paramTeintText2) { ?>
                                        <option value="<?php echo $paramTeintText2['value'] ?>"<?php if ($paramTeintText2['value'] == $fabForm['teint_int_text2']) echo 'selected' ?>><?php echo $paramTeintText2['value'] ?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width:200px">Rejointage</span>
                                <select class="form-select" name="inputRejointage">
                                    <option value="Oui" <?php if ($fabForm['rejointage'] == 'Oui') echo "selected" ?>>Oui</option>
                                    <option value="Non" <?php if ($fabForm['rejointage'] == 'Non') echo "selected" ?>>Non</option>
                                </select>
                            </div>     
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width:200px">ANGLES INV</span>
                                <select class="form-select" name="inputAngles">
                                    <option value="Oui" <?php if ($fabForm['angles_inv'] == 'Oui') echo "selected" ?>>Oui</option>
                                    <option value="Non" <?php if ($fabForm['angles_inv'] == 'Non') echo "selected" ?>>Non</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width:200px">Prépa</span>
                                <select class="form-select" name="inputPrepa">
                                    <option value=""></option>
                                    <?php foreach ($paramPrepas as $paramPrepa) { ?>
                                        <option value="<?php echo $paramPrepa['value'] ?>"<?php if ($paramPrepa['value'] == $fabForm['prepa']) echo 'selected' ?>><?php echo $paramPrepa['value'] ?></option>
                                    <?php } ?>
                                </select> 
                                <span class="input-group-text" style="width:200px">Emballage</span>
                                <select class="form-select" name="inputEmbal">
                                    <option value=""></option>
                                    <?php foreach ($paramEmbals as $paramEmbal) { ?>
                                        <option value="<?php echo $paramEmbal['value'] ?>"<?php if ($paramEmbal['value'] == $fabForm['emballage']) echo 'selected' ?>><?php echo $paramEmbal['value'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width:200px">Accesoires</span>
                                <input type="text" class="form-control" id="inputAccessoires" name="inputAccessoires" value="<?php echo $fabForm['accessoires'] ?>">
                                <span class="input-group-text" style="width:200px">Carton</span>
                                <input type="text" class="form-control" id="inputCarton" name="inputCarton" value="<?php echo $fabForm['carton'] ?>">
                                <span class="input-group-text" style="width:200px">Joint</span>
                                <input type="text" class="form-control" id="inputJoint" name="inputJoint" value="<?php echo $fabForm['joint'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width:200px">LS100Alu</span>
                                <input type="text" class="form-control" id="inputLs100Alu" name="inputLs100Alu" value="<?php echo $fabForm['ls_100_alu'] ?>">
                                <span class="input-group-text" style="width:200px">LS107Acier</span>
                                <input type="text" class="form-control" id="inputLs107Acier" name="inputLs107Acier" value="<?php echo $fabForm['ls_107_acier'] ?>">
                                <span class="input-group-text" style="width:200px">Ls105Bois</span>
                                <input type="text" class="form-control" id="inputLs105Bois" name="inputLs105Bois" value="<?php echo $fabForm['ls_105_bois'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width:200px">Remarque</span>
                                <textarea class="form-control" rows="4" name="inputComment"><?php echo $fabForm['comment'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h2>Articles</h2><hr>
                    <table class="table table-hover table-bordered table-sm">
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
            </div>
            <div class="col-lg-12 mx-auto" style="padding-top:10px">
                <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:0 15px">
                    <h2 class="d-flex justify-content-between align-items-center">
                        Eléments 
                        <div class="ml-auto">
                            <button type="button" id="add_button" class="btn btn-primary position-relative" style="margin-right:10px;">+</button>
                            <button type="button" id="generate_button" class="btn btn-danger position-relative">Generer</button>
                        </div>
                    </h2>

                    <hr>
                    <div id="elements_table"></div>           

                </div>
            </div>
            <div class="" style="position: fixed;right: 0px;bottom: 20px;width: 100px;height: 100px;">
                <!--<button type="button" class="btn btn-secondary mb-2 material-icons" style="font-size:2.5rem">download</button>-->
                <button type="submit" id="" class="btn btn-primary material-icons" style="font-size:2.5rem;margin-bottom: 5px">save</button>
                <a target="_blank" href="./id.php?id_fab_form=<?= $fabForm['id_fab_form'] ?>" id="" class="btn btn-secondary material-icons" style="font-size:2.5rem">article</a>
            </div>
            <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:15px">
                <h2>Ticket(s)</h2><hr>
                <div id="tickets"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="input-group mb-2">
                        <a class="btn btn-primary" style="width:100%" href="ticket.php?id_fab_form=<?php echo $idFabForm ?>">Ouvrir un ticket</a>
                    </div>
                </div>
            </div>


            <div class="row bg-light rounded-3" id="order_list" style="font-size:14px;padding:15px;margin:15px">

                <h2>Historique</h2><hr>
                <?php
                foreach ($histories as $date => $historyTab) {
                    $dateAdd = new DateTime($date);
                    $dateAdd = $dateAdd->format('d/m/Y');
                    ?>
                    <h3 style="font-size: 1rem;">Le <?php echo $dateAdd ?></h3>
                    <div class="col-12">
                        <div class="input-group mb-2">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Heure</th>
                                        <th scope="col">Utilisateur</th>
                                        <th scope="col">Champ</th>
                                        <th scope="col">Ancienne valeur</th>
                                        <th scope="col">Nouvelle valeur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historyTab as $history) { ?>
                                        <tr>
                                            <td><?php echo $history['hour_add'] ?></td>
                                            <td><?php echo $history['user_add'] ?></td>
                                            <td><?php echo $history['field'] ?></td>
                                            <td><?php echo $history['old_value'] ?></td>
                                            <td><?php echo $history['new_value'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>

        </div>
    </form>
</main>
<script>
    $(document).ready(function () {
        getCustomers();
    });

    $("#search_customer").keyup(function () {
        getCustomers();
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
//    function generateElementsForFabForm() {
//        $.ajax({
//            url: "lib/ajax.php",
//            data: {
//                function: 'generateElementsForFabForm',
//                id: $('#inputIdFabForm').val()
//            },
//            success: function (result) {
//                console.log(result);
//            }
//        });
//    }
    $(document).ready(function () {
        if ($('#inputIdFabForm').val()) {
            getElementsForFabForm();
        }
    });
    function getElementsForFabForm() {
        $.ajax({
            url: "views/fabformElementTable.php",
            data: {
                id: $('#inputIdFabForm').val()
            },
            success: function (result) {
                $('#elements_table').html(result);
            }
        });

        $('#generate_button').click(function () {
            $.ajax({
                url: "lib/ajax.php",
                data: {
                    function: 'generateElementsForFabForm',
                    id_fab_form: $('#inputIdFabForm').val()
                },
                success: function (result) {
                    location.reload();
                }
            });
        });

        getAllTickets();
        function getAllTickets() {
            $('#tickets').html('<center><img src="img/loading.gif" style="width:60px"></center>');
            $.ajax({
                url: "views/all-tickets.php",
                data: {
                    all: 0,
                    id_fab_form: $('#inputFabFormId').val()
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
    }
</script>

<?php include 'footer.php';
?>
