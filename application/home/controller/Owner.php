<?php
namespace app\home\controller;
class Owner extends Home{
    public function index(){
        if(!is_login()){
            $this->error('您还没有登录，请先登录！', Url('user/login/index'));
        }else{
            return $this->fetch();
        }
    }
    public function add(){
        if(request()->isPost()){
            $Property = model('Owner');
            $post_data=$this->request->post();
            $validate = validate('Owner');
            $post_data['member_id']=is_login();
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
            $data = $Property->create($post_data);
            if($data){
                $this->success('新增成功', url('Service/list_index'));
                //记录行为
                action_log('update_owner', 'owner', $data->id, UID);
            } else {
                $this->error($Property->getError());
            }
        }
    }
}
