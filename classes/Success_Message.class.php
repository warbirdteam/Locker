<?php

class Success_Message {

    public function __construct($message,$location) {

      $_SESSION['success'] = $message;
      header("Location: " . $location);
      exit();
    }

}

?>
