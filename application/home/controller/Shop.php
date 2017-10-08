<?php
namespace app\home\controller;
use app\home\model\Document;
class Shop extends Home{
    public function index(){
        $id=43;
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
            $this->error('该商家活动不存在！');
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