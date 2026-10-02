<?php
include '../lib/db.php';
$elements = db::getElementsForFabForm($_GET['id']);
$elementsSup = db::getElementsSupForFabForm($_GET['id']);
?>
<div class="row bg-light rounded-3" style="font-size:14px;padding:15px;">
    <div class="row">
        <div class="col">
            <table id="id_table" class="table table-hover table-bordered table-sm">
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
                            <td style="text-align:center"><input class="form-control" type="number" name="elements[<?php echo $element['id_element'] ?>][value]" value="<?= $element['value'] ?>"></td>
                            <td style="text-align:center"><input class="form-control" type="number" name="elements[<?php echo $element['id_element'] ?>][livr]" value="<?php echo $element['livr'] ?>"></td>
                            <td style="text-align:center"><input class="form-control" type="text" name="elements[<?php echo $element['id_element'] ?>][finition]" value="<?php echo $element['finition'] ?>"></td>
                            <td style="text-align:center"><input class="form-control" type="text" name="elements[<?php echo $element['id_element'] ?>][comment]" value="<?php echo $element['comment'] ?>"></td>
                        </tr>
                        <?php
                    }
                    ?>

                    <?php
                    $nbLigne = 1;
                    foreach ($elementsSup as $element) {
                        ?>
                        <tr class="element_detail detail_sup" > 
                            <td style="text-align:center"><input class="form-control" type="text" name="elementsSup[<?= $nbLigne ?>][name]" value="<?= $element['name'] ?>"></td>
                            <td style="text-align:center"><input class="form-control" type="number" name="elementsSup[<?= $nbLigne ?>][value]" value="<?= $element['value'] ?>"></td>
                            <td style="text-align:center"><input class="form-control" type="number" name="elementsSup[<?= $nbLigne ?>][livr]" value="<?php echo $element['livr'] ?>"></td>
                            <td style="text-align:center"><input class="form-control" type="text" name="elementsSup[<?= $nbLigne ?>][finition]" value="<?php echo $element['finition'] ?>"></td>
                            <td style="text-align:center"><input class="form-control" type="text" name="elementsSup[<?= $nbLigne ?>][comment]" value="<?php echo $element['comment'] ?>"></td>
                        </tr>
                        <?php
                        $nbLigne++;
                    }
                    ?>

                    <tr class="element_detail detail_sup" id="pattern" style="display: none;"> 
                        <td style="text-align:center"><input class="form-control sup_name" type="text"></td>
                        <td style="text-align:center"><input class="form-control sup_value element_cde" type="number"></td>
                        <td style="text-align:center"><input class="form-control sup_livr" type="number"></td>
                        <td style="text-align:center"><input class="form-control sup_finition" type="text"></td>
                        <td style="text-align:center"><input class="form-control sup_comment" type="text"></td>
                    </tr>

                    <!-- Ajouter une ligne pour afficher la somme de "CDE" à la fin -->
                    <tr>
                        <td style="font-weight:bold;">Total</td>
                        <td id="total" style="font-weight:bold">0</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('.element_cde').keyup(function () {
        updateTotalCDE();
    });

    $('#add_button').click(function () {

        //Compter le nombre d'élement'
        var nbLignes = $('.detail_sup').length;

        // Clonez l'élément avec l'ID "pattern"
        var clonedRow = $('#pattern').clone();

        // Supprimez l'attribut "id" du clone pour éviter les doublons
        clonedRow.removeAttr('id');
        clonedRow.find('.sup_name').attr('name', 'elementsSup[' + nbLignes + '][name]');
        clonedRow.find('.sup_value').attr('name', 'elementsSup[' + nbLignes + '][value]');
        clonedRow.find('.sup_livr').attr('name', 'elementsSup[' + nbLignes + '][livr]');
        clonedRow.find('.sup_finition').attr('name', 'elementsSup[' + nbLignes + '][finition]');
        clonedRow.find('.sup_comment').attr('name', 'elementsSup[' + nbLignes + '][comment]');
        clonedRow.show();

        // Ajoutez le clone à la table
        $('#id_table tbody tr:last').before(clonedRow);

        // Mettre à jour le total CDE après l'ajout d'une nouvelle ligne
        updateTotalCDE();

        $('.element_cde').keyup(function () {
            updateTotalCDE();
        });
    });

    $(document).ready(function () {
        // Appelez la fonction updateTotalCDE pour calculer le total initial au chargement de la page
        updateTotalCDE();

        // Ajoutez ici d'autres actions ou événements selon vos besoins
    });

    // ... Votre fonction updateTotalCDE

    function updateTotalCDE() {
        var total = 0;

        // Parcourir chaque ligne du tableau avec l'ID "id_table"
        $('.element_detail').each(function () {
            // Récupérer la valeur de la colonne "CDE" (colonne 2)
            var value = parseInt($(this).find('td:eq(1) input').val()) || 0;
//            value += parseInt($(this).find('.element_cde').val()) || 0;
            // Additionner la valeur au total
            total += value;
        });

        // Mettre à jour le texte dans la cellule Total CDE de la dernière ligne
        $('#total').text(total);
    }

</script>




