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
        <div class="content-title">
            <div class="text"></div>
        </div>

        <div class="add-new-content-container">
            <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create new</button>
        </div>
        <div class="content-list-container"></div>
    </div>
</div>

<div class="modal fade" id="admin-editor-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" data-id='title' class="form-control form-control-sm" id="title" placeholder="Title of blog/project">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="url">Url</label>
                                <input type="text" data-id='url' class="form-control form-control-sm" id="url" placeholder="Url for this blog">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="topic">Topic</label>
                                <input type="text" data-id='blogTopic' class="form-control form-control-sm" id="topic" placeholder="Topic">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label>
                                <input type="text" data-id='thumbnail' class="form-control form-control-sm" id="thumbnail" placeholder="Path to thumbnail">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="header-image">Header image</label>
                                <input type="text" data-id='bodyHeaderImage' class="form-control form-control-sm" id="header-image" placeholder="Path to header image">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="short-description">Short Description</label>
                        <textarea class="form-control form-control-sm" data-id='shortDescription' id="short-description" placeholder="Enter a short description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="full-body">Full body</label>
                        <textarea rows="8" class="form-control form-control-sm" data-id='fullBody' id="full-body" placeholder="This is the body of the post"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="status-container">
                    <span class="status-text error text-danger"></span>
                    <span class="status-text success text-success"></span>
                </div>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/src/public/js/admin.js"></script>