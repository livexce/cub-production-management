<?php
require_once('../lib/db.php');
$paramPrepas = db::getParamPrepas();
//var_dump($paramPrepas);
//exit;
?>

<table class="table table-hover table-sm">
    <thead>
        <tr>
            <th scope="col">Prepa</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($paramPrepas as $paramPrepa) {
            ?>
            <tr>
                <td><?php echo $paramPrepa['value'] ?></td>
                <td><button data-id="<?php echo $paramPrepa['id_param_prepa'] ?>" class="btn btn-sm btn-danger delete">X</button></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<script>
    $('.delete').click(function () {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'deleteParamPrepa',
                id: $(this).attr('data-id')
            },
            success: function (result) {
                getParamPrepas();
            }
        });
    });
</script>