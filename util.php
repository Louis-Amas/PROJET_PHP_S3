<?php
function start_page($title)
        {
            echo ' <!DOCTYPE html> <html lang="fr"><head><title>' . PHP_EOL . $title . '</title></head><body>' . PHP_EOL
            ;
        };
function load_lang($url) {
    // Lire le fichier json
    $json = file_get_contents($url);

    // Transformer json en Array php
    $json_data = json_decode($json, true);
    
    $array = $json_data['lang'];
    $lang;
    foreach ($array as $value) {
        foreach ($value as $key => $val) {
            $lang[$key] = $val;
        }
    }
    return $lang;
}
function end_page() {
        echo '</body></html>';
    };
function add_success($message) {
        if (!isset($_SESSION['success']) || !is_array($_SESSION['success']) ) {
            $_SESSION['success'] = [];
        } 
        $_SESSION['success'][] = $message;
}
function add_error($message) {
        if (!isset($_SESSION['error']) || !is_array($_SESSION['error']) ) {
            $_SESSION['error'] = [];
        } 
        $_SESSION['error'][] = $message;
    };

function redirect_to($url) {
        header('Location: ' . $url);
    };
function show_error() {
        if ($_SESSION['error']) {
        echo '<ul>';
          foreach ($_SESSION['error'] as $key => $value) {
                echo '<li> ' . $value . '</li>';
        }
        echo '</ul>';
        unset($_SESSION['error']);
      }
    };
function show_success() {
        if ($_SESSION['success']) {
        echo '<ul>';
          foreach ($_SESSION['success'] as $key => $value) {
                echo '<li> ' . $value . '</li>';
        }
        echo '</ul>';
        unset($_SESSION['success']);
      }
    };
?>