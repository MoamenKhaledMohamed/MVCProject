<?php


namespace app\core;



use app\models\User;

class Application
{
    public string $layout = 'auth';
    public Router $router;
    public Request $request;
    public Response $response;
    public DataBase $db;
    public Session $session;
    public ?DbModel $user;
    public View $view;
    public string $action;
    private string $className;
    public static Application $app;
    public static string $ROOTPATH;
    public ?Controller $controller = null;

    public function __construct(string $rootPath, array $config)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();
        $this->router = new Router($this->request, $this->response);
        $this->db = new DataBase($config['db']);
        $this->className = $config['className'];
        self::$ROOTPATH = $rootPath;
        self::$app = $this;

        // get user if from session
        $primaryValue = $this->session->get('user');
        if($primaryValue){
            // select from table where id = $primaryValue.
            $primaryKey = (new $this->className)->getPrimaryKey();
            $this->user = (new $this->className)->findOne([$primaryKey => $primaryValue]);
        }
        else
            $this->user = null;
    }

    public function run()
    {
        try{
            echo $this->router->resolve();
        }catch (\Exception $exception){
             $this->response->setStatusCode($exception->getCode());
             echo $this->view->renderView('errors', ['exception' => $exception]);
        }
    }

    public function login(DbModel $user): bool
    {
       // take the id and save it in session[user] = value
        $this->user = $user;
        $primaryKey = $user->getPrimaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user',$primaryValue);
        return true;
    }

    public function isGuest(): bool
    {
        return !$this->user;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

}