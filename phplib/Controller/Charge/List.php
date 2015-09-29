<?

class Controller_Charge_List extends Controller {

    /** @var Model_User */
    private $user;

    public function __construct() {
        parent::__construct();
        $user_name_or_id = trim($this->request->getGet("user_name_or_id"));
        $this->user = Model::getFinder("User")->findByUserNameOrId($user_name_or_id);
        if (!$this->user) {
            throw new RuntimeException("Unable to find user by name or id: $user_name_or_id");
        }
    }

    protected function handleRequestInternal() {
        $this->assignJs("user_id", $this->user->user_id);
        $charges = Model::getFinder('Charge')->findByUserId($this->user->user_id);
        $this->assign("user_name", $this->user->user_name);
        $this->assign("charges", $charges);
        $this->render("charges/list");
    }

    protected function getPageTitle() {
        return "Charges for {$this->user->user_name}";
    }

}
