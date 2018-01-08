<?php
    session_start();
    require 'util.php';
    $lang = load_lang('langs/lang_EN.json');
    require 'App.php';
    //demarage de l'application

    $App = new App();
    

