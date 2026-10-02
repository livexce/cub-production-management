<?php

session_start();
$_SESSION["user_name"] = null;
$_SESSION["id_supplier"] = null;
$_SESSION["access"] = null;
$_SESSION["id_customer"] = null;
header('Location: login.php');
exit;