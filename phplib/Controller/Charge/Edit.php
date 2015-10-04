<?

class Controller_Charge_Edit extends Controller_Base {

    /** @var Model_Charge */
    private $charge;

    public function __construct() {
        parent::__construct();
        $charge_id = (int) trim($this->request->getGet("charge_id"));
        $this->charge = Finder_Charge::getFinder()->findRecord($charge_id);
        if (!$this->charge) {
            throw new RuntimeException("Unable to find charge: $charge_id");
        }
    }

    protected function handleRequestInternal() {
        $this->assignJs("charge_id", $this->charge->charge_id);
        $this->assignJs("user_id", $this->logged_in_user->user_id);
        $this->assign("user_name", $this->logged_in_user->user_name);
        $this->assign("charge", $this->charge);
        $this->render("charges/edit");
    }

    protected function getPageTitle() {
        return "Charge #{$this->charge->charge_id}";
    }

}
