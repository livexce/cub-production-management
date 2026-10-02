<?php

function getDateFromWeekAndDay($week, $day) {
    $year = substr($week, 0, 4);
    $week_number = intval(substr($week, 5));

    $jours_semaine = array(
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi'
    );

    if (!in_array($day, $jours_semaine))
        return "Jour invalide";

    $date = new DateTime();
    $date->setISODate($year, $week_number);
    $first_day = clone $date;
    $first_day->modify('this week');
    $day_index = array_search($day, $jours_semaine);
    $first_day->modify("+$day_index days");
    return $first_day->format('Y-m-d');
}

function getInitiales($chaine) {
    $mots = explode(' ', $chaine);
    $initiales = '';
    foreach ($mots as $mot)
        $initiales .= strtoupper($mot[0]);
    return $initiales;
}

function connexion($email, $password) {
    require_once('lib/db.php');
    session_start();

    $user = db::validateUser($email, $password);

    if (isset($user['name'])) {
        $_SESSION["cub_user_name"] = $user['name'];
        return true;
    } else {
        return false;
    }
}

function deconnexion($email, $password) {
    session_start();
    $_SESSION["cub_user_name"] = null;

    header('Location: login.php');
}

function getCurrentWeek() {
    $currentDate = new DateTime();
    $year = $currentDate->format('Y');
    $week = $currentDate->format('W');
    return $year . '-' . $week;
}

function getWeekByDate($date) {
    $d = new DateTime($date);
    while ($d->format('l') != 'Monday')
        $d->sub(new DateInterval('P1D'));
    return $d->format('Y') . '-' . $d->format('W');
}

function getWeeks() {
    $weeks = array();
    $d = new DateTime();

    while ($d->format('l') != 'Monday')
        $d->sub(new DateInterval('P1D'));

    $d->sub(new DateInterval('P56D'));
    for ($i = 0; $i < 52; $i++) {
        $weeks[] = $d->format('Y') . '-' . $d->format('W');
        $d->add(new DateInterval('P7D'));
    }
    return $weeks;
}

function dateFormat($date) {
    $date = new DateTime($date);
    return $date->format('d/m/Y');
}

function dateHourFormat($date) {
    $date = new DateTime($date);
    return $date->format('d/m/Y H:i:s');
}

function getWeeksForCharge() {
    $weeks = array();
    $d = new DateTime();

    while ($d->format('l') != 'Monday')
        $d->sub(new DateInterval('P1D'));

    for ($i = 0; $i < 26; $i++) {
        $weeks[] = $d->format('Y') . '-' . $d->format('W');
        $d->add(new DateInterval('P7D'));
    }
    return $weeks;
}

function getWeeksLarge() {
    $weeks = array();
    $d = new DateTime();

    while ($d->format('l') != 'Monday')
        $d->sub(new DateInterval('P1D'));

    $d->sub(new DateInterval('P140D'));
    for ($i = 0; $i < 52; $i++) {
        $weeks[] = $d->format('Y') . '-' . $d->format('W');
        $d->add(new DateInterval('P7D'));
    }
    return $weeks;
}

function formatShippingDay($shippingDay) {
    $shippingDay = explode('-', $shippingDay);
    return $shippingDay[1];
}

function getShippingDate($semaine, $jourSemaine) {
    if (!$semaine || !$jourSemaine)
        return '';

    list($annee, $numeroSemaine) = explode('-', $semaine);

    $datePremierJour = new DateTime();
    $datePremierJour->setISODate($annee, $numeroSemaine, 1);

    switch (strtolower($jourSemaine)) {
        case 'lundi':
            $jourSemaineNumero = 1;
            break;
        case 'mardi':
            $jourSemaineNumero = 2;
            break;
        case 'mercredi':
            $jourSemaineNumero = 3;
            break;
        case 'jeudi':
            $jourSemaineNumero = 4;
            break;
        case 'vendredi':
            $jourSemaineNumero = 5;
            break;
        case 'samedi':
            $jourSemaineNumero = 6;
            break;
        case 'dimanche':
            $jourSemaineNumero = 7;
            break;
        default:
            return false;
    }

    $datePourJour = clone $datePremierJour;
    $joursAajouter = $jourSemaineNumero - $datePourJour->format('N');
    if ($joursAajouter < 0) {
        $joursAajouter += 7;
    }
    $datePourJour->modify("+$joursAajouter days");

    return $datePourJour;
}
