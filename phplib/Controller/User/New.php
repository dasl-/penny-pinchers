<?

class Controller_User_New extends Controller_Base {

    protected function handleRequestInternal() {
        $this->render("users/new");
    }

    protected function getPageTitle() {
        return "New User";
    }

}
