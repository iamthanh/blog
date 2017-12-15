<?php // Template for the header ?>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato|Open+Sans|Quicksand:300,400|Raleway" rel="stylesheet">
    <link rel="stylesheet" href="/src/public/css/header.css">
    <link rel="stylesheet" href="/src/public/css/blog.css">
    <link rel="stylesheet" href="/src/public/css/projects.css">
    <link rel="stylesheet" href="/src/public/css/footer.css">
    <script src="https://use.fontawesome.com/ea714fcd83.js"></script>
</head>
<body>

<div class="nav-header">
    <div class="top-image">
        <a href="/"><img src="//via.placeholder.com/180x220"></a>
    </div>
    <div class="top-nav">
        <div class="nav-item" data-item="photography"><a href="/photography">photography</a></div>
        <div class="nav-item" data-item="web-stuff"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/web">web stuff</a></div>
        <div class="nav-item" data-item="random"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/random">random</a></div>
        <div class="nav-item" data-item="projects"><a href="<?= \Blog\View::PROJECTS_PREFIX ?>">projects</a></div>
        <div class="nav-item" data-item="contact"><a href="<?= \Blog\View::CONTACT_ME_PATH ?>">contact</a></div>
    </div>
</div>