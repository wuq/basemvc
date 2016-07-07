<?php

namespace modules\Api;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Config\Adapter\Ini as Config;
use Phalcon\Mvc\ModuleDefinitionInterface;



class Module implements ModuleDefinitionInterface
{

    const ns = 'modules\Api\Controllers';

    public function registerAutoloaders(DiInterface $di = null){
        
        (new Loader())
            ->registerNamespaces([
                self::ns => APP_PATH . $di->get('config')->api->controllersDir
            ])
            ->register();
    }


    public function registerServices(DiInterface $di){
 
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace(self::ns);
            return $dispatcher;
        });

    }
}