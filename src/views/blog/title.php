<?php
/**
 * The template for the single blog title section
 * @var $m \Entities\Blogs
 */
?>

<div class="main-blog-title">
    <div class="blog-title">
        <div class="title-text"><?= $m->getTitle() ?></div>
        <div class="title-short-description"><?= $m->getShortDescription() ?></div>
    </div>
    <div class="blog-topic"><a href="/blog/<?= $m->getBlogTopic() ?>"><?= $m->getBlogTopic() ?></a></div>
    <div class="blog-date-created"><?= $m->getDateCreated()->format('F jS, Y') ?></div>
</div>