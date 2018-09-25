<?php // Template for the header ?>
<!doctype html>
<html>
<head>
    <?= \Blog\Meta::createMetaTag(['charset'=>'UTF-8']);?>
    <?= \Blog\Meta::createMetaTag(['name'=>'description', 'content'=>'A blog about the thoughts and projects worked on by Thanh Tran']); ?>
    <?= \Blog\Meta::createMetaTag(['name'=>'keywords',    'content'=>'blog,projects,programming,audio']); ?>
    <?= \Blog\Meta::createMetaTag(['name'=>'author',      'content'=>'Thanh Tran']); ?>
    <?= \Blog\Meta::createMetaTag(['name'=>'viewport',    'content'=>'width=device-width, initial-scale=1.0']); ?>

    <title><?= \Blog\View::$pageTitle ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="/src/public/css/global.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
          integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <?= \Blog\GoogleAnalytics::getGATrackingScript(); ?>
    <?= \Blog\Ads::getAdSenseHeadScript(); ?>
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="/lib/timeago.min.js"></script>
    <script src="/lib/selectize/selectize.min.js"></script>