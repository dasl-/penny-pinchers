<?

class Controller_Homepage extends Controller_Base {

    protected function handleRequestInternal() {
        $this->assignLeaderboardData();
        $this->assignRecentActivity();

        $thoughts = Finder_Thought::getFinder()->findRecentThoughts();
        $this->assign("thoughts", $thoughts);

        $this->render("homepage/homepage");
    }

    protected function getPageTitle() {
        return "#pennies";
    }

    private function assignLeaderboardData() {
        $users = Finder_User::getFinder()->findAll();
        $total_charges_by_user_id = Finder_Charge::getFinder()->findTotalChargesPerPersonByUserId();
        $this->assign("total_charges_by_user_id", $total_charges_by_user_id);
        $this->assign("users", $users);
    }

    private function assignRecentActivity() {
        $recent_charges = Finder_Charge::getFinder()->findRecentlyAddedCharges();
        $recent_activities = [];
        foreach ($recent_charges as $recent_charge) {
            $recent_activity = [
                "date" => $recent_charge->create_date,
                "user_name" => Finder_User::getFinder()->findRecord($recent_charge->user_id)->user_name,
                "description" => $recent_charge->description,
                "amount" => $recent_charge->amount,
                "charge_id" => $recent_charge->charge_id,
            ];
            $recent_activities[] = $recent_activity;
        }
        $this->assign("recent_activities", $recent_activities);
    }

}
