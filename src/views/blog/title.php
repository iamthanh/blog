<?php
/**
 * The template for the single blog title section
 * @var $m \Entities\Blogs
 */
?>
<div class="top-section">
    <div class="main-blog-title" <?= ($m->getHeaderImage()) ? 'has-header-image style="background-image: url(' . $m->getHeaderImage(). ');"' : ''?>>
        <div class="blog-title-container">
            <div class="blog-title">
                <div class="title-detail title-text"><?= $m->getTitle() ?></div>
                <div class="title-detail blog-topic"><a href="<?= Blog\View::BLOGS_PREFIX ?>/<?= $m->getBlogTopic() ?>"><?= $m->getBlogTopic() ?></a></div>
                <div class="title-detail blog-date-created"><?= $m->getDateCreated()->format('F jS, Y') ?></div>
            </div>
        </div>
    </div>
</div>