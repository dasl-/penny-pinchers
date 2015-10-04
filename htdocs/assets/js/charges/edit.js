(function($) {
    var EditChargePage = {

        $delete: $('input#delete-button'),

        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            this.$delete.click($.proxy(function(event) {
                this.handleDelete(event);
            }, this));
        },

        handleDelete: function(event) {
            event.preventDefault();

            var data = {
                user_id: global_data.user_id,
                charge_id: global_data.charge_id
            };
            $.post(
                "/api/v1/charges/" + global_data.charge_id + "/delete",
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
        }

    };

    EditChargePage.init();
}(jQuery));
