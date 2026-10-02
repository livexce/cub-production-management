<?php
require_once('../lib/db.php');
$paramTeintTypes = db::getparamTeintTypes();
?>

<table class="table table-hover table-sm">
    <thead>
        <tr>
            <th scope="col">Teinte</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($paramTeintTypes as $paramTeintType) {
            ?>
            <tr>
                <td><?php echo $paramTeintType['value'] ?></td>
                <td><button data-id="<?php echo $paramTeintType['id_param_teint_type'] ?>" class="btn btn-sm btn-danger delete">X</button></td>
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
                function: 'deleteParamTeintType',
                id: $(this).attr('data-id')
            },
            success: function (result) {
                getParamTeintTypes();
            }
        });
    });
</script>

