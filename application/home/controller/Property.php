<?php
namespace app\home\controller;

use app\admin\model\Member;
use app\home\model\Document;

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
           if($user['status']){
               $userinfo=Member::get(['uid'=>$id]);
               $this->assign('user',$user);
               $this->assign('userinfo',$userinfo);
               return $this->fetch('index');
           }else{
               $this->error('您的业主认证还未通过审核，请耐心等待！', Url('home/index/index'));
           }
        }
    }
    //我报名的活动
    public function my_active(){
        if(!is_login()){
            $this->error('您还没有登录，请先登录！', Url('user/login/index'));
        }else{
            return $this->fetch();
        }
    }
    //我报名的活动ajax分页
    public function my_page($page=1){
        $id=is_login();
        $list=\app\admin\model\Active::where(['user_id'=>$id])->paginate(2);
        $this->assign('list',$list);
        $this->assign('no',++$page);
        return $this->fetch();
    }
    public function find(){
        return $this->fetch('find');
    }
    //我的资料
    public function my_profile(){
        if(!is_login()){
            $this->error('您还没有登录，请先登录！', Url('user/login/index'));
        }else{
            $id=is_login();
            $owner=\app\home\model\Owner::get(['member_id'=>$id]);
            $user=Document::get(['uid'=>$id]);
            $this->assign('owner',$owner);
            $this->assign('user',$user);
            return $this->fetch();
        }
    }
}