<?php
namespace app\Controllers;

use app\Library\BaseController;
use app\Models\Users;


class ShowController extends BaseController
{
    
    
    
    public function onConstruct(){
        
        
    }

    public function initialize(){
        
       $this->tag->setTitle("直播间");
    }
    
    
    
    public function indexAction($id=0){

        echo '直播间:', $id;
        echo '<br />';
        
    }
    
    
}