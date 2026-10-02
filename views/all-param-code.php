<?php
require_once('../lib/db.php');
$paramTeintCodes = db::getParamTeintCodes();
//var_dump($paramTypeCodes);
//exit;
?>

<table class="table table-hover table-sm">
    <thead>
        <tr>
            <th scope="col">Code</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($paramTeintCodes as $paramTeintCode) {
            ?>
            <tr>
                <td><?php echo $paramTeintCode['value'] ?></td>
                <td><button data-id="<?php echo $paramTeintCode['id_param_teint_code'] ?>" class="btn btn-sm btn-danger delete">X</button></td>
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
                function: 'deleteParamTeintCode',
                id: $(this).attr('data-id')
            },
            success: function (result) {
                getParamTeintCodes();
            }
        });
    });
</script>