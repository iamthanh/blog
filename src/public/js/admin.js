$(document).ready(function() {
    // Declaring constants
    var ACTION_TYPE_CREATE = 'create';
    var ACTION_TYPE_EDIT = 'edit';

    var admin = {
        ajaxProcessing: false,
        modal: $('.modal#admin-editor-modal'),
        token: $('div[data-token]').data('token'),
        data: null,
        objToBeEditOriginal: null,
        blankBlogPostData: {
            blogTopic: null,
            bodyHeader: null,
            description: null,
            fullBody: null,
            description: null,
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

                    var formValid = self.validateModalForm();
                    $('button[type=submit].save-data-button', self.modal).prop('disabled', !formValid);
                });
            });
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
                data: {csrf_token: self.token},
                success: function(response) {

                    console.log(response);

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
            var leftContainer = $('<div>').addClass('left').appendTo(contentContainer);

            $('<img>').attr('src', data.thumbnail ? data.thumbnail : '//via.placeholder.com/300x225').appendTo(
                $('<div>').addClass('thumbnail').appendTo(leftContainer)
            );

            var rightContainer = $('<div>').addClass('right');
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
                    $('<i>').addClass('fa fa-pencil-square-o')
                ).append($('<span>').text('Edit'))
            ).append(
                $('<button>').addClass('action btn btn-sm btn-outline-danger').attr({
                    'type': 'button',
                    'id': 'delete',
                    'data-id': data.id
                }).append(
                    $('<i>').addClass('fa fa-trash-o')
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
            $(this.getContainer()).on('click', 'button.action#edit', function() {
                var dataId = $(this).data('id');

                // Getting the data for this id
                $.each(self.data.contentData, function(i, obj) {
                    if (obj.id === dataId) {

                        // Original data saved and set aside for change detection
                        self.objToBeEditOriginal = obj;

                        self.renderModal(ACTION_TYPE_EDIT, obj, function() {
                            self.modalActionType = ACTION_TYPE_EDIT;
                            self.modal.modal('show');
                        });
                    }
                });
            });

            // Click event for saving changes on the edit/create blog modal
            $(self.modal).on('click', 'button[type=submit].save-data-button', function() {
                if (self.ajaxProcessing) return;

                // Getting the data from the edit modal
                var editModalData = self.getEditModalData();

                if (editModalData) {
                    $.ajax({
                        url: '/api/admin/blog',
                        method: 'post',
                        data: {
                            data: editModalData,
                            csrf_token: self.token,
                            actionType: self.modalActionType
                        },
                        beforeSend: function() {
                            $('.status-container .error', self.modal).text('');
                            $('.status-container .success', self.modal).text('');
                            $('button[type=submit]', self.modal).text('Saving').attr('disabled','disabled');
                        },
                        success: function(response) {
                            if (response && response.status) {
                                $('.status-container .success', self.modal).text(response.message);

                                // Update the data on the page
                                self.getData(function() {
                                    self.renderPage();
                                    self.modal.modal('hide');
                                });
                            } else {
                                // Request failed
                                $('button[type=submit]', self.modal).text('Save').removeAttr('disabled');
                                $('.status-container .error', self.modal).text(response.message);
                            }
                        },
                        error: function(response) {
                            // Request failed
                            $('button[type=submit]', self.modal).text('Save').removeAttr('disabled');
                            $('.status-container .error', self.modal).text('Failed to update, there was an error.');
                        },
                        complete: function() {
                            self.ajaxProcessing = false;
                        }
                    });
                }
            });

            $(this.getContainer()).on('click', 'button.create-new', function() {
                self.renderModal(ACTION_TYPE_CREATE, self.blankBlogPostData, function() {
                    self.modalActionType = ACTION_TYPE_CREATE;
                    self.modal.modal('show');
                });
            });

            $(this.getContainer()).on('click', 'button.action#delete', function() {

            });

            // Listener for detecting changes on input fields on the form
            $(self.modal).on('input', 'form .form-control', function() {
                var formValid = self.validateModalForm();
                $('button[type=submit].save-data-button', self.modal).prop('disabled', !formValid);
            });
        },
        validateModalForm: function() {
            var self = this;
            var modalFormInputs = $('.form-control', self.modal);

            for(var i = 0; i < modalFormInputs.length; i++) {
                var input = $(modalFormInputs[i]);

                // Check if the input is required
                if (!input.prop('required')) {
                } else {
                    if (!input.val()) return false;
                }
            }

            return true;
        },
        renderModal: function (actionType, obj, callback) {
            var self = this;

            // Reset the modal
            self.resetModal();

            // Update the modal title
            if (actionType === ACTION_TYPE_EDIT) {
                $('.modal-title', self.modal).text('Edit');
            } else if (actionType === ACTION_TYPE_CREATE) {
                $('.modal-title', self.modal).text('Create new post');
            }

            if (obj) {
                // Update the modal with this data
                $('input#title', self.modal).val(obj.title ? obj.title : '');
                $('input#url', self.modal).val(obj.url ? obj.url : '');
                $('input#topic', self.modal).val(obj.blogTopic ? obj.blogTopic : '');
                $('textarea#description', self.modal).val(obj.description ? obj.description : '');

                // Images and thumbnails
                $('input#thumbnail', self.modal).val(obj.thumbnail ? obj.thumbnail : '');
                $('input#header-image', self.modal).val(obj.bodyHeaderImage ? obj.bodyHeaderImage : '');

                // Setting the post body
                $('textarea#full-body', self.modal).html(obj.fullBody ? obj.fullBody : '');

                // Attach the id of the blog
                $('form', self.modal).attr('data-id', obj.id);
            }

            if (callback) callback();
        },
        resetModal: function() {
            // Reset the status messages
            $('.status-container .error', self.modal).text('');
            $('.status-container .success', self.modal).text('');
            $('button[type=submit]', self.modal).text('Save');
        },
        // Returns the data for the edit modal as an object
        getEditModalData: function() {
            var self = this;
            var obj = {};
            $('input,textarea', self.modal).each(function(i, el) {
                var fieldName = $(el).attr('data-id');
                if ($(el).val()) {
                    obj[fieldName] = $(el).val();
                } else {
                    obj[fieldName] = '';
                }
            });

            // Attach additional data
            if ($('form', self.modal).attr('data-id')) {
                obj['id'] = parseInt($('form', self.modal).attr('data-id'));
            } else {
                obj['id'] = null;
            }

            return obj;
        }
    };

    // Start the admin
    admin.init();
});