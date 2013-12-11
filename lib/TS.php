<?php
require_once 'RestService.php';
require_once 'BackendService.php';
require_once 'AppService.php';
require_once 'WorkflowService.php';

class TS {
    private $backendService;
    private $appService;
    private $workflowService;

    public static $instance;

    /**
     * @return TS
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new TS();
        }

        if ($_SESSION['user']) {
            RestService::setContext($_SESSION['user']->Id, $_SESSION['user']->CompanyAccountId);
        }
        return self::$instance;
    }

    public function getCompanyId() {
        return RestService::getCompanyId();
    }

    public function getUserId() {
        return RestService::getUserId();
    }

    public static function isLoggedIn() {
        return !!$_SESSION['user'];
    }

    public static function user() {
        return $_SESSION['user'];
    }

    public static function setUser($user) {
        $_SESSION['user'] = $user;
        session_commit();
    }

    function __construct() {
        $this->backendService = new BackendService();
        $this->appService = new AppService();
        $this->workflowService = new WorkflowService();
    }

    private function startsWith($path, $start) {
        return (substr($path,0,strlen($start)) === $start);
    }

    public function proxy($method, $url, $body) {
        $method = strtoupper($method);

        $service = null;
        if ($this->startsWith($url, '/workflow/')) {
            $service = $this->workflowService;
        } else if ($this->startsWith($url, '/apps/')) {
            $service = $this->appService;
        } else if ($this->startsWith($url, '/app/')) {
            $service = $this->appService;
        } else{
            $service = $this->backendService;
        }

        $url = "/external".$url;

        switch($method) {
            case 'DELETE':
            case 'GET':
                return $service->httpRequest($method,$url);
            case 'POST':
            case 'PUT':
                return $service->httpBodyRequest($method,$url,$body);
        }

        throw new Exception("Unhandled request type: $method for $url");
    }

    /**
     * @return WorkflowService
     */
    public function getWorkflowService()
    {
        return $this->workflowService;
    }

    /**
     * @return BackendService
     */
    public function getBackendService()
    {
        return $this->backendService;
    }

    /**
     * @return AppService
     */
    public function getAppService()
    {
        return $this->appService;
    }




}
