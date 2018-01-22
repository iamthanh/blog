$(document).ready(function() {
    var admin = {
        contentContainer: $('.content-container'),
        modal: $('.modal#admin-editor-modal'),
        token: $('div[data-token]').data('token'),
        init: function() {
            this.getData(function() {
                this.setListeners();
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
                    console.log(response);
                },
                error: function() {

                }
            });
        },
        buildContentTemplate: function(data) {

        },
        populateData: function() {

        },
        setListeners: function() {
            var self = this;

            $(this.contentContainer, 'button.action#edit').on('click', function() {
                var dataId = this.data('id');
                self.loadDataToModal(dataId, function() {

                });
            })
        },
        loadDataToModal: function (id, callback) {

            //


        }
    };

    admin.init();
});