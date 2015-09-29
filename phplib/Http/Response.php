<?

class Http_Response {

    /**
     * @param int $code
     * @return int|boolean the code that was set, or false if we failed to set it.
     */
    public function setStatusCode($code = Http::STATUS_CODE_OK) {
        header("X-PHP-Response-Code: $code", true, $code);
        if(headers_sent()) {
            return false;
        }
        return $code;
    }

    /**
     * Sets the json response. The script will exit from here.
     * @param array $response an array that will be json encoded
     */
    public function setResponse(array $response = array()) {
        $response = json_encode($response);
        header('Content-Type: application/json');
        echo $response;
        exit;
    }

}
