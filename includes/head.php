<?php require_once 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $company_name; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- BEGIN FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- END FONTS -->

    <!-- BEGIN PLUGINS -->

    <!-- BEGIN PLUGINS CSS -->
    <link rel="stylesheet" href="/assets/js/Flickity/css/flickity.min.css" media="screen">
    <link rel="stylesheet" href="/assets/js/Flickity/css/flickity-fade.css" media="screen">
    <!-- END PLUGINS CSS -->

    <!-- BEGIN PLUGINS JS -->
    <script src="/assets/js/jquery/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/Flickity/js/flickity.pkgd.min.js"></script>
    <script src="/assets/js/Flickity/js/flickity-fade.js"></script>
    <script src="/assets/js/Flickity/js/flickity-imagesloaded.js"></script>
    <!-- END PLUGINS JS -->

    <!-- END PLUGINS -->

    <script src="/assets/js/main.js" defer></script>
</head>