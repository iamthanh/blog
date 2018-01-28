$(document).ready(function() {
    var admin = {
        contentContainer: $('.content-container'),
        modal: $('.modal#admin-editor-modal'),
        token: $('div[data-token]').data('token'),
        contentData: null,
        init: function() {
            var self = this;

            // First, get the data for the admin
            this.getData(function() {
                self.renderPage(function() {
                    self.setListeners();
                });
            });
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
                        if (response.data.contentData) self.contentData = response.data;
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
            var data = self.contentData;
            var container = $('.content-list-container', '.admin-container');

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

            $('button.action#edit', this.contentContainer).on('click', function() {
                var dataId = $(this).data('id');
                self.renderModal(dataId, function() {
                    self.modal.modal('show');
                });
            })
        },
        renderModal: function (id, callback) {


            if (callback) callback();
        }

    };

    // Start the admin
    admin.init();
});