<?

class Controller_Charge_New extends Controller_Base {

    protected function handleRequestInternal() {
        $this->assignJs("user_id", $this->logged_in_user->user_id);
        $this->assign("is_compact_header", true);
        $this->assign("compact_header_title", "New Charge");
        $this->render("charges/new");
    }

    protected function getPageTitle() {
        return "New Charge";
    }

}
