<?

class String_Util {

    /**
     * Does $haystack start with $needle?
     * @param  string $needle
     * @param  string $haystack
     * @return boolean
     */
    public static function startsWith($needle, $haystack) {
        $needle_length = mb_strlen($needle, "UTF-8");
        $substring = mb_substr($haystack, 0, $needle_length, "UTF-8");
        return $needle === $substring;
    }

}
