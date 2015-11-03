<?php
namespace Home\Widget;
use Think\Controller;
class CommentWidget extends Controller {
    public function index($id){
        $this->cmt = D('Common/Comment')->where(array('cid'=>$id))->select();
        $this->display('comment');
    }
}
