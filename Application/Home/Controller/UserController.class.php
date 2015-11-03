<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {

    public function login(){
        $this->display();
    }

    public function login_post(){
        $password = I('password');
        $user['phone'] = I('phone');
        $user['password'] = md5('KStart'.$password);
        $check = D('Common/User')->where($user)->find();
        if($check){
            cookie('id',$check['_id'],8640000);
            cookie('username',$check['username'],8640000);
            $this->redirect('Home/Index/index');
        }else{
            $this->redirect('login');
        }
    }

    public function logout(){
        cookie('id',null);
        cookie('username',null);
        $this->redirect('login');
    }

}
