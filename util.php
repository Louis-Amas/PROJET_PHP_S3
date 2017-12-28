<?php
function start_page($title)
        {
            echo ' <!DOCTYPE html> <html lang="fr"><head><title>' . PHP_EOL . $title . '</title></head><body>' . PHP_EOL
            ;
        };

function end_page() {
        echo '</body></html>';
    };

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
?>