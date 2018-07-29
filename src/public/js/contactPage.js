(() => {
    class ContactForm {
        constructor() {
            this.formPageContainer = $('.contact-page-container');
            this.form              = $('.form', this.formPageContainer);
            this.successMessage    = $('.sent-success', this.formPageContainer);
            this.inputName         = $('#name', this.form);
            this.inputEmail        = $('#email', this.form);
            this.inputMessage      = $('#message', this.form);
            this.formStatusMessage = $('.form-status-messages', this.form);
        }

        init() {
            this.setupListeners();
        }

        validateForm() {
            return this.inputName.val().length && this.inputEmail.val().length && this.inputMessage.val().length;
        }

        getFormData() {
            return {
                'name': this.inputName.val(),
                'email': this.inputEmail.val(),
                'message': this.inputMessage.val().substr(0, 1000)
            }
        }

        submitForm() {
            let failed =()=>{
                // Failed validation, display message for user
                $('.text-danger', this.formStatusMessage).html('Sorry, there was an error trying to send this message.');
            };

            let success =()=>{
                this.successMessage.show();
            };

            if(this.validateForm()) {
                $.ajax({
                    context: this,
                    method: 'post',
                    url: '/api/contact/submitMessage',
                    data: {
                        formData: this.getFormData(),
                        csrfToken: $('[data-csrf-token]').data('csrfToken')
                    },
                    success: function(resp) {
                        if (resp && resp.status) {
                            // Success
                            $('.text-danger', this.formStatusMessage).html('');
                            $('button[type=submit]', this.form).remove();
                            $(this.form).fadeOut(600, success);
                        } else {
                            failed();
                        }
                    },
                    error: function() {
                        failed();
                    },
                    complete: function() {
                        $('button[type=submit]', this.form).prop('disabled', false);
                    },
                    beforeSend: function() {
                        // Disable the button
                        $('button[type=submit]', this.form).prop('disabled', true);
                    }
                });
            } else {
                failed();
            }
        }

        setupListeners() {
            this.form.submit((e) => {
                e.preventDefault();
                this.submitForm();
            });

            $(this.inputMessage).on('keyup', function() {
                $('.current-message-length span', this.form).text($(this).val().length);
            });
        }
    }

    let cf = new ContactForm();
    cf.init();
})();