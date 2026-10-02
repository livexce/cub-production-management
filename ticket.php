<?php
include 'header.php';
$idTicket = "";
$idFabForm = $_GET['id_fab_form'];
$ticket = array();
$dateAdd = "";
$user = db::getUserByName($_SESSION['cub_user_name']);

$idUser = $user['id_user'];
$responses = array();
if (isset($_GET['id_ticket'])) {
    $idTicket = $_GET['id_ticket'];
    $ticket = db::getTicket($idTicket);
    $ticketUsers = db::getTicketUsers($idTicket);
    $ticketCreator = db::getTicketCreator($idTicket);
//    var_dump($ticketCreator);exit;
    $dateAdd = new DateTime($ticket['date_add']);
    $dateAdd = $dateAdd->format('d/m/Y H:i:s');
    $idUser = $ticket['id_user'];
    $idFabForm = $ticket['id_fab_form'];
    $fabForm = db::getFabForm($idFabForm);
    $responses = db::getTicketResponses($idTicket);
}
$users = db::getUsers();
db::seeTicket($_GET['id_ticket']);
$motifs = db::getTicketReasons();
?>
<main>
    <div class="container">
        <form action="saveTicket.php" method="post">
            <input type="hidden" class="form-control" name="inputTicketIdFabForm" value="<?php echo $idFabForm; ?>" >
            <input type="hidden" class="form-control" name="inputTicketIdUserCreator" value="<?php echo $idUser; ?>" >
            <?php if ($idTicket == '') { ?>
                <h1>Nouveau ticket</h1>
            <?php } else { ?>
                <h1>Ticket n°<?php echo $idTicket; ?></h1>
            <?php } ?>
            <div class="col-lg-6 mx-auto" style="padding-top:10px">
                <div class="row bg-light rounded-3 dodiv">
                    <?php if ($idTicket) { ?>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="width:155px">Créé le</span>
                                        <input type="text" class="form-control" disabled value="<?php echo $dateAdd ?>" >
                                        <input type="hidden" class="form-control" id="inputTicketId" name="inputTicketId" value="<?php echo $idTicket ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" style="width:155px">Créateur</span>
                                    <input type="text" class="form-control" disabled value="<?php echo $ticketCreator['name']; ?>" >
                                    <input type="hidden" class="form-control" name="inputTicketUserNameCreator" value="<?php echo $_SESSION['cub_user_name']; ?>" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" style="width:155px">Destinataire(s)</span>
                                    <input type="text" class="form-control" disabled value="<?php echo $ticketUsers['users']; ?>" >
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row" <?php if (!$fabForm['id_fab_form']) echo 'style="display:none"'; ?>>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width:155px">N° de Dossier</span>
                                <input type="text" class="form-control" disabled value="<?php echo $fabForm['id_fab_form']; ?>" >
                                <a href="./fabForm.php?id_fab_form=<?php echo $idFabForm; ?>" class="btn btn-primary rounded-3" style="width:52px">Voir</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width:155px">Titre</span>
                                <input type="text" class="form-control" name="inputTicketTitle" <?php if (isset($ticket['id_ticket'])) echo "disabled" ?> value="<?php echo $ticket['title']; ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width:155px">Commentaire</span>
                                <textarea class="form-control" name="inputTicketComment" <?php if (isset($ticket['id_ticket'])) echo "disabled" ?> rows="4"><?php echo $ticket['comment']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width:155px">Motif</span>
                                <select class="form-select" name="inputTicketReason" <?php if (isset($ticket['id_ticket'])) echo "disabled" ?>>
                                    <option value=""></option>
                                    <?php foreach ($motifs as $motif) { ?>
                                        <option value="<?php echo $motif['name'] ?>" <?php if ($ticket['reason_name'] == $motif['name']) echo "selected" ?>><?php echo $motif['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="<?php if (isset($ticket['title'])) echo "display:none" ?>">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width:100%">Destinataire(s)</span>
                                <div  style="width:100%;">
                                    <input type="hidden" id="users" name="users" value="">
                                    <ul class="list-group" style="width:100%">
                                        <?php
                                        foreach ($users as $user) {
                                            if ($_SESSION['user_name'] != $user['name']) {
                                                ?>
                                                <li class="list-group-item">
                                                    <input class="form-check-input me-1 user-checkbox" type="checkbox" value="<?php echo $user['id_user'] ?>">&nbsp<?php echo $user['name'] ?>        
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    foreach ($responses as $response) {
                        $dateAdd = new DateTime($response['date_add']);
                        $dateAdd = $dateAdd->format('d/m/Y H:i:s');
                        ?>
                        <div class="row">
                            <span><strong><?php echo $response['user_name'] . " - " . $dateAdd; ?></strong></span>
                            <p style="font-style: italic;"><?php echo $response['response']; ?></p>
                            <hr>
                        </div>
                    <?php } ?>
                    <?php if ($ticket['status'] != "Fermé") { ?>
                        <div class="row" style="<?php if (!isset($ticket['title'])) echo "display:none" ?>">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" style="width:155px">Réponse</span>
                                    <textarea class="form-control" name="inputTicketResponse" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <button type="submit" class="btn btn-primary" style="width:100%">Enregistrer</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-danger" id="close_ticket" style="width:100%">Fermer le ticket</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        $closeUser = db::getUserById($ticket['id_close_user']);
                        $closeDate = new DateTime($ticket['close_date']);
                        $closeDate = $closeDate->format('d/m/Y H:i:s');
                        echo "<p>Le ticket a été fermé le <strong>" . $closeDate . "</strong> par <strong>" . $closeUser['name'] . "</strong></p>";
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</main>
<br>
<br>
<script>

    $('.form-check-input').change(function () {
        selectedUsers = "";
        $('.form-check-input:checked').each(function () {
            selectedUsers += $(this).val() + ",";
        });
        $('#users').val(selectedUsers);
    });

    $('#close_ticket').click(function () {
        var dialog = confirm("Etes-vous sûr de vouloir fermer ce ticket ?");
        if (dialog) {
            closeTicket();
        }
    });

    function closeTicket() {
        $.ajax({
            url: "lib/ajax.php",
            data: {
                function: 'closeTicket',
                id_ticket: $('#inputTicketId').val()
            },
            success: function (result) {
                location.reload();
                return false;
            },
            error: function (result) {
                console.log(result);
                return false;
            }
        });
    }

</script>
<?php include 'footer.php' ?>
