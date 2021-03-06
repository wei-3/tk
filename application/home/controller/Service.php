<?php
namespace app\home\controller;
use app\home\model\Document;

class Service extends Home{
    public function service(){
        $id=45;
        $this->assign('id',$id);//列表
        return $this->fetch();
    }
    //ajax获取分页数据
    public function ajaxpage($id,$page=1){
//        var_dump($id);
        $list=Document::where(['category_id'=>$id])->paginate(3);
        $this->assign('list',$list);
        $this->assign('no',++$page);
        return $this->fetch();
    }
    public function detail($id=0){
        if(!($id && is_numeric($id))){
            $this->error('该服务不存在！');
        }
        $Document = new Document();
        $info = $Document->detail($id);
        if(!$info){
            $this->error($Document->getError());
        }
        $map = array('id' => $id);
        $Document->where($map)->setInc('view');
//        var_dump($info);exit;
        $this->assign('info', $info);
        return $this->fetch('detail');
    }
    public function list_index(){
        return $this->fetch('list_index');
    }
    public function about(){
        $list = Document::all(['status'=>1,'category_id'=>48]);
        $this->assign('list',$list);//列表
        return $this->fetch('list_detail');
    }
    public function tips(){
        $list = Document::all(['status'=>1,'category_id'=>49]);
//        var_dump($list);exit;
        $this->assign('list',$list);//列表
        return $this->fetch('tips');
    }
    public function tips_detail($id=0){
        if(!($id && is_numeric($id))){
            $this->error('该服务不存在！');
        }
        $Document = new Document();
        $info = $Document->detail($id);
        if(!$info){
            $this->error($Document->getError());
        }
        $map = array('id' => $id);
        $Document->where($map)->setInc('view');
//        var_dump($info);exit;
        $this->assign('info', $info);
        return $this->fetch('tips_detail');
    }
}
