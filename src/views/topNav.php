<?php // Template for the top navigation ?>

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