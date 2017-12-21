(function() {
    var login = {
        loginAjaxPath: '/api/login',
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
                self.submitLogin(data.username, data.password);
            });
        },
        submitLogin: function(username, password) {
            var self = this;
            if (!username || !password) return false;

            $.ajax({
                url: self.loginAjaxPath,
                type: 'post',
                data: {username: username, password: password},
                success: function(resp) {
                    console.log(resp);
                },
                error: function(resp) {
                    console.log(resp);
                }
            });
        }
    };

    login.init();
})();