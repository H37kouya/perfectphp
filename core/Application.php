<?php

namespace Core;

use Core\Router;
use Core\Whoops;
use Core\Request;
use Core\Session;
use Core\Response;
use Core\DbManager;
use Core\HttpNotFoundException;
use Core\UnauthorizedActionException;

abstract class Application
{
    /**
     * The current globally available application.
     *
     * @var static
     */
    protected static $instance;

    /**
     * デバッグするか否か
     *
     * @var boolean
     */
    protected $debug = false;

    /**
     * Requestを
     *
     * @var Request
     */
    protected $request;

    /**
     * Responseを
     *
     * @var Response
     */
    protected $response;

    /**
     * Session
     *
     * @var Session
     */
    protected $session;

    /**
     * DbManager
     *
     * @var DbManager
     */
    protected $db_manager;

    /**
     * login actionの格納
     *
     * @var array
     */
    protected $login_action = [];

    public function __construct()
    {
        $this->initialize();
        $this->setDebugMode();
        $this->configure();
    }

    /**
     * デバッグモードに応じてエラー表示処理を変更する関数
     *
     * @return void
     */
    protected function setDebugMode(): void
    {
        $debug = $this->request->env('DEBUG_MODE');

        if ($debug === true) {
            $this->debug = true;
            new Whoops;
        } else {
            $this->debug = false;
            ini_set('display_errors', 0);
        }
    }

    /**
     * クラスの初期化処理
     *
     * @return void
     */
    protected function initialize(): void
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->db_manager = new DbManager();
        $this->router = new Router($this->registerRoutes());
    }

    /**
     * アプリケーションの設定
     *
     * @return void
     */
    protected function configure(): void
    {
    }

    /**
     * プロジェクトのルートディレクトリを取得
     *
     * @return string ルートディレクトリへのファイルシステム上の絶対パス
     */
    abstract public function getRootDir(): string;

    /**
     * ルーティングを取得
     *
     * @return array
     */
    abstract protected function registerRoutes(): array;

    /**
     * debugモードの有無を返す関数
     *
     * @return boolean
     */
    public function isDebugMode(): bool
    {
        return $this->debug;
    }

    /**
     * Requestクラスを返す関数
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Responseクラスを返す関数
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * Sessionクラスを返す関数
     *
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * DbMangerクラスを返す関数
     *
     * @return DbManager
     */
    public function getDbManager(): DbManager
    {
        return $this->db_manager;
    }

    /**
     * appのパスを返す関数
     *
     * @return string
     */
    public function getAppDir(): string
    {
        return $this->getRootDir() . '/app';
    }

    /**
     * controllerのパスを返す関数
     *
     * @return string
     */
    public function getControllerDir(): string
    {
        return $this->getAppDir(). '/Controllers';
    }

    /**
     * viewのパスを返す関数
     *
     * @return string
     */
    public function getViewDir(): string
    {
        return $this->getRootDir(). '/views';
    }

    /**
     * modelのパスを返す関数
     *
     * @return string
     */
    public function getModelDir(): string
    {
        return $this->getAppDir(). '/Models';
    }

    /**
     * webのパスを返す関数
     *
     * @return string
     */
    public function getWebDir(): string
    {
        return $this->getRootDir() . '/web';
    }

    /**
     * resourcesのパスを返す関数
     *
     * @return string
     */
    public function getResourcesDir(): string
    {
        return $this->getRootDir() . '/resources';
    }

    /**
     * Get the globally available instance of the application.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }


    /**
     * アプリケーションを実行する
     *
     * @throws HttpNotFoundException ルートが見つからない場合
     * @throws UnauthorizedActionException 認証系
     */
    public function run(): void
    {
        try {
            $params = $this->router->resolve($this->request->getPathInfo());

            if ($params === false) {
                throw new HttpNotFoundException('No route found for ' . $this->request->getPathInfo());
            }

            $controller = $params['controller'];
            $action = $params['action'];

            $this->runAction($controller, $action, $params);
        } catch (HttpNotFoundException $e) {
            $this->render404Page($e);
        } catch (UnauthorizedActionException $e) {
            list($controller, $action) = $this->login_action;
            $this->runAction($controller, $action);
        }

        $this->response->send();
    }

    /**
     * アクションを実行する関数
     *
     * @param string $controller_name
     * @param mixed $action
     * @param array $params
     * @return void
     *
     * @throws HttpNotFoundException コントローラが特定できない場合
     */
    public function runAction(string $controller_name, $action, array $params = []): void
    {
        // コントローラーの名前を大文字で始める
        $controller_class = ucfirst($controller_name) . 'Controller';

        $controller = $this->findController($controller_class);

        if ($controller === false) {
            throw new HttpNotFoundException($controller_class . ' controller is not found');
        }

        $content = $controller->run($action, $params);

        $this->response->setContent($content);
    }

    /**
     * controllerクラスを生成する関数
     *
     * @param string $controller_class
     * @return Controller|false
     */
    public function findController(string $controller_class)
    {
        // echo $controller_class . "<br>";
        // if (!class_exists($controller_class)) {
        //     $controller_file = $this->getControllerDir() . '/' . $controller_class . '.php';
        //     echo $controller_file . '<br>';
        // }

        // if (!is_readable($controller_file)) {
        //     return false;
        // } else {
        //     require_once $controller_file;

        //     if (!class_exists($controller_class)) {
        //         return false;
        //     }
        // }

        $controller_class = "\App\Controllers\\" . $controller_class;

        // ControllerクラスのコンストラクタにApplicationクラス自身を渡す。
        return new $controller_class($this);
    }

    /**
     * 404 Not Foundをレンダリングする関数
     *
     * @param HttpNotFoundException $e
     * @return void
     */
    protected function render404Page(HttpNotFoundException $e): void
    {
        $this->response->setStatusCode(404, 'Not Found');
        $message = $this->isDebugMode() ? $e->getMessage() : 'Page not found';
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $this->response->setContent(
            <<<EOF
<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>404 - Not Found</title>
</head>
<body>
        {$message}
</body>
</html>
EOF
    );
    }
}
