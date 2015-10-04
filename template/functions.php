<?
// Functions here will be available inside all templates.

/**
 * With the default format, it returns something like this: "9/29/15 11:49 pm"
 * @param  string $epoch_date
 * @param  string $format     a date() supported format
 * @return string
 */
function formatDate($epoch_date, $format = "n/j/y g:i a") {
    return date($format, $epoch_date);
}

/**
 * @param  int $int_amount
 * @return string
 */
function formatMoney($int_amount) {
    return Money::fromInt($int_amount)->toString();
}

/**
 * @param  int $epoch_date
 * @return string describing how long ago the given date was.
 */
function timeAgo($epoch_date) {
    $now = time();
    $delta = $now - $epoch_date;

    $minutes_ago = floor($delta / 60);
    if ($minutes_ago == 0) {
        return "Just now";
    }
    if ($minutes_ago < 60) {
        return "{$minutes_ago}m";
    }

    $hours_ago = floor($delta / (60 * 60));
    if ($hours_ago < 24) {
        return "{$hours_ago}h";
    }

    $days_ago = floor($delta / (60 * 60 * 24));
    return "{$days_ago}d";
}
