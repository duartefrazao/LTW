<?php
  error_reporting(E_ALL);
  ini_set('display_errors', "true");
  ini_set('log_errors', "true");

  session_start();

  function generate_random_token() {
    return bin2hex(openssl_random_pseudo_bytes(32));
  }

  if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
  }

?>