<?php // Template for the top navigation ?>

<div class="nav-header">
    <div class="top-nav">
        <div class="nav-item" data-item="photography"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/programming">programming</a></div>
        <div class="nav-item" data-item="web-stuff"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/web">web stuff</a></div>
        <div class="nav-item" data-item="random"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/random">random</a></div>
        <div class="nav-item" data-item="projects"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/projects">projects</a></div>
        <div class="nav-item" data-item="contact"><a href="<?= \Blog\View::CONTACT_ME_PATH ?>">contact</a></div>
        <div class="nav-item" data-item="search"><i class="fas fa-search"></i></div>
        <form class="search-input">
            <div class="form-group">
                <input type="text" class="form-control" id="search" placeholder="Search here ...">
            </div>
        </form>
    </div>
    <div class="mobile-nav-switch"><i class="fas fa-bars"></i></div>
    <div class="mobile-top-nav">
        <div class="nav-item" data-item="photography"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/programming">programming</a></div>
        <div class="nav-item" data-item="web-stuff"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/web">web stuff</a></div>
        <div class="nav-item" data-item="random"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/random">random</a></div>
        <div class="nav-item" data-item="projects"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/projects">projects</a></div>
        <div class="nav-item" data-item="contact"><a href="<?= \Blog\View::CONTACT_ME_PATH ?>">contact</a></div>
    </div>
</div>