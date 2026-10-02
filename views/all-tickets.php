<?php
require_once('../lib/db.php');

$tickets = db::getTickets($_GET['all'], $_GET['id_fab_form']);
//var_dump($tickets);exit;
$noSeenTickets = db::getNoSeenTickets();
?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">N° confirmation</th>
            <th scope="col">Client</th>
            <th scope="col">Titre</th>
            <th scope="col">Créé par</th>
            <th scope="col">Destinataires</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($tickets as $ticket) {
            $date = new DateTime($ticket['date_add']);
            $date = $date->format('d/m/Y H:i');
            $class = 'class="table-light"';
            if ($ticket['status'] != 'Ouvert')
                $class = 'class="table-dark"';
            ?>
            <tr <?php echo $class; ?>>
                <td><?php echo $ticket['id_ticket'] ?></td>
                <td><?php echo $date ?></td>
                <td><?php echo $ticket['id_fab_form'] ?></td>
                <td><?php echo strtoupper($ticket['name']) ?></td>
                <td><?php echo $ticket['title'] ?></td>
                <td><?php echo $ticket['name'] ?></td>
                <td><?php echo $ticket['destinataires'] ?></td>
                <td><?php echo $ticket['status'] ?></td>
                <td>
                    <?php if (in_array($ticket['id_ticket'], $noSeenTickets)) { ?>
                        <a href="ticket.php?id_ticket=<?php echo $ticket['id_ticket'] ?>" class="material-icons blink" style="font-size: 30px;text-decoration: none;color: red;">info</a>
                    <?php } ?>
                </td>
                <td><a href="ticket.php?id_ticket=<?php echo $ticket['id_ticket'] ?>" class="btn btn-sm btn-primary">Voir</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
