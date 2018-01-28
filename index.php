<?php
    session_start();
    require 'utilClasses/Util.php';
    require 'utilClasses/Alert.php';
    require 'utilClasses/Email.php';
    require 'MyPdo.php';
    require 'App.php';
    $lang = Util::load_lang('fr.FR');
    //demarage de l'application

    $App = new App();
