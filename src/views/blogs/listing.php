<?php // The template for the main article section

$blogs = !empty($m['blogs']) ? $m['blogs'] : [];

?>

<div class="listing-page-container">
    <div class="listing-container">
        <div class="blog-collection">
            <?php if (!empty($blogs)) {
                /** @var \Entities\Blogs $blog */
                foreach($blogs as $blog) {

                    $blogTopic = false;
                    if ($blog->getTopics()) {
                        $blogTopic = explode(Blog\Blogs::BLOG_TOPICS_DELIMITER, $blog->getTopics());
                    }  ?>

                    <div class="single-blog">
                        <div class="blog-date-created"><?= $blog->getDateCreated()->format('F jS, Y') ?></div>
                        <div class="blog-title">
                            <span class="title-text"><a href="<?= \Blog\View::BLOG_PREFIX ?>/<?= $blog->getUrl() ?>"><?= $blog->getTitle() ?></a></span>

                            <?php if (!empty($blogTopic)) { ?>
                                <div class="topics-container">
                                    <?php foreach($blogTopic as $topic) { ?>
                                        <span class="title-topic"><a href="<?= \Blog\View::BLOGS_PREFIX ?>/<?= $topic ?>"><?= $topic ?></a></span>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="blog-body"><?= htmlspecialchars_decode($blog->getBody()) ?></div>
                    </div>
                    <hr>
                <?php }
            } ?>
        </div>
    </div>
</div>




