<?

class Controller_Charge_List extends Controller_Base {

    /** @var Model_User */
    private $user;

    /** @var int month to show charges from. -1 means all time */
    private $month_number;

    public function __construct() {
        parent::__construct();
        $user_name_or_id = trim($this->request->getGet("user_name_or_id"));
        $this->user = Finder_User::getFinder()->findByUserNameOrId($user_name_or_id);
        if (!$this->user) {
            throw new RuntimeException("Unable to find user by name or id: $user_name_or_id");
        }

        $this->month_number = (int) trim($this->request->getGet("month_number"));
        if ($this->month_number === 0) {
            $this->month_number = (int) date("n");
        }
    }

    protected function handleRequestInternal() {
        $this->assignJs("user_id", $this->user->user_id);
        $this->assign("user_id", $this->user->user_id);

        $charges = Finder_Charge::getFinder()->findByUserIdAndChargeDates(
            $this->user->user_id,
            ($this->month_number === -1) ? null : Month::getEpochDateForBeginningOfMonth($this->month_number),
            ($this->month_number === -1) ? null : Month::getEpochDateForEndOfMonth($this->month_number)
        );

        $this->assign("user_name", $this->user->user_name);
        $this->assign("charges", $charges);
        $this->assign("month_number", $this->month_number);

        $total_charges = 0;
        foreach ($charges as $charge) {
            $total_charges += $charge->amount;
        }
        $this->assign("total_charges", $total_charges);

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
