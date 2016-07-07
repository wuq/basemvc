<?php
namespace app\Controllers;

use app\Library\BaseController;
use app\Models\Users;

class SignupController extends BaseController
{

    public function indexAction(){
        

    }
    
    
    public function registerAction(){
        
        //csrf
        if($this->security->checkToken()){
            
            $user = new Users();
            $success = $user->save($this->request->getPost(), ['name', 'email']);
            if ($success) {
                $this->flash->success('注册成功');
            } else {
                $this->flash->error("注册失败");
                foreach ($user->getMessages() as $m) {
                    echo $m->getMessage(), "<br/>";
                }
            }
        }
        
        $this->view->disable();
    }
    
    
    
    public function forwardAction(){
        
        $this->flash->error("无权访问");

        
        $this->dispatcher->forward([
                "controller" => "Index",
                "action"     => "f",
                'params'     => ['a' => 'b']
            ]);
    }
}