<?

class Controller_Homepage extends Controller_Base {

    protected function handleRequestInternal() {
        $users = Finder_User::getFinder()->findAll();
        // $this->assignJs("charge_id", $this->charge->charge_id);
        // $user = Finder_User::getFinder()->findRecord($this->charge->user_id);
        // $this->assign("user_name", $user->user_name);
        $this->assign("users", $users);
        $this->render("homepage/homepage");
    }

    protected function getPageTitle() {
        return "#pennies";
    }

}
