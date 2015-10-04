<?

/**
 * Controllers for rendering html should extend this.
 */
abstract class Controller_Base {

    /** @var Http_Request */
    protected $request;

    /** @var Http_Response */
    protected $response;

    /** @var Mode_User logged in user */
    protected $logged_in_user;

    /** @var array holds variables available for template */
    private $tpl = [];

    /** @var array holds variables available for js */
    private $js_data = [];

    public function __construct() {
        $this->response = new Http_Response();
        $this->request = new Http_Request();
        $this->logged_in_user = Authorizer::getLoggedInUser();
    }

    /**
     * Public entrypoint for all requests.
     */
    public function handleRequest() {
        $this->assign("cache_version", time());
        $is_authenticated = Authorizer::isAuthenticated();
        if ($this->doesPageRequireAuthentication() && !$is_authenticated) {
            $this->assign("page_title", "Login");
            $this->assign("is_authenticated", $is_authenticated);
            $this->render("users/login");
        }

        $this->assign("is_authenticated", $is_authenticated);
        if ($is_authenticated) {
            $this->assign("logged_in_user", $this->logged_in_user);
        }
        $this->assign("page_title", $this->getPageTitle());
        $this->handleRequestInternal();
    }

    /**
     * Subclasses implement this to do whatever they do.
     * This function most likely ends in a call to `$this->render("my_template")`
     */
    protected abstract function handleRequestInternal();

    /**
     * For the title tag in the head of the html page.
     * @return string
     */
    protected abstract function getPageTitle();

    /**
     * Assign a variable to be available to the template.
     * @param  string $key
     * @param  mixed $value
     */
    protected function assign($key, $value) {
        $this->tpl[$key] = $value;
    }

    /**
     * Assign JS data, which will be JSON encoded. It will be available in a
     * JS global variable with the prefix "global_data"
     * @param  string $key
     * @param  mixed $value
     */
    protected function assignJs($key, $value) {
        $this->js_data[$key] = json_encode($value);
    }

    /**
     * render a template
     * @param  string $template filename, relative to the "confcore/template/"
     *                          directory, i.e. "archive"
     */
    protected function render($template) {
        // make our tpl vars available inside the template
        foreach ($this->tpl as $key => $value) {
            $$key = $value;
        }

        $js_data = $this->js_data;
        require_once "template/functions.php";
        require_once "template/" . $template . ".php";
        exit;
    }

    /**
     * @return boolean
     */
    protected function doesPageRequireAuthentication() {
        return true;
    }

}