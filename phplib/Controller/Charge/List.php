<?

class Controller_Charge_List extends Controller_Base {

    /** @var Model_User */
    private $user;

    public function __construct() {
        parent::__construct();
        $user_name_or_id = trim($this->request->getGet("user_name_or_id"));
        $this->user = Finder_User::getFinder()->findByUserNameOrId($user_name_or_id);
        if (!$this->user) {
            throw new RuntimeException("Unable to find user by name or id: $user_name_or_id");
        }
    }

    protected function handleRequestInternal() {
        $this->assignJs("user_id", $this->user->user_id);
        $this->assign("user_id", $this->user->user_id);
        $charges = Finder_Charge::getFinder()->findByUserId($this->user->user_id);
        $this->assign("user_name", $this->user->user_name);
        $this->assign("charges", $charges);
        if ($this->logged_in_user->user_id === $this->user->user_id) {
            $action_name = "Edit";
        } else {
            $action_name = "View";
        }
        $this->assign("action_name", $action_name);
        $this->render("charges/list");
    }

    protected function getPageTitle() {
        return "Charges for {$this->user->user_name}";
    }

}
