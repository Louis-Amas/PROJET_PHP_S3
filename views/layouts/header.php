<?error_reporting(0);?>
<!DOCTYPE html>
<html>
<head>
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="theme-color" content="#ffffff">
  <meta charset="utf-8" />
  <title>Traducteur</title>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <?php require 'views/layouts/cssJS.php' ?>
</head>
<body>

  <?php

  require 'views/layouts/nav.php'
  ?>
  <div class="container">
    <?php Alert::show_alert(); ?>
