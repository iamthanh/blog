<?php // The template for the projects listing section ?>

<pre><?php var_dump($m); ?>

<div class="projects-container">
    <?php if (!empty($m['projects']['items'])) {
        foreach($m['projects']['items'] as $item) { ?>
            <div class="project-item">
                <div class="project-image"><?= $item['thumbnail'] ?></div>
                <div class="project-name"><?= $item['name'] ?></div>
                <div class="project-description"><?= $item['description'] ?></div>
                <div class="project-links">
                    <?php foreach($item['links'] as $link) { ?>
                        <div class="link">
                            <a href="<?= $link['href'] ?>"><?= $link['display-link'] ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    } ?>
</div>
