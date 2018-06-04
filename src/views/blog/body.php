<?php
/**
 * The template for the single blog body
 * @var $m \Entities\Blogs
 */
?>

<?php if (!empty($m)) { ?>
    <div class="main-body-container">
        <div class="blog-body">
            <?= htmlspecialchars_decode($m->getBody()) ?>
        </div>
        <div class="blog-comments"></div>
    </div>
<?php } ?>



