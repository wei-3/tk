<?php
namespace app\admin\controller;
class Owner extends Admin{
    public function index(){
        $name=input('name');
        $map=array('status' => array('gt', -1));
        if(is_numeric($name)){
            $map['uid|name']=   array('like','%'.$name.'%');
        }else{
            $map['name']    =   array('like', '%'.(string)$name.'%');
        }
//        $list = \think\Db::name('Property')->where($map)->paginate(5);
        $list = $this->lists('Owner',$map,'id desc');
        int_to_s($list);
        //分页
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
//        $page = $list->render();
//        $this->assign('page', $page);
        $this->assign('meta_title','模型管理');
        $this->assign('list', $list);
        return $this->fetch();
    }
    public function detail($id=0){
        if(!($id && is_numeric($id))){
            $this->error('该通知不存在！');
        }
        $info=\app\admin\model\Owner::get(['id'=>$id]);
        $this->assign('info', $info);
        return $this->fetch('detail');
    }
}
