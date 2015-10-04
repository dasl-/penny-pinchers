<?

class Controller_User_Logout extends Controller_Base {

    protected function handleRequestInternal() {
        Authorizer::logout();
        $this->assign("is_authenticated", false);
        $this->render("users/logout");
    }

	protected function doesPageRequireAuthentication() {
		return false;
	}

    protected function getPageTitle() {
        return "Logged out";
    }

}
