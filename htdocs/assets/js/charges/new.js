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

            if (!this.isValid()) {
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
        }
    };

    NewChargePage.init();
}(jQuery));
