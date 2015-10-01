(function($) {
    var NewChargePage = {

        $amount: $('input#amount'),
        $description: $('input#description'),
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
                user_id: global_data.user_id,
                amount: $.trim(this.$amount.val()),
                description: $.trim(this.$description.val()),
                charge_date: $('input[name=charge-date]:checked', 'form#new-charge').val()
            };
            $.post(
                "/api/v1/charges/new",
                data,
                $.proxy(function(response) {
                    this.doSuccess(response);
                }, this),
                "json"
            ).fail($.proxy(function(response) {
                this.doFailure(response);
            }, this));

            window.setTimeout(
                $.proxy(function() {
                    this.$submit.prop("disabled", false);
                }, this),
                2000
            );
        },

        isValid: function() {
            var amount = $.trim(this.$amount.val())
                description = $.trim(this.$description.val());

            $('.error').hide();

            if (amount === '') {
                $('.empty-amount').show();
                return false;
            }

            if (description === '') {
                $('.empty-description').show();
                return false;
            }

            return true;
        },

        doSuccess: function(response) {
            $(".new-charge-success .success-amount").text(response.amount_string);
            FlashMessage.showSuccessMessage("new-charge-success");
            this.$amount.val("");
            this.$description.val("");
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

    NewChargePage.init();
}(jQuery));
