<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function _initialize(){
        if(!cookie('id')){
            $this->redirect('/Home/User/login');
        }
    }

    public function index(){
        $base = array(
            'All_Doc' => D('Common/Tie')->count(),
            'New_Doc' => D('Common/Tie')->where(array('time'=>array('GT',time()-(7*86400))))->count(),
            // 'All_Items' => D('Common/Tchild')->count(),
            // 'New_Items' => D('Common/Tchild')->where(array('time'=>array('GT',time()-(7*86400))))->count(),
            // 'All_Comment' => D('Common/Comment')->count(),
            // 'New_Comment' => D('Common/Comment')->where(array('time'=>array('GT',time()-(7*86400))))->count()
        );
        $this->base = $base;

        $list = D('Common/Tie')->order('time desc')->select();
        foreach($list as $k=>$v){
            $list[$k]['items'] = D('Common/Tchild')->where(array('tid'=>$v['_id']))->count();
            $list[$k]['comments'] = D('Common/Comment')->where(array('tid'=>$v['_id']))->count();
            $list[$k]['new_time'] = D('Common/Comment')->where(array('tid'=>$v['_id']))->order('time desc')->getfield('time');
        }
        $this->list = $list;

        $this->display();
    }

    public function add(){
        $this->display();
    }

    public function add_post(){
        $data['title'] = I('title');
        if(!$data['title']){
            $this->error("主题不可以为空！");
        }
        $data['description'] = I('description');
        $data['time'] = time();
        $data['uid'] = cookie('id');
        $data['username'] = cookie('username');
        $data['status'] = 1;
        $suc = D('Common/Tie')->data($data)->add();
        if($suc){
            $this->redirect('detail?id='.$suc.$id);
        }else{
            $this->error('Error');
        }
    }

    public function detail(){
        $id = I('id');
        $theme = D('Common/Tie')->where(array('_id'=>$id))->find();
        if(!$theme){
            $this->error('404 no found!!!',U('index'));
        }
        $this->theme = $theme;

        $this->child = D('Common/Tchild')->where(array('tid'=>$id))->order('time asc')->select();

        $this->display();
    }

    public function child_post(){
        $data['tid'] = I('tid');
        $data['title'] = I('title');
        $data['content'] = I('content');
        $data['time'] = time();
        $data['uid'] = cookie('id');
        $data['username'] = cookie('username');
        $data['status'] = 1;

        $suc = D('Common/Tchild')->data($data)->add();

        if($suc){
            $this->success('添加成功！！');
        }else{
            $this->error('Error');
        }
    }

    public function comment_post(){
        $data['cid'] = I('cid');
        $data['tid'] = I('tid');
        $data['comment'] = I('comment');
        $data['time'] = time();
        $data['uid'] = cookie('id');
        $data['username'] = cookie('username');
        $data['status'] = 1;

        $suc = D('Common/Comment')->data($data)->add();

        if($suc){
            $this->ajaxReturn(array('status'=>1,'data'=>array(
                'username' => $data['username'],
                'time' => date('Y-m-d H:i:s',$data['time']),
                'comment' => $data['comment']
            )));
        }else{
            $this->ajaxReturn(array('status'=>0,'tips'=>'Error'));
        }
    }





}
