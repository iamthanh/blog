<?php // The template for the main article section ?>

This is main article section

<pre>
<?= var_dump($m); ?>
</pre>

<div class="article-container">
    <?php if (!empty($m->sidenav->items)) { ?>
        <div class="article-side-nav-container">
            <ul class="side-nav-items-container">
                <?php foreach($m->sidenav->items as $item) { ?>
                    <li class="side-nav-item">
                        <a href="<?=$item->href?>"><?=$item->title?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <div class="side-calender-container">
        this is side calender
    </div>

    <div class="article-collection">
        this is where all of the articles are displayed
    </div>
</div>
