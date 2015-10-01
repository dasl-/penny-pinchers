<?

class Money {

    /** @var int amount in pennies */
    private $int_amount;

    /**
     * @param int $int_amount
     */
    private function __construct($int_amount) {
        $this->int_amount = (int) $int_amount;
    }

    /**
     * Ex:
     *      5.89 -> $5.89
     *      7 -> $7
     *      0.77 -> $0.77
     *
     * @param  float $float_amount
     * @return Money
     */
    public static function fromFloat($float_amount) {
        $float_amount = (float) trim($float_amount);
        $int_amount = (int) round($float_amount * 100, 0);
        return new self($int_amount);
    }

    /**
     * @param  int $int_amount
     * @return Money
     */
    public static function fromInt($int_amount) {
        return new self($int_amount);
    }

    /**
     * @return int
     */
    public function toInt() {
        return $this->int_amount;
    }

    /**
     * @return float
     */
    public function toFloat() {
        $float_amount = round($this->int_amount / 100, 2);
        return $float_amount;
    }

    /**
     * @return string
     */
    public function toString() {
        $float_amount = $this->toFloat();
        return '$' . number_format($float_amount, 2, ".", ",");
    }

}
