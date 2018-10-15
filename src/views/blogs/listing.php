<?php // The template for the main article section

$blogs = !empty($m['blogs']) ? $m['blogs'] : [];

// Just a short message if viewing projects
if (!empty($m['topic']) && $m['topic'] === 'projects') { ?>
    <div class="projects-intro">
        <p class="intro-text">I enjoy building stuff and working on projects, here's some of my work.</p>
    </div>
<?php } ?>

<?php if (!empty($m['query'])) { ?>
    <div class="search-blogs-detail-container">
        <div class="search-results-count">
            <span class="count"><?= $m['resultsFound'] ?></span> results were found for
            <span class="query"><?= $m['query'] ?></span>
        </div>
    </div>
<?php } ?>

<div class="listing-page-container <?= !empty($m['sideNav']) ? 'has-side-nav' : '' ?>">
    <div class="listing-container">
        <div class="blog-collection">
            <?php if (!empty($blogs)) {
                /** @var \Entities\Blogs $blog */
                foreach($blogs as $blog) {

                    $blogTopic = false;
                    if ($blog->getTopics()) {
                        $blogTopic = explode(Blog\Blogs::BLOG_TOPICS_DELIMITER, $blog->getTopics());
                    }

                    $topicIcon = \Blog\Blogs::getBlogTopicIcon($blogTopic);
                    ?>

                    <div class="single-blog">

                        <a href="<?= \Blog\View::BLOG_PREFIX ?>/<?= $blog->getUrl() ?>">
                            <div class="top-section">
                                <div class="icon-container">
                                    <div class="icon-round-border">
                                        <i class="<?=$topicIcon?>"></i>
                                    </div>
                                </div>
                                <div class="title-container">
                                    <div class="blog-date-created"><?= $blog->getDateCreated()->format('F jS, Y') ?></div>
                                    <div class="blog-title">
                                        <span class="title-text"><?= $blog->getTitle() ?></span>
                                    </div>
                                    <div class="blog-description"><?= htmlspecialchars_decode($blog->getDescription()) ?></div>
                                    <?php if (!empty($blogTopic)) { ?>
                                        <div class="topics-container">
                                            <?php foreach($blogTopic as $topic) { ?>
                                                <span class="title-topic"><?= $topic ?></span>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                        <div class="blog-body"><?= htmlspecialchars_decode($blog->getBody()) ?></div>
                    </div>
                    <hr>
                <?php }
            } else {
                echo \Blog\Template::load(\Blog\View::CONTENT_NOT_FOUND);
            } ?>
        </div>
    </div>

    <?php if (!empty($m['sideNav'])) {
        echo \Blog\Template::load(\Blog\View::BLOGS_SIDE_NAV_PATH, $m['sideNav']);
    } ?>
</div>