<?

class Http_Request {

    /**
     * Gets the escaped POST data
     * @param  $name
     * @return string|array
     */
    public function getPost($name) {
        $result = null;
        if (isset($_POST[$name])) {
            $result = $_POST[$name];
        }

        $result = Sanitize::escape($result);
        return $result;
    }

    /**
     * Gets the escaped GET data
     * @param  $name
     * @return string|array
     */
    public function getGet($name) {
        $result = null;
        if (isset($_GET[$name])) {
            $result = $_GET[$name];
        }

        $result = Sanitize::escape($result);
        return $result;
    }

}