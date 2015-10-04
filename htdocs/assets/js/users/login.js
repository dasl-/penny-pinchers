(function($) {
    var Login = {

        $user_name: $('input#user-name'),
        $password: $('input#password'),
        $submit: $('input#submit-button'),

        init: function() {
        	this.bindEvents();
        },

        bindEvents: function() {
            this.$submit.click($.proxy(function(event) {
                this.handleSubmit(event);
            }, this));
        },

        handleSubmit: function(event) {
            event.preventDefault();
            this.$submit.prop("disabled", true);
            if (!this.isValid()) {
                this.$submit.prop("disabled", false);
                return;
            }

            var data = {
                user_name: $.trim(this.$user_name.val()),
                password: this.$password.val()
            };
            $.post(
                "/api/v1/users/login",
                data,
                $.proxy(function(response) {
                    this.doSuccess(response);
                }, this),
                "json"
            ).fail($.proxy(function(response) {
                this.doFailure(response);
            }, this)
            ).always($.proxy(function(response) {
                this.$submit.prop("disabled", false);
            }, this));
        },

        isValid: function() {
            var user_name = $.trim(this.$user_name.val());
            var password = this.$password.val();

            $('.error').hide();

            if (user_name === '') {
                $('.empty-user-name').show();
                return false;
            }
            if (password === '') {
                $('.empty-password').show();
                return false;
            }

            return true;
        },

        doSuccess: function(response) {
            FlashMessage.showSuccessMessage("login-success");
            this.$user_name.val("");
            this.$password.val("");

            document.location.reload(true);
        },

        doFailure: function(response) {
            if (response.responseJSON.error_message) {
                $(".flash-message-content.failure-empty").text(response.responseJSON.error_message);
                FlashMessage.showFailureMessage("failure-empty");
            } else {
                FlashMessage.showFailureMessage("failure-default");
            }
        }

    };

    Login.init();
}(jQuery));
