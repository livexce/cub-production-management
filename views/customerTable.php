<?php
include '../lib/db.php';
$customers = db::getCustomers($_GET['search_customer']);
?>
<div class="row bg-light rounded-3" style="font-size:14px;padding: 0px 15px;">
    <div class="row">
        <div class="col">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>E-mail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($customers as $customer) {
                        ?>
                        <tr class="customer_line">
                            <td class="customer_code"><?= $customer['code'] ?></td> 
                            <td class="customer_name"><?= $customer['name'] ?></td>
                            <td  class="customer_phone"><?= $customer['phone'] ?></td>
                            <td class="customer_email"><?= $customer['email'] ?></td>
                            <td class="customer_id_customer"><?= $customer['id_customer'] ?></td>
                            <td style="text-align:right;" class="not-printed">
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

    $('.customer_line').click(function () {
        $('#inputCustomerName').val($(this).find('.customer_name').html());
        $('#inputCustomerPhone').val($(this).find('.customer_phone').html());
        $('#inputCustomerCode').val($(this).find('.customer_code').html());
        $('#inputCustomerEmail').val($(this).find('.customer_email').html());
        $('#inputIdCustomer').val($(this).find('.customer_id_customer').html());
        
    });
</script>


