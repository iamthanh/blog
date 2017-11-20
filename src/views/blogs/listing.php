<?php // The template for the main article section ?>

<div class="listing-container">
    <div class="blog-collection">
        <?php if (!empty($m['blogs'])) {
            /** @var \Entities\Blogs $blog */
            foreach($m['blogs'] as $blog) { ?>
                <div class="single-blog">
                    <div class="blog-date-created"><?= $blog->getDateCreated()->format('F jS, Y') ?></div>
                    <div class="blog-title">
                        <span class="title-text"><a href="/blog/<?= $blog->getBlogTopic() ?>/<?= $blog->getUrl() ?>"><?= $blog->getTitle() ?></a></span>
                        <span class="title-topic"><a href="<?= $blog->getBlogTopic() ?>"><?= $blog->getBlogTopic() ?></a></span>
                    </div>
                    <div class="blog-body"><?= $blog->getDescription() ?></div>
                    <?php

                    ?>
                </div>
            <?php }
        } else { ?>
            No blogs found
        <?php } ?>
    </div>
</div>
