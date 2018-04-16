<?php
/**
 * The template for the single project title section
 *
 * @var $project \Entities\Projects
 */
$project = $m['project'];
$tags = $m['tags'];
?>

<div class="project-detail-title">
    <div class="project-thumbnail">
        <img src="<?= $project->getThumbnail() ?>">
    </div>
    <div class="project-title">
        <div class="title-text"><?= $project->getTitle() ?></div>
        <div class="title-description"><?= $project->getDescription() ?></div>
    </div>
    <?php if (!empty($tags)) { ?>
        <div class="project-tags">

            <span class="tags-title">Tags:</span>

            <?php
            /** @var $tag \Entities\ProjectTags */
            foreach($tags as $tag) { ?>
                <a class='tag-link'href="<?= Blog\View::PROJECTS_PREFIX ?>/<?= $tag->getTagName() ?>"><?= $tag->getTagName() ?></a>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="project-date-created"><?= $project->getDateCreated()->format('F jS, Y') ?></div>
</div>

<div class="project-body-container">
    <div class="project-body">
        <?= $project->getBody() ?>
    </div>
</div>
