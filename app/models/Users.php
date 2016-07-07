<?php
namespace app\Models;

use app\Library\MySQL;

class Users extends MySQL
{
    
    const OPEN  = 1;
    const CLOSE = 2;
    
    public $id;
    public $name;
    public $email;
    
    
    
    public function initialize(){
        
        parent::initialize();
    }
    
    public function getSource(){
        return "le_users";
    }
    
    
    public function beforeSave(){
        
        $this->name = 's:'.$this->name;
    }
    
    
}