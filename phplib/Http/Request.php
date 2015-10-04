<?

class Http_Request {

    /**
     * Gets the escaped POST data
     * @param  $name
     * @return string|array
     */
    public function getPost($name) {
        return Sanitize::escape($this->getPostRaw($name));
    }

    /**
     * Gets the unescaped POST data
     * @param  $name
     * @return string|array
     */
    public function getPostRaw($name) {
        $result = null;
        if (isset($_POST[$name])) {
            $result = $_POST[$name];
        }
        return $result;
    }

    /**
     * Gets the escaped GET data
     * @param  $name
     * @return string|array
     */
    public function getGet($name) {
        return Sanitize::escape($this->getGetRaw($name));
    }

    /**
     * Gets the unescaped GET data
     * @param  $name
     * @return string|array
     */
    public function getGetRaw($name) {
        $result = null;
        if (isset($_GET[$name])) {
            $result = $_GET[$name];
        }
        return $result;
    }

}