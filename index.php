<?php
    session_start();
    require 'controllers/UserController.php';
    require 'controllers/PageController.php';
    require 'langs/lang.php';


    require 'views/layouts/header.php'; 
    require 'routes.php';


    require 'views/layouts/footer.php';
    
?>

