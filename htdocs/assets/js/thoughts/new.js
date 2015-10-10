(function($) {
    var NewThoughtPage = {

        $title: $('input#title'),
        $text: $('input#text'),
        $submit: $('input#submit-button'),

        init: function() {
            console.log("init");
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
                user_id: global_data.user_id,
                title: $.trim(this.$title.val()),
                text: $.trim(this.$text.val()),
            };

            $.post(
                "/api/v1/thoughts/new",
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
            var title = $.trim(this.$title.val())
                text = $.trim(this.$text.val());

            $('.error').hide();

            if (title === '') {
                $('.empty-title').show();
                return false;
            }

            if (text === '') {
                $('.empty-text').show();
                return false;
            }

            return true;
        },

        doSuccess: function(response) {
            $(".new-success .success-thought").text(response.thought_title);
            FlashMessage.showSuccessMessage("new-success");
            this.$title.val("");
            this.$text.val("");
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

    NewThoughtPage.init();
}(jQuery));
