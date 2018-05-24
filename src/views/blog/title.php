<?php
/**
 * The template for the single blog title section
 * @var $m \Entities\Blogs
 */
?>

<div class="main-blog-title">
    <div class="blog-title">
        <div class="title-text"><?= $m->getTitle() ?></div>
    </div>
    <div class="blog-topic"><a href="<?= Blog\View::BLOGS_PREFIX ?>/<?= $m->getBlogTopic() ?>"><?= $m->getBlogTopic() ?></a></div>
    <div class="blog-date-created"><?= $m->getDateCreated()->format('F jS, Y') ?></div>
</div>