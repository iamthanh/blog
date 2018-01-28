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
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Title of blog/project">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Short Description</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-success">Submit</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/src/public/js/admin.js"></script>