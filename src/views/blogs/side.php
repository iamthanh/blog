<?php // This is the template for the side panel ?>

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