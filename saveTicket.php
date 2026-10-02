<?php require_once('lib/db.php');

if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();
$userName = isset($_SESSION['cub_user_name']) ? $_SESSION['cub_user_name'] : 'DIGI-ONE';

$idTicket = $_POST['inputTicketId'];
//var_dump($_POST);exit;
if (!$idTicket) {
    $idTicket = db::createTicket($_POST['inputTicketIdFabForm'], $_POST['inputTicketTitle'], $_POST['inputTicketComment'], $_POST['inputTicketReason'], $_POST['inputTicketIdUserCreator']);
  
    $users = explode(",", $_POST['users']);
    foreach ($users as $user)
        if ($user)
            db::createTicketUser($idTicket, $user);
}

if ($_POST['inputTicketResponse']) {
    db::createTicketResponse($idTicket, $_POST['inputTicketResponse']);
}

header('Location: ticket.php?id_ticket=' . $idTicket);
exit;


