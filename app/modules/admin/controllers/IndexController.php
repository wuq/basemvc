<?php
namespace modules\Admin\Controllers;

use app\Library\AdminController;
use app\Models\Users;


class IndexController extends AdminController
{
    
    
    public function indexAction(){
        
       // $this->session->set('name','wuqiang');
        print_r($this->session->get('name'));
die;
    }
    
    
    public function testAction($a=0){
        
        echo $a;
    }

}