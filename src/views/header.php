<?php // Template for the header ?>
<!doctype html>
<html>
<head>
    <?= \Blog\Meta::createMetaTag(['charset'=>'UTF-8']);?>
    <?= \Blog\Meta::createMetaTag(['name'=>'description', 'content'=>'A blog about the thoughts and projects worked on by Thanh Tran']); ?>
    <?= \Blog\Meta::createMetaTag(['name'=>'keywords',    'content'=>'blog,projects,programming,audio']); ?>
    <?= \Blog\Meta::createMetaTag(['name'=>'author',      'content'=>'Thanh Tran']); ?>
    <?= \Blog\Meta::createMetaTag(['name'=>'viewport',    'content'=>'width=device-width, initial-scale=1, shrink-to-fit=no']); ?>

    <title><?= \Blog\View::$pageTitle ?></title>

    <link rel="stylesheet" href="/lib/bootstrap/bootstrap.min.css">

    <link rel="stylesheet" href="/src/public/css/global.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
          integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <?= \Blog\GoogleAnalytics::getGATrackingScript(); ?>
    <?= \Blog\Ads::getAdSenseHeadScript(); ?>
</head>
<body>
    <script src="/lib/jQuery/jquery-3.3.1.min.js"></script>
    <script src="/lib/bootstrap/popper.min.js"></script>
    <script src="/lib/bootstrap/bootstrap.min.js"></script>

    <script src="/lib/timeago.min.js"></script>
    <script src="/lib/selectize/selectize.min.js"></script>