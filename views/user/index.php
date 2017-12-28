<?php
    foreach ($tab as $value) {
        echo '<p>' . $value->getUsername() . '  ' .  $value->getId() . '</p>'; 
    }
?>