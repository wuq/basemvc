<?php
namespace app\Controllers;

use app\Library\BaseController;
use app\Library\Common;
use app\Models\Users;


class IndexController extends BaseController
{
    
    
    
    public function onConstruct(){
        
        
    }

    public function initialize(){
        
       $this->tag->setTitle("Website");
    }
    
    
    
    public function indexAction(){
        
        //Common::c();

        echo "<h1>Hello!</h1>";
        
        echo $this->tag->linkTo("signup", "Sign Up Here!");
        echo '<br />';
        
        echo $this->tag->linkTo('signup/forward', "转发");
        echo '<br />';

        print_r($this->session->get('name'));
        
    /*
        $a =  Users::findFirst(1);
        $a->name = 'lilith';
        $a->save();
    */
    
    $b = Users::findFirst([
        'id = :bid:',
        'bind' => ['bid' => 1],
    ]);
    if($b){
     //   print_r($b->name);
    }
    
    echo '<br />';
    
    echo Users::count();
    echo '<br />';
     
    //return xdebug_print_function_stack('stop');
    
    }
    
    
    
    public function fAction($a){
        
        echo '被转发到 index/f方法:'.$a;
    }
}