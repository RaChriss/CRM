<?php
$base_url = Flight::get('flight.base_url');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?= $pageTitle ?></title>
  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <script src="<?= $base_url ?>/assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="<?= $base_url ?>/assets/js/plugin/chart.js/chart.min.js"></script>

  <script src="<?= $base_url ?>/assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["<?= $base_url ?>/assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });

    window.baseUrl = "<?= Flight::get('flight.base_url') ?>";
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/bootstrap.min.css" />
  <!-- <link rel="stylesheet" href="<?= $base_url ?>/assets/css/plugins.min.css" /> -->
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/kaiadmin.min.css" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link rel="stylesheet" href="<?= $base_url ?>/assets/css/demo.css" /> -->
</head>

<body>
  <div class="wrapper">
