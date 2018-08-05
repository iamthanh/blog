<?php

$calender = !empty($m['calender']) ? $m['calender'] : [];
$items    = !empty($m['items']) ? $m['items'] : [];

?>

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