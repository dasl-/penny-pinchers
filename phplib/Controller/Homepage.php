<?

class Controller_Homepage extends Controller_Base {

    protected function handleRequestInternal() {
        // $this->assignJs("charge_id", $this->charge->charge_id);
        // $user = Finder_User::getFinder()->findRecord($this->charge->user_id);
        // $this->assign("user_name", $user->user_name);
        // $this->assign("charge", $this->charge);
        // $this->render("charges/edit");
    }

    protected function getPageTitle() {
        return "#pennies";
    }

}
