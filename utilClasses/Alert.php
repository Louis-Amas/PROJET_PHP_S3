<?php
class Alert{
  private $type;
  private $message;

  public function __construct($message,$type='danger'){
    $this->message = $message;
    $this->type = $type;
    if (!isset($_SESSION['alerts'][$type]) || !is_array($_SESSION['alerts'][$type]) ) {
            $_SESSION['alerts'][$type] = [];
        }
    $_SESSION['alerts'][$type] = $message;
  }
  
  public static function show_alerts() {
          if ($_SESSION['alerts']) {
            foreach ($_SESSION['alerts'] as $key => $value) {
                  echo '<div class="alert alert-'. $key . '" role="alert">' . $value . '</div>';
          }
          unset($_SESSION['alerts']);
        }
  }
}
