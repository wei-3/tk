<?php
namespace app\home\controller;
use app\home\model\Document;

class Notice extends Home{
    public function notice(){
//        $list = Document::all(['status'=>1,'category_id'=>44]);
//        var_dump($list);exit;
        if(!is_login()){
            $this->error('您还没有登录，请先登录！', Url('user/login/index'));
        }else{
            $id=44;
            $this->assign('id',$id);//列表
            return $this->fetch('notice');
        }
    }
    public function ajaxpage($id,$page=1){
        $list=Document::where(['category_id'=>$id])->paginate(3);
        $this->assign('list',$list);
        $this->assign('no',++$page);
        return $this->fetch();
    }
    public function detail($id=0){
        if(!($id && is_numeric($id))){
            $this->error('该通知不存在！');
        }
        $Document = new Document();
        $info = $Document->detail($id);
        if(!$info){
            $this->error($Document->getError());
        }
        $map = array('id' => $id);
        $Document->where($map)->setInc('view');
        $this->assign('info', $info);
        return $this->fetch('detail');
    }
}