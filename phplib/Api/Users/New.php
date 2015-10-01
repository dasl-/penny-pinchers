<?

class Api_Users_New extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $user_name = $this->request->getPost("user_name");

        if (is_numeric($user_name)) {
            $this->response->setStatusCode(Http::STATUS_CODE_BAD_REQUEST);
            return [
                "error_message" => "User name cannot be numeric",
            ];
        }

        $unescaped_user_name = Sanitize::unescape($user_name);
        $banned_chars = Sanitize::$sanitized_chars;
        $banned_chars[] = "%";
        $banned_chars[] = "/";
        foreach ($banned_chars as $char) {
            if (strpos($unescaped_user_name, $char) !== false) {
                $this->response->setStatusCode(Http::STATUS_CODE_BAD_REQUEST);
                return [
                    "error_message" => "User name contains banned characters: " . implode(" ", $banned_chars),
                ];
            }
        }

        $user = Finder_User::getFinder()->findByUserNameOrId($user_name);
        if ($user) {
            $this->response->setStatusCode(Http::STATUS_CODE_BAD_REQUEST);
            return [
                "error_message" => "User $user_name already exists.",
            ];
        }

        $user = new Model_User();
        $user->user_name = $user_name;
        $user->store();

        return [
            "user_name" => $user->user_name,
        ];
    }

}
