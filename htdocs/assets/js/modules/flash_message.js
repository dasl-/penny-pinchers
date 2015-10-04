var FlashMessage = (function($) {

    var $flash_message_container = $('div#flash-message-container');
    var fade_out_id = null;

    /**
     * @param  string message_class_name Class name of message to display.
     */
    function showSuccessMessage(message_class_name) {
        showMessageCommon(message_class_name, "success");
    }

    /**
     * @param  string message_class_name Class name of message to display.
     */
    function showFailureMessage(message_class_name) {
        showMessageCommon(message_class_name, "failure");
    }

    function showMessageCommon(message_class_name, container_class_name) {
        if (fade_out_id !== null) {
            // There was a previous flash message already in progress. Cancel its fade out.
            window.clearTimeout(fade_out_id);
            $flash_message_container.removeClass(); // Remove all classes.
            $flash_message_container.hide();
        }

        $flash_message_container.addClass(container_class_name);
        var $message = $(".flash-message-content." + message_class_name);
        $flash_message_container.html($message.html());
        $flash_message_container.fadeIn(1000);
        fade_out_id = window.setTimeout(
            function() {
                $.when(
                    $flash_message_container.fadeOut(1000)
                ).done(function() {
                    $flash_message_container.removeClass(container_class_name);
                });
            },
            5000
        );
    }

    return {
        showSuccessMessage: showSuccessMessage,
        showFailureMessage: showFailureMessage
    };

}(jQuery));
