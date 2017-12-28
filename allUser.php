<?php 
    require '../models/User.php';
    $tab = User::findAll();
    foreach ($tab as $key)  {
        echo $key->getUsername() . PHP_EOL;
    }

?>