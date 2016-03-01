(function($) {
    var ListChargesPage = {

        $month_select: $('#month-select'),

        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            this.$month_select.change($.proxy(function(event) {
                this.handleMonthChange(event);
            }, this));
        },

        handleMonthChange: function(event) {
            var month_number = this.$month_select.val();
            var url_without_query_string = window.location.protocol + '//' + window.location.host +
                window.location.pathname;
            window.location.href = url_without_query_string + "?month_number=" + month_number;
        }

    };

    ListChargesPage.init();
}(jQuery));
