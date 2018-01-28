<?php

require 'controllers/UserController.php';
require 'controllers/PageController.php';
require 'controllers/SentenceController.php';
require 'controllers/TranslatorController.php';


function text($text){
  if(empty($lang))
    $lang = Util::load_lang('fr.FR');
  if ($lang[$text]){
    return $lang[$text];
  } else {
    return 'UNKNOWN STRING: '.$text;
  }
}

class App {
    /*
     * Correspond à la base de l'application les routes
     * La method construct va parser l'URL afin d'afficher la bonne vue
     *
    */
    public function __construct() {
        global $lang;
        require 'views/layouts/header.php';
        $url_controller = filter_input(INPUT_GET, 'controller');
        $url_action     = filter_input(INPUT_GET, 'action');
        //verifie si il existe le controller demander
        if (file_exists('controllers/' . ucfirst($url_controller) . 'Controller.php')) {

            $controller =  ucfirst($url_controller) . 'Controller';
            $controller = new $controller();
            //Verifie si il existe la méthode demander du controller

            if (method_exists($controller, $url_action)) {
                $controller->$url_action();
            }
            else {
                $controller->index();
            }
        }
        else {
            $controller = new PageController();

            $controller->home();
        }

         require 'views/layouts/footer.php';
    }
}
