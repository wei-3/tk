<?php
namespace app\home\controller;

use app\admin\model\Member;

class Property extends Home{
    public function property(){

            return $this->fetch('online');
    }
    //显示ajax加载的数据
    public function my_property(){
        if(!is_login()){
            $this->error('您还没有登录，请先登录！', Url('user/login/index'));
        }else{
            return $this->fetch();
        }
    }
    //ajax加载数据并分页
    public function ajaxpage($page=1){
//        var_dump($id);
        $id=is_login();
        $list=\app\home\model\Property::where(['user_id'=>$id])->paginate(3);
        $this->assign('list',$list);
        $this->assign('no',++$page);
        return $this->fetch();
    }
    //报修增加
    public function Add(){
        if(request()->isPost()){
            $Property = model('Property');
            $post_data=$this->request->post();
            $validate = validate('property');
//            var_dump($post_data);exit;
            $post_data['repair_number']=date("Ymd",time()).sprintf('%05d',rand(1000,9999));
            $post_data['user_id']=is_login();
//            var_dump($post_data);exit;
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
//            var_dump($post_data);exit;
            $data = $Property->create($post_data);
            if($data){
                $this->success('新增成功', url('index'));
                //记录行为
                action_log('update_property', 'property', $data->id, UID);
            } else {
                $this->error($Property->getError());
            }
        }
    }
    //我的页面基础显示
    public function index(){
        if(!is_login()){
            $this->error('您还没有登录，请先登录！', Url('user/login/index'));
        }else{
            $id=is_login();
            $user=\app\home\model\Owner::get(['member_id'=>$id]);
            $userinfo=Member::get(['uid'=>$id]);
            $this->assign('user',$user);
            $this->assign('userinfo',$userinfo);
            return $this->fetch('index');
        }
    }

    public function find(){
        return $this->fetch('find');
    }
}