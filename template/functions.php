<?
// Functions here will be available inside all templates.

/**
 * With the default format, it returns something like this: "9/29/15 11:49 pm"
 * @param  string $epoch_date
 * @param  string $format     a date() supported format
 * @return string
 */
function epochToString($epoch_date, $format = "n/j/y g:i a") {
	return date($format, $epoch_date);
}

/**
 * @param  int $int_amount
 * @return string
 */
function formatMoney($int_amount) {
	return Money::fromInt($int_amount)->toString();
}