<?

class Controller_Charge_New extends Controller_Base {

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
        $this->assignJs("user_name", $this->user->user_name);
        $this->assign("user_name", $this->user->user_name);
        $this->assign("is_compact_header", true);
        $this->assign("compact_header_title", "New Charge for {$this->user->user_name}");
        $this->render("charges/new");
    }

    protected function getPageTitle() {
        return "New Charge for {$this->user->user_name}";
    }

}
