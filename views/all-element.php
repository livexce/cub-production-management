<?php
require_once('../lib/db.php');
$elements = db::getElements();
//var_dump($elements);
//exit;
?>

<table class="table table-hover table-sm">
    <thead>
        <tr>
            <th scope="col">Element</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($elements as $element) {
            ?>
            <tr>
                <td><?php echo $element['name'] ?></td>
                <td><button data-id="<?php echo $element['id_element'] ?>" class="btn btn-sm btn-danger delete">X</button></td>
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
                function: 'deleteElement',
                id: $(this).attr('data-id')
            },
            success: function (result) {
                getElements();
            }
        });
    });
</script>