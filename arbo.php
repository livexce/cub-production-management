<?php
include 'header.php';

$elements = db::getElements();
$items = db::getItems();
$itemsElements = db::getItemsElements();
?>
<main>
    <h1 class="not-printed">Arborescence</h1>
    <div class="row bg-light rounded-3 mb-3" style="font-size:14px;padding:15px;">
        <div class="row">
            <table class="table table-bordered" style="font-size:0.8rem">
                <thead style="background-color:#F8F9FA;position: sticky;top: 0;">
                    <tr>
                        <td scope="col" >id</td>
                        <td scope="col" >Référence</td>
                        <td scope="col" >Désignation</td>
                        <?php foreach ($elements as $element) { ?>
                            <td scope="col" class="vertical"><?= $element['name'] ?></td>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td scope="col"><?= $item['id_item'] ?></td>
                            <td scope="col"><?= $item['reference'] ?></td>
                            <td scope="col"><?= $item['name'] ?></td>
                            <?php foreach ($elements as $element) { ?>
                                <td scope="col" style="padding:2px"><input type="text" class="form-control" style="height: 30px;font-size: 0.9rem;padding: 0!important;text-align: center!important;" id_item="<?= $item['id_item'] ?>" id_element="<?= $element['id_element'] ?>" value="<?= $itemsElements[$item['id_item'] . "-" . $element['id_element']] ?>"></td>
                                <?php } ?>
                        <tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>

        <script>

            $('.form-control').keyup(function () {
                id_item = $(this).attr('id_item');
                id_element = $(this).attr('id_element');
                value = $(this).val();

                $.ajax({
                    url: "lib/ajax.php",
                    data: {
                        function: 'addItemElement',
                        id_item: id_item,
                        id_element: id_element,
                        value: value
                    },
                    success: function (result) {
                        console.log(result);
                    }
                });

            });

        </script>
</main>
<?php include 'footer.php'; ?>