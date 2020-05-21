<?php

class Error_Message {

    public function __construct($message,$location) {


      //Something to write to txt log
      //$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
      //      "Error: ".$message.PHP_EOL.
      //      "-------------------------".PHP_EOL;
      //Save string to log, use FILE_APPEND to append.
      //file_put_contents('../../logs/LOG_POSTER/LOGIN/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

      session_unset();
      $_SESSION['error'] = $message;
      header("Location: " . $location);
      exit();
    }

}

?>
