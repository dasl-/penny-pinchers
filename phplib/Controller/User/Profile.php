<?

class Controller_User_Profile extends Controller_Base {

    /** @var Model_User */
    private $profile_user;

    /** @var boolean is the user viewing the profile page the same as the logged in user? */
    private $is_own_profile = false;

    public function __construct() {
        parent::__construct();

        $user_name_or_id = trim($this->request->getGet("user_name_or_id"));
        $this->profile_user = Finder_User::getFinder()->findByUserNameOrId($user_name_or_id);
        if (!$this->profile_user) {
            throw new RuntimeException("Unable to find user by name or id: $user_name_or_id");
        }

        if ($this->logged_in_user) {
        	$this->is_own_profile = $this->logged_in_user->user_id === $this->profile_user->user_id;
        }
    }
    protected function handleRequestInternal() {
        $this->assign("is_own_profile", $this->is_own_profile);
        $this->assign("profile_user", $this->profile_user);
    	$this->assignJs("user_id", $this->profile_user->user_id);
        $this->render("users/profile");
    }

    protected function getPageTitle() {
    	if ($this->is_own_profile) {
    		return "Your Profile";
    	}
        return "{$this->profile_user->user_name}'s Profile";
    }

}
