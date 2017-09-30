<?php
namespace app\admin\controller;
class Users extends Admin{
    public function login(){
        if(request()->isPost()){

        }else{
            return $this->fetch('login');
        }
    }
}
