<?

class Api_Users_New extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $user_name = $this->request->getPost("user_name");

        $user = new Model_User();
        $user->user_name = $user_name;
        $user->store();

        return ['success' => true];
    }

}
