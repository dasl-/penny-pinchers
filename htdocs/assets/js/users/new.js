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
                function(response) {
                    var success = response.success || false;
                    if (success) {
                        alert("succes!");
                        // $('.default-content').fadeOut(300, function() { $('.success-content').fadeIn(300); });
                    }
                },
                "json"
            )
            .fail(function() {
                // $('.error').hide();
                // $('.unknown-error').show();
                alert("failure.2")
            });
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
        }
    };

    NewUserPage.init();
}(jQuery));
