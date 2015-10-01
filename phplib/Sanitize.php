<?

class Sanitize {

    public static $sanitized_chars = ['&', '<', '>', "'", '"'];

    /**
     * @param  string $string
     * @return string
     */
    public static function escape($string) {
        if (is_array($string)) {
            $ret_val = array();
            foreach ($string as $key => $value) {
                $key = Sanitize::escape($key);
                $ret_val[$key] = Sanitize::escape($value);
            }
            return $ret_val;
        }

        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        $string = str_replace(
            array('&', '<', '>', "'", '"'),
            array('&amp;', '&lt;', '&gt;', '&#39;', '&quot;'),
            $string
        );
        return $string;
    }

    /**
     * @param  string $string
     * @return string
     */
    public static function unescape($string) {
        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        $string = str_replace(
            array('&lt;', '&gt;', '&#39;', '&quot;', '&amp;'),
            array('<', '>', "'", '"', '&'),
            $string
        );
        return $string;
    }

}
