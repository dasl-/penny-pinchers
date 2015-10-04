<?

class Api_Users_Update extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $update_type = $this->request->getPost("update_type");
        switch ($update_type) {
            case 'change_password':
                return $this->handleChangePassword();
                break;
            default:
                throw new RuntimeException("Unexpected update_type");
        }
    }

    private function handleChangePassword() {
        $user_id = $this->request->getPost("user_id");
        $old_password = $this->request->getPost("old_password");
        $new_password = $this->request->getPost("new_password");

        if ($new_password === "") {
            $this->response->setStatusCode(Http::STATUS_CODE_BAD_REQUEST);
            return [
                "error_message" => "Password cannot be empty.",
            ];
        }

        $user = Finder_User::getFinder()->findRecord($user_id);
        if (!password_verify($old_password, $user->password_hash)) {
            $this->response->setStatusCode(Http::STATUS_CODE_UNAUTHORIZED);
            return [
                "error_message" => "Old password was incorrect.",
            ];
        }

        $user->password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $user->store();

        Authorizer::logout();

        return [
            "user_id" => $user->user_id,
        ];
    }

}
