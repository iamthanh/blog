<?php // The template for the main article section ?>

<?php

$blogs = !empty($m['blogs']) ? $m['blogs'] : [];
$calender = !empty($m['sideNav']['calender']) ? $m['sideNav']['calender'] : [];
$items = !empty($m['sideNav']['items']) ? $m['sideNav']['items'] : [];

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
            } else { ?>
                No blogs found
            <?php } ?>
        </div>
    </div>

    <div class="side-nav-container">
        <?php if (!empty($items)) { ?>
            <div class="side-nav">
                <ul class="items-container">
                    <?php foreach($items as $item) { ?>
                        <li class="item">
                            <a href="<?=$item['href']?>"><?=$item['title']?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <?php if (!empty($calender)) { ?>
            <div class="side-nav">
                <ul class="calender-container">
                    <?php foreach($calender as $year=>$monthsData) { ?>
                        <li class="year">
                            <span class="year-text"><?= $year; ?></span>
                            <?php foreach($monthsData as $name=>$blogsCount) {
                                // Getting th link for the month
                                $monthParsed = date_parse($name); ?>
                                <a class='month-link' href="/blogs/date/<?=$year?>/<?= $monthParsed['month'] ?>">
                                    <div class="month">
                                        <span class="month-name"><?= $name; ?></span>
                                    </div>
                                </a>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>




