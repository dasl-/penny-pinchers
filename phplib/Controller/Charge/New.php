<?

class Controller_Charge_New extends Controller {

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
        $this->render("charges/new");
    }

    protected function getPageTitle() {
        return "New Charge for {$this->user->user_name}";
    }

}