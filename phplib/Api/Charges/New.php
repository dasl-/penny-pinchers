<?

class Api_Charges_New extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $amount = Money::fromFloat($this->request->getPost("amount"))->getAmountAsInt();
        $user_id = $this->request->getPost("user_id");
        $description = $this->request->getPost("description");

        $charge = new Model_Charge();
        $charge->user_id = $user_id;
        $charge->amount = $amount;
        $charge->description = $description;
        $charge->charge_date = $this->getChargeDate();
        $charge->store();

        return ['success' => true];
    }

    /**
     * @return int epoch time
     */
    private function getChargeDate() {
        $charge_date = $this->request->getPost("charge_date");
        $valid_charge_dates = ["today", "yesterday"];
        if (!in_array($charge_date, $valid_charge_dates)) {
            $charge_date = "today";
        }

        switch ($charge_date) {
            case 'today':
                // Use the exact time in seconds, because we assume the charge happened "just now".
                $charge_date = strtotime("now");
                break;
            case 'yesterday':
                // Default to "noon yesterday", because we don't make assumptions about what time
                // specifically the charge occurred yesterday.
                $charge_date = strtotime("yesterday noon");
                break;
            default:
                throw new RuntimeException("Invalid charge date");
                break;
        }

        return $charge_date;
    }

}
