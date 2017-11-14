<?php // The template for the main article section ?>

<div class="article-container">
    <div class="side-bar">
        <?php if (!empty($m['side-nav']['items'])) { ?>
            <div class="article-side-nav-container">
                <ul class="side-nav-items-container">
                    <?php foreach($m['side-nav']['items'] as $item) { ?>
                        <li class="side-nav-item">
                            <a href="<?=$item['href']?>"><?=$item['title']?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <?php if (!empty($m['side-nav']['calender'])) { ?>
            <div class="article-side-nav-container">
                <ul class="side-nav-items-container">
                    <?php foreach($m['side-nav']['calender'] as $date) { ?>
                        <li class="side-nav-item">
                            <a href="<?=$date['href']?>"><?=$date['title']?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>

    <div class="blog-collection">
        <?php if (!empty($m['blogs'])) {
            foreach($m['blogs'] as $blog) { ?>
                <div class="single-blog">
                    <div class="blog-title"><?= $blog['title'] ?></div>
                    <div class="blog-topic"><?= $blog['topic'] ?></div>
                    <div class="blog-date-created"><?= $blog['dateCreated']->format('F jS, Y'); ?></div>
                    <div class="blog-body"><?= $blog['body'] ?></div>
                </div>
            <?php }
        } else { ?>
            No blogs found
        <?php } ?>
    </div>
</div>
