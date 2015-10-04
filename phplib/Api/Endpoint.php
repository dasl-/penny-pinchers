<?

/**
 * Extend this to return some json.
 */
abstract class Api_Endpoint {

    /** @var Http_Request */
    protected $request;

    /** @var Http_Response */
    protected $response;

    /** @var string the http method of the request */
    protected $method;

    public function __construct() {
        $this->request = new Http_Request();
        $this->response = new Http_Response();
        $this->method = $this->getMethod();
    }

    final public function handleRequest() {
        try {
            if ($this->doesEndpointRequireAuthentication()) {
                $this->authorizeRequest();
            }
            $response = $this->handleRequestInternal();
        } catch (Exception $e) {
            $this->response->setStatusCode(Http::STATUS_CODE_INTERNAL_SERVER_ERROR);
            $response = [
                "success" => false,
                "exception" => "$e",
            ];
        }

        $this->renderResponse($response);
    }

    /**
     * Subclasses implement this to do whatever they do.
     * @return array An associative array that will be turned into json as the response.
     */
    protected abstract function handleRequestInternal();

    /**
     * @return boolean
     */
    protected function doesEndpointRequireAuthentication() {
        return true;
    }

    /**
     * get the http method of the request
     * @return string
     */
    private function getMethod() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case Http::METHOD_GET:
            case Http::METHOD_UPDATE:
            case Http::METHOD_CREATE:
            case Http::METHOD_DELETE:
                return $method;
            default:
                $this->response->setStatusCode(Http::STATUS_CODE_METHOD_NOT_ALLOWED);
                $this->response->setResponse(['success' => false]);
        }
    }

    private function renderResponse(array $response) {
        $this->response->setResponse($response);
    }

    private function authorizeRequest() {
        $user_id = $this->request->getPost("user_id");
        $user = Finder_User::getFinder()->findRecord($user_id);
        if (!$user) {
            throw new RuntimeException("Unable to find user for authorization.");
        }

        $logged_in_user = Authorizer::getLoggedInUser();
        if ($user->user_id !== $logged_in_user->user_id) {
            $this->response->setStatusCode(Http::STATUS_CODE_UNAUTHORIZED);
            $this->renderResponse([
                "error_message" => "You are not authorized to do this.",
            ]);
        }
    }

}