$(document).ready(function() {
    var admin = {
        ajaxProcessing: false,
        modal: $('.modal#admin-editor-modal'),
        token: $('div[data-token]').data('token'),
        data: null,
        dataType: null,
        dataTypeDisplayName: null,
        objToBeEditOriginal: null,
        init: function() {
            var self = this;

            // First, get the data for the admin
            this.getData(function() {
                self.renderPage(function() {
                    self.setListeners();
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

                    if (response && response.status) {
                        if (response.data.type) self.dataType = response.data.type;
                        if (response.data.type === 'blogs') {
                            self.dataTypeDisplayName = 'Blog';
                        } else if (response.type === 'projects') {
                            self.dataTypeDisplayName = 'Project';
                        }

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
            $('<div>').addClass('short-description').text(data.shortDescription).appendTo(rightContainer);
            $('<div>').addClass('description').text(data.description).appendTo(rightContainer);

            $('<div>').addClass('content-action').append(
                $('<button>').addClass('action btn btn-sm btn-outline-secondary').attr({
                    'type': 'button',
                    'id': 'edit',
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
                if (data.type) {
                    $('.admin-container .content-container .text').text(data.type);
                }

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

                        self.renderModal('edit', obj, function() {
                            self.modal.modal('show');
                        });
                    }
                });
            });

            // Click event for saving changes on the edit modal
            $(self.modal).on('click', 'button[type=submit]', function() {
                if (self.ajaxProcessing) return;

                // Getting the data from the edit modal
                var editModalData = self.getEditModalData();

                if (editModalData) {
                    $.ajax({
                        url: '/api/admin/update',
                        method: 'post',
                        data: {data: editModalData, csrf_token: self.token},
                        beforeSend: function() {
                            $('button[type=submit]', self.modal).text('Saving').attr('disabled','disabled');
                        },
                        success: function(response) {
                            if (response && response.status) {
                                $('.status-container .success', self.modal).text(response.message);

                                // Update the data on the page
                                self.getData(function() {
                                    self.renderPage();
                                });
                            } else {
                                // Request failed
                                $('.status-container .error', self.modal).text(response.message);
                            }
                        },
                        error: function(response) {
                            // Request failed
                            $('.status-container .error', self.modal).text('Failed to update, there was an error.');
                        },
                        complete: function() {
                            self.ajaxProcessing = false;
                            $('button[type=submit]', self.modal).text('Save').removeAttr('disabled');
                        }
                    });
                }
            });

            $(this.getContainer()).on('click', 'button.action#delete', function() {

            });
        },
        renderModal: function (actionType, obj, callback) {
            var self = this;

            // Reset the modal
            self.resetModal();

            // Update the modal title
            if (actionType === 'edit') { $('.modal-title', self.modal).text('Edit ' + self.dataTypeDisplayName); }

            if (obj) {
                // Update the modal with this data
                $('input#title', self.modal).val(obj.title ? obj.title : '');
                $('input#url', self.modal).val(obj.url ? obj.url : '');
                $('input#topic', self.modal).val(obj.blogTopic ? obj.blogTopic : '');
                $('textarea#short-description', self.modal).val(obj.shortDescription ? obj.shortDescription : '');

                // Images and thumbnails
                $('input#thumbnail', self.modal).val(obj.thumbnail ? obj.thumbnail : '');
                $('input#header-image', self.modal).val(obj.bodyHeaderImage ? obj.bodyHeaderImage : '');

                // Setting the post body
                $('textarea#full-body', self.modal).html(String(obj.fullBody));

                // Attach the id of the blog
                $('form', self.modal).attr('data-id', obj.id);
            }

            if (callback) callback();
        },
        resetModal: function() {
            // Reset the status messages
            $('.status-container .status-text', this.modal).text('');
        },
        // Returns the data for the edit modal as an object
        getEditModalData: function() {
            var self = this;
            var obj = {};
            $('input,textarea', self.modal).each(function(i, el) {
                var fieldName = $(el).attr('data-id');
                obj[fieldName] = $(el).val();
            });

            // Attach additional data
            obj['id'] = parseInt($('form', self.modal).attr('data-id'));
            return obj;
        }
    };

    // Start the admin
    admin.init();
});