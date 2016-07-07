<?php

namespace modules\User;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    
    const ns = 'modules\User\Controllers';

    public function registerAutoloaders(DiInterface $di = null){
        
        (new Loader())
            ->registerNamespaces([
                self::ns => APP_PATH . $di->get('config')->user->controllersDir
            ])
            ->register();
    }


    public function registerServices(DiInterface $di){
 

        $di->set('dispatcher', function(){
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace(self::ns);
            return $dispatcher;
        });

        $di->set('view', function() use($di){
            return (new View())
                ->setViewsDir(APP_PATH . $di->get('config')->user->viewsDir);
            
        });
    }
}