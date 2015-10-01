var FlashMessage = (function($) {

    var $flash_message_container = $('div#flash-message-container');

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
        $flash_message_container.addClass(container_class_name);
        var $message = $(".flash-message-content." + message_class_name);
        $flash_message_container.html($message.html());
        $flash_message_container.fadeIn(1000);
        window.setTimeout(
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
