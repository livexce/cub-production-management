<?php
require_once('../lib/db.php');
$paramEmbals = db::getParamEmbals();
//var_dump($paramTypeCodes);
//exit;
?>

<table class="table table-hover table-sm">
    <thead>
        <tr>
            <th scope="col">Emballage</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($paramEmbals as $paramEmbal) {
            ?>
            <tr>
                <td><?php echo $paramEmbal['value'] ?></td>
                <td><button data-id="<?php echo $paramEmbal['id_param_embal'] ?>" class="btn btn-sm btn-danger delete">X</button></td>
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
                function: 'deleteParamEmbal',
                id: $(this).attr('data-id')
            },
            success: function (result) {
                getParamEmbals();
            }
        });
    });
</script>