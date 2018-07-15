<?php // The template for the main article section

$blogs = !empty($m['blogs']) ? $m['blogs'] : [];

?>

<?php
// Just a short message if viewing projects
if (!empty($m['topic']) && $m['topic'] === 'projects') { ?>
    <div class="projects-intro">
        <p class="intro-text">I enjoy building stuff and working on projects, here's some of my work.</p>
    </div>
<?php } ?>

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




