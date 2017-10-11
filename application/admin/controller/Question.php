<?php
namespace app\admin\controller;
class Question extends Admin{
    public function index(){
        $name=input('name');
        $map=array('status' => array('gt', -1));
        if(is_numeric($name)){
            $map['uid|name']=   array('like','%'.$name.'%');
        }else{
            $map['name']    =   array('like', '%'.(string)$name.'%');
        }
        $list = $this->lists('Question',$map,'id desc');
        to_handle($list);
        //分页
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
//        $page = $list->render();
//        $this->assign('page', $page);
        $this->assign('list', $list);
        return $this->fetch();
    }
}