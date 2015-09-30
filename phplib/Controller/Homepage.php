<?

class Controller_Homepage extends Controller_Base {

    protected function handleRequestInternal() {
        $users = Finder_User::getFinder()->findAll();
        $total_charges_by_user_id = Finder_Charge::getFinder()->findTotalChargesByUserId();
        $this->assign("total_charges_by_user_id", $total_charges_by_user_id);
        $this->assign("users", $users);
        $this->render("homepage/homepage");
    }

    protected function getPageTitle() {
        return "#pennies";
    }

}
