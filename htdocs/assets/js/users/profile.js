(function($) {
    var ProfilePage = {

        $old_password: $('input#old-password'),
        $new_password: $('input#new-password'),
        $password_confirm: $('input#password-confirm'),
        $change_password_submit: $('input#change-password-submit-button'),

        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            this.$change_password_submit.click($.proxy(function(event) {
                this.handleChangePasswordSubmit(event);
            }, this));
        },

        handleChangePasswordSubmit: function(event) {
            event.preventDefault();
            this.$change_password_submit.prop("disabled", true);
            if (!this.isChangePasswordFormValid()) {
                this.$change_password_submit.prop("disabled", false);
                return;
            }

            var data = {
                user_id: global_data.user_id,
                old_password: this.$old_password.val(),
                new_password: this.$new_password.val(),
                update_type: "change_password",
            };
            $.post(
                "/api/v1/users/update",
                data,
                $.proxy(function(response) {
                    this.doChangePasswordSuccess(response);
                }, this),
                "json"
            ).fail($.proxy(function(response) {
                this.doChangePasswordFailure(response);
            }, this)
            ).always($.proxy(function(response) {
                this.$change_password_submit.prop("disabled", false);
            }, this));
        },

        isChangePasswordFormValid: function() {
            var old_password = this.$old_password.val();
            var new_password = this.$new_password.val();
            var password_confirm = this.$password_confirm.val();

            $('.error').hide();

            if (old_password === '') {
                $('.empty-old-password').show();
                return false;
            }

            if (new_password === '') {
                $('.empty-password').show();
                return false;
            }
            if (new_password !== password_confirm) {
                $('.password-match').show();
                return false;
            }

            return true;
        },

        doChangePasswordSuccess: function(response) {
            FlashMessage.showSuccessMessage("change-password-success");
            this.$old_password.val("");
            this.$new_password.val("");
            this.$password_confirm.val("");

            // Refresh the page, where they will now be logged out.
            window.setTimeout(
                $.proxy(function() {
                    document.location.reload(true);
                }, this),
                5000
            );
        },

        doChangePasswordFailure: function(response) {
            if (response.responseJSON.error_message) {
                $(".flash-message-content.failure-empty").text(response.responseJSON.error_message);
                FlashMessage.showFailureMessage("failure-empty");
            } else {
                FlashMessage.showFailureMessage("failure-default");
            }
        }

    };

    ProfilePage.init();
}(jQuery));
