<?

class Api_Charges_Delete extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $charge_id = $this->request->getPost("charge_id");
        if ($charge_id == 102) {
        	$this->response->setStatusCode(Http::STATUS_CODE_BAD_REQUEST);
        	return ['error_message' => "Nice try."];
        }
        Finder_Charge::getFinder()->delete($charge_id);

        return ['success' => true];
    }

}
