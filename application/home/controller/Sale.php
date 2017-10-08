<?php
namespace app\home\controller;
class Sale extends Home{
    public function index(){
        $list1 = \app\home\model\Sale::all(['type'=>'销售']);
        $list = \app\home\model\Sale::all(['type'=>'出租']);
//        var_dump($list);exit;
        $this->assign('list',$list);//列表
        $this->assign('list1',$list1);//列表
        return $this->fetch();
    }
    public function detail($id=0){
        if(!($id && is_numeric($id))){
            $this->error('该通知不存在！');
        }
       $info=\app\home\model\Sale::get(['id'=>$id]);
//        var_dump($info);exit;
        $this->assign('info', $info);
        return $this->fetch('detail');
    }
}