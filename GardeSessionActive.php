<?php
/**
 * Created by PhpStorm.
 * User: b15015625
 * Date: 16/01/18
 * Time: 11:56
 */

session_start();

  echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']. ' ' .$_SESSION['login']. ' ' .$_SESSION['type'];

?>