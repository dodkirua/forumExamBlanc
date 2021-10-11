<?php session_start() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <meta name="google" value="notranslate">
        <!--    <script src="https://kit.fontawesome.com/9a391d7800.js" crossorigin="anonymous"></script>
        -->    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/Assets/css/base.css">
        <?php
        $css = $var['css'] ?? 'principal';
        ?>
        <link rel="stylesheet" href="/assets/css/<?= $css ?>.css">
        <link  rel= "shortcut icon"  href= "/Assets/img/standard/favicon.ico"  type= "image/x-icon" >
        <link  rel= "icon"  href= "/Assets/img/standard/favicon.ico"  type= "image/x-icon" >
    </head>
    <body>

    <div id="container">
        <div id="principal"><?php
