<?

class Api_Charges_New extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $amount = $this->request->getPost("amount");
        $user_id = $this->request->getPost("user_id");
        $description = $this->request->getPost("description");

        $charge = new Model_Charge();
        $charge->user_id = $user_id;
        $charge->amount = $amount;
        $charge->description = $description;
        $charge->store();

        return ['success' => true];
    }

}
