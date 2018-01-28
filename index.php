<?php
    session_start();
    if (empty($_SESSION['LANG'])){
      $_SESSION['LANG'] ='fr.FR';
    }
    require 'utilClasses/Util.php';
    require 'utilClasses/Alert.php';
    require 'utilClasses/Email.php';
    require 'MyPdo.php';
    require 'App.php';
    $lang = Util::load_lang($_SESSION['LANG']);
    //demarage de l'application

    $App = new App();
