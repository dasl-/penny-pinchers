(function($) {
    var NewUserPage = {

        $user_name: $('input#user-name'),
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

            if (!this.isValid()) {
                return;
            }

            var data = {
                user_name: $.trim(this.$user_name.val())
            };
            $.post(
                "/api/v1/users/new",
                data,
                $.proxy(function(response) {
                    this.doSuccess(response);
                }, this),
                "json"
            ).fail($.proxy(function(response) {
                this.doFailure(response);
            }, this));
        },

        isValid: function() {
            var user_name = $.trim(this.$user_name.val());

            $('.error').hide();

            if (user_name === '') {
                $('.empty-user-name').show();
                return false;
            }
            if ($.isNumeric(user_name)) {
                $('.numeric-user-name').show();
                return false;
            }

            return true;
        },

        doSuccess: function(response) {
            FlashMessage.showSuccessMessage("user-registration-success");

            // Redirect to user's list of charges page.
            window.setTimeout(
                $.proxy(function() {
                    window.location.href = "/users/" + response.user_name + "/charges";
                }, this),
                5000
            );
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

    NewUserPage.init();
}(jQuery));
