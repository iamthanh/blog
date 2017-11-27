<?php
/**
 * The template for the single blog body
 * @var $m \Entities\BlogEntry
 */
?>

<?php if (!empty($m)) { ?>
    <div class="main-body-container">
        <div class="header-image">
            <img src="<?= $m->getHeaderImage() ?>">
        </div>
        <div class="body">
            <?= $m->getBody() ?>
        </div>
        <div class="blog-comments"></div>
    </div>
<?php } ?>



