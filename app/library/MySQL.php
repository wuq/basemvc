<?php
namespace app\Library;

use Phalcon\Mvc\Model;


class MySQL extends Model{


    //真实表名
    public function getSource(){
    
    }
    
    
    //class实例成功后才调用
    public function initialize(){
        
        
        $this->setWriteConnectionService('dbMaster');
        $this->setReadConnectionService('dbSlave');
    }
    
    
    //create前调用
    public function beforeCreate(){
       
    }

    
    //更新前调用
    public function beforeUpdate(){
       
    }
    
    
    //保存前调用
    public function beforeSave(){
       
    }
    
    
    //修改后调用
    public function afterSave(){
        
    }

}