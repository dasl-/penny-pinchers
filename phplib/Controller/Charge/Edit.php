<?

class Controller_Charge_Edit extends Controller {

    /** @var Model_Charge */
    private $charge;

    public function __construct() {
        parent::__construct();
        $charge_id = (int) trim($this->request->getGet("charge_id"));
        var_dump($charge_id);
        $this->charge = Model::getFinder("Charge")->findRecord($charge_id);
        if (!$this->charge) {
            throw new RuntimeException("Unable to find charge: $charge_id");
        }
    }

    protected function handleRequestInternal() {
        $this->assignJs("charge_id", $this->charge->charge_id);
        $user = Model::getFinder('User')->findRecord($this->charge->user_id);
        $this->assign("user_name", $user->user_name);
        $this->assign("charge", $this->charge);
        $this->render("charges/edit");
    }

    protected function getPageTitle() {
        return "Charge #{$this->charge->charge_id}";
    }

}
