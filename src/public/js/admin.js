$(document).ready(function() {
    // Declaring constants
    var ACTION_TYPE_CREATE = 'create';
    var ACTION_TYPE_EDIT = 'edit';

    var admin = {
        ajaxProcessing: false,
        blogAdminModal: $('.modal#admin-editor-modal'),
        deleteBlogModal: $('.modal#delete-blog-modal'),
        csrfToken: $('div[data-csrf-token]').data('csrfToken'),
        data: null,
        objToBeEditOriginal: null,
        objToBeDeleted: null,
        quill: null,
        selectize: null,
        blankBlogPostData: {
            topics: null,
            headerImage: null,
            description: null,
            body: null,
            thumbnail: null,
            title: null,
            url: null
        },
        modalActionType: null,
        init: function() {
            var self = this;

            // First, get the data for the admin
            this.getData(function() {
                self.renderPage(function() {
                    self.setListeners();
                });
            });

            var BackgroundClass = Quill.import('attributors/class/background');
            var ColorClass = Quill.import('attributors/class/color');
            var SizeStyle = Quill.import('attributors/style/size');
            Quill.register(BackgroundClass, true);
            Quill.register(ColorClass, true);
            Quill.register(SizeStyle, true);

            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block', 'image'],

                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction

                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],

                ['clean']                                         // remove formatting button
            ];

            // Init the wysiwyg (Quill)
            self.quill = new Quill('.full-body', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow',
                placeholder: 'This is the body of the post'
            });

            // Start the selectize tagging system
            var selectizeEl = $('.form-control[data-id="topics"]').selectize({
                'delimiter': ';',
                'persist': false,
                'create': function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });
            this.selectize = selectizeEl[0].selectize;
        },
        getContainer: function() {
            return $('.content-container');
        },
        getData: function(callback) {
            var self = this;

            // Call api to get the data
            $.ajax({
                url: '/api/admin/blogs',
                method: 'get',
                data: {csrfToken: self.csrfToken},
                success: function(response) {
                    if (response && response.status) {
                        if (response.data.contentData) self.data = response.data;
                        if (callback) callback(response.data);
                    } else {
                        // Request failed
                    }
                },
                error: function() {

                }
            });
        },
        buildContentTemplate: function(data) {
            var contentContainer = $('<div>').addClass('content').attr('data-id', data.id);
            var rightContainer = $('<div>').addClass('right');

            contentContainer.addClass(data.status === 'active' ? 'published' : 'unpublished');

            timeago().render($('<div>').attr('datetime',data.created.date).addClass('date-created').text(data.created.date).appendTo(rightContainer));
            $('<div>').addClass('title-text').text(data.title).appendTo(rightContainer);
            $('<div>').addClass('topic').text(data.blogTopic).appendTo(rightContainer);
            $('<div>').addClass('description').text(data.description).appendTo(rightContainer);

            $('<div>').addClass('content-action').append(
                $('<button>').addClass('action btn btn-sm btn-outline-secondary').attr({
                    'type': 'button',
                    'id': ACTION_TYPE_EDIT,
                    'data-id': data.id
                }).append(
                    $('<i>').addClass('fas fa-pencil-alt')
                ).append($('<span>').text('Edit'))
            ).append(
                $('<button>').addClass('action btn btn-sm btn-outline-danger').attr({
                    'type': 'button',
                    'id': 'delete',
                    'data-id': data.id
                }).append(
                    $('<i>').addClass('far fa-trash-alt')
                ).append($('<span>').text('Delete'))
            ).appendTo(rightContainer);

            rightContainer.appendTo(contentContainer);
            return contentContainer;
        },
        renderPage: function(callback) {
            var self = this;
            var data = self.data;
            var container = $('.content-list-container', '.admin-container');

            // Empty out the container
            container.html('');

            if (data.contentData && data.contentData.length) {
                for (var i = 0; i < data.contentData.length; i++) {
                    self.buildContentTemplate(data.contentData[i]).appendTo(container);
                }
            } else {
                $('<div>').addClass('empty-content').append(
                    $('<div>').addClass('message').append(
                        $('<h4>No content found.</h4>')
                    )
                ).appendTo(container);
            }

            if (callback) callback();
        },
        setListeners: function() {
            var self = this;

            // Click event for the edit button; before launching the edit modal
            $(this.getContainer()).on('click', 'button.action#edit', function(e) {
                e.preventDefault();
                var dataId = $(this).data('id');

                // Getting the data for this id
                $.each(self.data.contentData, function(i, obj) {
                    if (obj.id === dataId) {

                        // Original data saved and set aside for change detection
                        self.objToBeEditOriginal = obj;

                        self.renderBlogAdminModal(ACTION_TYPE_EDIT, obj, function() {
                            self.modalActionType = ACTION_TYPE_EDIT;
                            self.blogAdminModal.modal('show');
                        });
                    }
                });
            });

            $(this.blogAdminModal).on('click', 'button.only-edit-body', function(e) {
                e.preventDefault();
                self.setFullScreenEditor(!self.blogAdminModal.hasClass('full-screen'));
            });

            $('form', this.blogAdminModal).submit(function(e) {
                e.preventDefault();

                if (self.ajaxProcessing) return;

                // Getting the data from the edit modal
                var editModalData = self.getEditModalData();
                if (self.validateModalForm() && editModalData) {
                    $.ajax({
                        url: '/api/admin/blog',
                        method: 'post',
                        data: {
                            data: editModalData,
                            csrfToken: self.csrfToken,
                            actionType: self.modalActionType
                        },
                        beforeSend: function() {
                            $('.status-container .error', self.blogAdminModal).text('');
                            $('.status-container .success', self.blogAdminModal).text('');
                        },
                        success: function(response) {
                            if (response && response.status) {
                                $('.status-container .success', self.blogAdminModal).text(response.message);

                                // Update the data on the page
                                self.getData(function() {
                                    self.renderPage();
                                    $('button[type=submit]', self.blogAdminModal).text('Save');
                                });
                            } else {
                                // Request failed
                                $('.status-container .error', self.blogAdminModal).text(response.message);
                            }
                        },
                        error: function(response) {
                            // Request failed
                            $('.status-container .error', self.blogAdminModal).text('Failed to update, there was an error.');
                        },
                        complete: function() {
                            self.ajaxProcessing = false;
                        }
                    });
                }
            });

            $(this.getContainer()).on('click', 'button.create-new', function(e) {
                e.preventDefault();
                self.renderBlogAdminModal(ACTION_TYPE_CREATE, self.blankBlogPostData, function() {
                    self.modalActionType = ACTION_TYPE_CREATE;
                    self.blogAdminModal.modal('show');
                });
            });

            /** Listener for the delete button for the blogs; */
            $(this.getContainer()).on('click', 'button.action#delete', function(e) {
                e.preventDefault();
                var dataId = $(this).data('id');

                // Getting the data for this id
                $.each(self.data.contentData, function(i, obj) {
                    if (obj.id === dataId) {

                        // Original data saved and set aside for change detection
                        self.objToBeDeleted = obj;
                        self.renderBlogDeleteModal(obj, function() {
                            self.deleteBlogModal.modal('show');
                        });
                    }
                });
                self.deleteBlogModal.modal('show');
            });

            $(self.deleteBlogModal).on('click', 'button.delete', function(e) {
                e.preventDefault();
                if (!self.objToBeDeleted) return;

                $.ajax({
                    url: '/api/admin/blog',
                    method: 'delete',
                    data: {
                        id: self.objToBeDeleted.id,
                        csrfToken: self.csrfToken
                    },
                    success: function(response) {
                        if (response && response.status) {
                            // Update the data on the page
                            self.getData(function() {
                                self.renderPage();
                                self.deleteBlogModal.modal('hide');
                            });

                        }
                    }
                })
            });
        },
        setFullScreenEditor: function(enable) {
            var self = this;

            if (!enable) {
                self.blogAdminModal.removeClass('full-screen');
                $('.form-top-section', self.blogAdminModal).show();
                $('.only-edit-body', self.blogAdminModal).html('Expand <i class="fas fa-angle-up"></i>');
            } else {
                self.blogAdminModal.addClass('full-screen');
                $('.form-top-section', self.blogAdminModal).hide();
                $('.only-edit-body', self.blogAdminModal).html('Collapse <i class="fas fa-angle-down"></i>');
            }

        },
        validateModalForm: function() {
            let self = this;
            let modalFormInputs = $('.form-control', self.blogAdminModal);

            for(let i = 0; i < modalFormInputs.length; i++) {
                let input = $(modalFormInputs[i]);

                // Check if the input is required
                if (!input.prop('required')) {
                } else {
                    if (!input.val()) {
                        console.error('Data for input: '+input[0].dataset.id+' is missing');
                        $('.status-container .error', self.blogAdminModal).text('Sorry, could not process because there are errors.');
                        return false;
                    }
                }
            }

            // Checking for duplicates in title and url of the blogs
            let editing = !!(self.objToBeEditOriginal && self.objToBeEditOriginal.id);

            let title = $('input#title', self.blogAdminModal).val();
            let url = $('input#url', self.blogAdminModal).val();

            let blogs = self.data.contentData;
            let error = false;

            for(let i = 0; i < blogs.length; i++) {
                if (editing && self.objToBeEditOriginal.id === blogs[i].id) continue;

                if (title === blogs[i].title) {
                    console.error('Error: There is another blog with the same title.');
                    error = true;
                }
                if (url === blogs[i].url) {
                    console.error('Error: There is another blog with the same url.');
                    error = true;
                }
                if (error) {
                    $('.status-container .error', self.blogAdminModal).text('Sorry, could not process because there are errors.');
                    return false;
                }
            }

            return true;
        },
        renderBlogDeleteModal: function(obj, callback) {
            var self = this;

            if (obj) {
                $('.blog-title', self.deleteBlogModal).text(obj.title);
            }

            if (callback) callback();
        },
        renderBlogAdminModal: function (actionType, obj, callback) {
            var self = this;

            // Reset the modal
            self.resetModal();

            // Update the modal title
            if (actionType === ACTION_TYPE_EDIT) {
                $('.modal-title', self.blogAdminModal).text('Edit');
            } else if (actionType === ACTION_TYPE_CREATE) {
                $('.modal-title', self.blogAdminModal).text('Create new post');
            }

            if (obj) {
                // Update the modal with this data
                $('input#title', self.blogAdminModal).val(obj.title ? obj.title : '');
                $('input#url', self.blogAdminModal).val(obj.url ? obj.url : '');
                $('input#topic', self.blogAdminModal).val(obj.blogTopic ? obj.blogTopic : '');

                if (obj.blogTopic) {
                    var topics = obj.blogTopic.split(';');
                    for(var i = 0; i < topics.length; i++) {
                        this.selectize.createItem(topics[i])
                    }
                    this.selectize.refreshItems();
                }
                this.selectize.refreshItems();

                $('textarea#description', self.blogAdminModal).val(obj.description ? obj.description : '');

                // Images and thumbnails
                $('input#thumbnail', self.blogAdminModal).val(obj.thumbnail ? obj.thumbnail : '');
                $('input#header-image', self.blogAdminModal).val(obj.headerImage ? obj.headerImage : '');

                // Setting the correct select option based on blog's status
                $('#published-state option[value="' + obj.status + '"]').prop('selected', true);

                // Setting the post body
                self.quill.root.innerHTML = obj.fullBody ? obj.fullBody : '';

                // Attach the id of the blog
                $('form', self.blogAdminModal).attr('data-id', obj.id);
            }

            if (callback) callback();
        },
        resetModal: function() {
            var self = this;

            // Reset the status messages
            $('.status-container .error', self.blogAdminModal).text('');
            $('.status-container .success', self.blogAdminModal).text('');
            $('button[type=submit]', self.blogAdminModal).text('Save');

            // Destroy all of the items in the selectize
            this.selectize.clear();

            // Reset the full-screen
            self.setFullScreenEditor(false);
        },
        // Returns the data for the edit modal as an object
        getEditModalData: function() {
            var self = this;
            var obj = {};
            $('input,textarea', self.blogAdminModal).each(function(i, el) {
                var fieldName = $(el).attr('data-id');
                if (fieldName) {
                    if ($(el).val()) {
                        obj[fieldName] = $(el).val();
                    } else {
                        obj[fieldName] = '';
                    }
                }
            });

            // Getting the status
            obj['status'] = $('#published-state').val();

            // Get quill text data
            obj['body'] = self.quill.root.innerHTML;

            // Attach additional data
            if ($('form', self.blogAdminModal).attr('data-id')) {
                obj['id'] = parseInt($('form', self.blogAdminModal).attr('data-id'));
            } else {
                obj['id'] = null;
            }

            return obj;
        }
    };

    // Start the admin
    admin.init();
});