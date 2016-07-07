<?php

namespace modules\Admin;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Session\Adapter\Files as Session;

class Module implements ModuleDefinitionInterface
{

    const ns = 'modules\Admin\Controllers';

    public function registerAutoloaders(DiInterface $di = null){
        
        (new Loader())
            ->registerNamespaces([
                self::ns => APP_PATH . $di->get('config')->admin->controllersDir
            ])
            ->register();
    }


    public function registerServices(DiInterface $di){
 
        
        $di->set('dispatcher', function (){
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace(self::ns);
            return $dispatcher;
        }, true);
        
        $di->setShared('session', function () {
            $session =  new Session([
                'uniqueId' => 'live_admin'
            ]);
            $session->start();
            return $session;
        });       


        $di->set('view', function () use($di){
            return (new View())
                ->setViewsDir(APP_PATH . $di->get('config')->admin->viewsDir);
        }, true);
    }
}