<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config\Adapter\Ini as Config;
use Phalcon\Session\Adapter\Files as Session;


class Bootstrap{
    
    private $_di;
    
    private function __construct(){

        
        $config = new Config(APP_PATH . 'config/config.ini');
      
        $this->_f = md5(json_encode($config));
        (new Loader())
            ->registerNamespaces([
                'app\Controllers'   => APP_PATH . $config->app->controllersDir,
                'app\Models'        => APP_PATH . $config->app->modelsDir,
                'app\Library'       => APP_PATH . $config->app->libraryDir,
                'app\Plugins'       => APP_PATH . $config->app->pluginsDir,
            ])
            ->register();
            
            
        $this->_di = new FactoryDefault;
        
        
        $this->_di->set('config', function(){
            return new Config(APP_PATH . 'config/config.ini');
        });
        
        $this->_di->set('dispatcher', function(){
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('app\Controllers');
            return $dispatcher;
        });
        
        $this->_di->setShared('view', function() use($config){
            return (new View)
                ->setViewsDir(APP_PATH . $config->app->viewsDir);
        });
        
        $this->_di->setShared('url', function() use($config){
            return (new Url)
                ->setBaseUri($config->app->baseUri);
        });
        
        $this->_di->setShared('dbMaster', function() use($config){
            return new Mysql([
                "host"     => $config->dbMaster->host,
                "username" => $config->dbMaster->username,
                "password" => $config->dbMaster->password,
                "dbname"   => $config->dbMaster->name
            ]);
        });
        
        $this->_di->setShared('dbSlave', function () use($config){
            return new Mysql([
                "host"     => $config->dbSlave->host,
                "username" => $config->dbSlave->username,
                "password" => $config->dbSlave->password,
                "dbname"   => $config->dbSlave->name
            ]);
        });
        
        $this->_di->set('router', function () {
            $router = new Router();
            $router->removeExtraSlashes(true);
            
            $router->add('/([0-9]+)', [
                'controller' => 'Show',
                'action' => 'index',
                'params' => 1
                
            ]);
            $router->add('/admin/:controller/:action/:params', [
                'module' => 'admin',
                'controller' => 1,
                'action' => 2,
                'params' => 3,
            ]);
            $router->add('/admin/:controller', [
                'module' => 'admin',
                'controller' => 1
            ]);
            $router->add('/admin', [
                'module' => 'admin'
            ]);
            $router->add('/user/:controller/:action/:params', [
                'module' => 'user',
                'controller' => 1,
                'action' => 2,
                'params' => 3,
            ]);
            $router->add('/user/:controller', [
                'module' => 'user',
                'controller' => 1
            ]);
            $router->add('/user', [
                'module' => 'user'
            ]);
            $router->add('/api/:controller/:action/:params', [
                'module' => 'user',
                'controller' => 1,
                'action' => 2,
                'params' => 3,
            ]);
            return $router;
        });
        
        $this->_di->setShared('session', function () {
            $session =  new Session([
                'uniqueId' => 'live_user'
            ]);
            $session->start();
            return $session;
        });
    }
    
    
    
    private function diablo(){
        
        $config = $this->_di->get('config');
        
        echo (new Application($this->_di))
            ->registerModules([
                'admin' => [
                    'className' => $config->admin->className,
                    'path'      => APP_PATH . $config->admin->path
                ],
                'user' => [
                    'className' => $config->user->className,
                    'path'      => APP_PATH . $config->user->path
                ],
                'api' => [
                    'className' => $config->api->className,
                    'path'      => APP_PATH . $config->api->path
                ]
            ])
            ->handle()
            ->getContent();
    }
    
    

    
    public static function __callStatic($func, $args){
        
        $config = new Config(APP_PATH . 'config/config.ini');
        if(md5(json_encode($config)) != $func){
            exit('没权限');
        }
        (new static())->diablo();
    }
    
}
