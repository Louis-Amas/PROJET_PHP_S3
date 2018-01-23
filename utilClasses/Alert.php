<?php
class Alert{
  private $type;
  private $message;

  public function __construct($type,$message){
    $this->message = $message;
    $this->type = $type;
    if (!isset($_SESSION['alerts'][$type]) || !is_array($_SESSION['alerts'][$type]) ) {
      $_SESSION['alerts'][$type] = [];
    }
    $_SESSION['alerts'][$type] = $message;
  }

  public static function show_alert() {
    if ($_SESSION['alerts']) {
      foreach ($_SESSION['alerts'] as $key => $value) {

        echo '<div class="alert alert-'. $key . '" role="alert">' . print_r($value,true) . '</div>';
      }
      unset($_SESSION['alerts']);
    }
  }
}
