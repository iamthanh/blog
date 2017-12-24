(function() {
    var login = {
        loginAjaxPath: '/api/login',
        messageContainer: $('.login-container form .message-container'),
        submitButton: $('.login-container form [type=submit]'),
        init: function() {
            // Init the login page

            this.setupSubmitListener();
        },
        setupSubmitListener: function() {
            var self = this;
            $('.login-container form').submit(function(e) {
                e.preventDefault();

                var data = $(this).serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {});
                self.submitLogin(data.username, data.password, $('div[data-token]').data('token'));
            });
        },
        submitLogin: function(username, password, token) {
            var self = this;
            if (!username || !password) return false;

            if (self.submitButton.hasClass('disabled')) return false;
            self.resetMessageContainer();

            self.submitButton.toggleClass('disabled', true).text('Please wait');

            $.ajax({
                url: self.loginAjaxPath,
                type: 'post',
                data: {username: username, password: password, token: token},
                success: function(resp) {
                    if (resp && resp.status) {
                        self.displayMessage('success', 'Log in successful');

                        // Reload the page
                        location.reload();
                    } else {
                        self.displayMessage('error', 'Could not verify user, please try again.');
                        self.submitButton.toggleClass('disabled', false).text('Submit');
                    }
                },
                error: function(resp) {
                    self.displayMessage('error', 'There was an error, please try again later.');
                    self.submitButton.toggleClass('disabled', false).text('Submit');
                }
            });
        },
        resetMessageContainer: function() {
            this.messageContainer.removeClass('error').removeClass('success').text('');
        },
        displayMessage: function(type, message) {
            this.resetMessageContainer();
            this.messageContainer.addClass(type).text(message);
        }
    };

    login.init();
})();