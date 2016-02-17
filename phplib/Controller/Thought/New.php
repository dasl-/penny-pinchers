<?

class Controller_Thought_New extends Controller_Base {

    protected function handleRequestInternal() {
        $this->assignJs("user_id", $this->logged_in_user->user_id);

        $this->render("thoughts/new");
    }

    protected function getPageTitle() {
        return "Share a new Thought";
    }

}
