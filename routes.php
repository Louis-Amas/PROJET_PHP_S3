<?php

    $controller = filter_input(INPUT_GET, 'controller');
    $action     = filter_input(INPUT_GET, 'action');
    $page = NULL;
    

    switch ($controller) {
        case "pages":
            $page = new PageController();
            $pages->home();
            break;

        case "user":
            $page = new UserController();
            if ($action == 'loginPage') {
                $page->loginPage();
            }
            if ($action == 'login') {
                $page->login();
            }
            break;
            
        default:
            $page = new PageController();
            break;
        
    }

    switch ($action) {

        case 'index':
            $page->index();
            break;
        case 'new':
            $page->new();
            break;
                    
        case 'create':
            $page->create();
            break;

        case 'show':
            $page->show();
            break;

        case 'destroy':
            $page->destroy();
            break;

        case 'update':
            $page->update();
            break;
        case 'edit':
            $page->edit();
            break;

        default: 
            $page->index();
        }
?>