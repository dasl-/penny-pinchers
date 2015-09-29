<?

class Api_Charges_Delete extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $charge_id = $this->request->getPost("charge_id");
        Model::getFinder('Charge')->delete($charge_id);

        return ['success' => true];
    }

}
