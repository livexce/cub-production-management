<?php
require_once('lib/tools.php');
$error = 0;

if (isset($_GET['inputEmail'])) {
    if (connexion($_GET['inputEmail'], $_GET['inputPassword'])) {
        
            header('Location: index.php');
            exit;
    } else {
        $error = 1;
    }
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="DIGI ONE - Yoan Rotru">
        <title>CUB</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.tiny.cloud/1/re7av7twj8a013fnvu3k3jiii4t15luifip2kg85p98clu4z/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    </head>
    <body>
        <div class="row bg-light rounded-3 dodiv col-md-3" style="margin: 150px auto;padding:20px;">
            <center><img src="img/logo.png" style="width:300px;padding-bottom:10px"></center>
            <hr>
            <form action="login.php" method="GET">
                <div class="row">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:135px">Email</span>
                        <input type="text" class="form-control" name="inputEmail" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="width:135px">Mot de passe</span>
                        <input type="password" class="form-control" name="inputPassword" value="">
                    </div>
                </div>
                <?php
                if ($error)
                    echo '<center><strong><span style="color:red">Identifiant ou mot de passe incorrect</span></strong></center>';
                ?>
                <center><button type="submit" class="btn btn-primary">Se connecter</button></center>
            </form>
        </div>
    </body>
</html>