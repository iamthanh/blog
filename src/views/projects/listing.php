<?php // The template for the projects listing section ?>

<div class="projects-intro">
    <p class="intro-text">I enjoy building stuff, here's some of my work.</p>
</div>

<div class="projects-container">
    <?php if (!empty($m)) {
        foreach($m as $item) {
            /** @var \Entities\Projects $project */
            $project = $item['project'];
            ?>
            <div class="project-item">
                <div class="project-image">
                    <a href="/project/<?= $project->getUrl() ?>">
                        <img src="<?= empty($project->getThumbnail())?'//via.placeholder.com/300x225' : $project->getThumbnail() ?>">
                    </a>
                </div>

                <div class="project-info">
                    <div class="project-name"><a href="<?= \Blog\View::PROJECT_PREFIX ?>/<?= $project->getUrl() ?>"><?= $project->getTitle() ?></a></div>
                    <div class="project-description"><?= $project->getDescription() ?></div>

                    <?php if (!empty($item['tags'])) { ?>
                        <div class="project-tags">
                            <?php foreach($item['tags'] as $tag) {
                                if ($tag) { ?>
                                    <a class="tag-link" href="<?= \Blog\View::PROJECTS_PREFIX ?>/<?= $tag ?>"><?= $tag ?></a>
                                <?php }
                            } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    } ?>
</div>
