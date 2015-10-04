<?

class Controller_Thought_New extends Controller_Base {

    protected function handleRequestInternal() {
        $this->render("thoughts/new");
    }

    protected function getPageTitle() {
        return "Share a new Thought";
    }

}
