<?php // The template for the projects listing section ?>

<div class="projects-container">
    <?php if (!empty($m['projects'])) {
        foreach($m['projects'] as $item) { ?>
            <div class="project-item">
                <div class="project-image">
                    <a href="/project/<?= $item['url'] ?>">
                        <img src="<?= empty($item['thumbnail'])?'//via.placeholder.com/250x250' : $item['thumbnail'] ?>">
                    </a>
                </div>
                <div class="project-name"><a href="/project/<?= $item['url'] ?>"><?= $item['title'] ?></a></div>
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
