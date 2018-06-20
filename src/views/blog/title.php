<?php
/**
 * The template for the single blog title section
 * @var $m \Entities\Blogs
 */

$blogTopic = false;
if ($m->getTopics()) {
    $blogTopic = explode(Blog\Blogs::BLOG_TOPICS_DELIMITER, $m->getTopics());
}
?>
<div class="top-section">
    <div class="main-blog-title" <?= ($m->getHeaderImage()) ? 'has-header-image style="background-image: url(' . $m->getHeaderImage(). ');"' : ''?>>
        <div class="blog-title-container">
            <div class="blog-title">
                <div class="title-detail title-text"><?= $m->getTitle() ?></div>
                <?php if (!empty($m)) { ?>
                    <div class="blog-topic-container">
                        <?php foreach($blogTopic as $topic) { ?>
                            <div class="title-detail blog-topic"><a href="<?= Blog\View::BLOGS_PREFIX ?>/<?= $topic ?>"><?= $topic ?></a></div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="title-detail blog-date-created"><?= $m->getDateCreated()->format('F jS, Y') ?></div>
            </div>
        </div>
    </div>
</div>