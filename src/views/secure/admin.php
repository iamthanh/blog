<?php // Template for the admin ?>

<div class="admin-container">
    <div class="side-nav">
        <ul class="content-edit-list">
            <li>
                <a href="/secure/admin/edit/blogs">Blogs</a>
            </li>
            <li>
                <a href="/secure/admin/edit/projects">Projects</a>
            </li>
        </ul>
        <ul class="account-list">
            <li>
                <a href="/secure/logout">Logout</a>
            </li>
        </ul>
    </div>
    <div class="content-container">
        <?php if ($m) { ?>

            <div class="content-title">
                <div class="text"><?= $m['type'] ?></div>
            </div>

            <div class="add-new-content-container">
                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create new</button>
            </div>

            <div class="content-list-container">

                <?php foreach($m['contentData'] as $data) {
                    continue;


                    if ($m['type'] === \Blog\Admin::EDIT_TYPE_BLOGS) {
                        /** @var $data \Entities\Blogs */
                        ?>
                        <div class="content" data-id="<?= $data->getId() ?>">

                            <div class="left">
                                <div class="thumbnail">
                                    <img src="<?= empty($data->getThumbnail())?'//via.placeholder.com/300x225' : $data->getThumbnail() ?>">
                                </div>
                            </div>
                            <div class="right">
                                <div class="title-text"><?= $data->getTitle() ?></div>
                                <div class="topic"><?= $data->getBlogTopic() ?></div>
                                <div class="short-description"><?= $data->getShortDescription() ?></div>
                                <div class="description"><?= $data->getDescription() ?></div>
                                <div class="date-created">Created: <span class="text"><?= $data->getDateCreated()->format('F jS, Y') ?></span></div>
                                <div class="content-action">
                                    <button type="button" class="action btn btn-sm btn-outline-secondary" id="edit" data-id="<?= $data->getId() ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                    </button>
                                    <button type="button" class="action btn btn-sm btn-outline-danger" id="delete" data-id="<?= $data->getId() ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } else if ($m['type'] === \Blog\Admin::EDIT_TYPE_PROJECTS) { ?>

                    <?php } else { ?>

                    <?php }

                } ?>
            </div>

        <?php } else { ?>
            <div class="invalid-content">
                <div class="message">
                    <h4>Error, content not found.</h4>
                    <h5>Check the url and try again.</h5>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="admin-editor-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-success">Submit</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/src/public/js/admin.js"></script>