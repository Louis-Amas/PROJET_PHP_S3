<?php
    session_start();
    require 'utilClasses/Util.php';
    require 'utilClasses/Alert.php';
    $lang = Util::load_lang('langs/lang_EN.json');
    require 'MyPdo.php';
    require 'App.php';

    //demarage de l'application

    $App = new App();
