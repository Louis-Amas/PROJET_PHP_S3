<?php

/**
 * Created by PhpStorm.
 * User: b15015625
 * Date: 16/01/18
 * Time: 11:56
 */

session_start();


// Creé variable $_SESSION

$_SESSION['type'] = 'NOR';
$_SESSION['login'] = 'JB';
$_SESSION['Nom'] = 'Baptiste';
$_SESSION['Prenom'] = 'Jean';


echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']. ' ' .$_SESSION['login'].' '.$_SESSION['type'];


?>