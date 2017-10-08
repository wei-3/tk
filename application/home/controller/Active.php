<?php
namespace app\home\controller;
use app\home\model\Document;
use think\Db;

class Active extends Home{
    public function index(){
        $id=46;
        $this->assign('id',$id);
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
            $this->error('该活动不存在！');
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
    public function join($id){
        if(!is_login()){
            $this->error('您还没有登录，请先登录！', Url('user/login/index'));
        }else{
            //获取登录id
            $uid=is_login();
            //获取用户名
            $username=session('user_auth')['username'];
            //获取到document表中数据
//            $document = model('document')->where('id='.$id)->find();
            $document = Document::get(['id'=>$id]);
//            var_dump($document['description']);exit;
            if($document['description']<time()){
                $this->error('该活动已过期，看看其他活动吧', Url('Active/index'));
            }
            $list = \app\admin\model\Active::get(['active_id' =>$id,'user_id'=>$uid]);
//            var_dump($list->extend);exit;
            $active=new \app\admin\model\Active();
            if($list==null){
                $active->data([
                    'name'  =>  $username,
                    'user_id'=>$uid,
                    'active_name'=>$document['name'],
                    'active_id'=>$document['id'],
                    'active_intro'=>$document['description'],
                    'end_time'=>$document['deadline'],
                    'application_time'=>time(),
                    'status'=>0
                ]);
                $active->save();
                $this->success('报名成功,等待审核！', Url('Property/index'));
            }else{
                $active->save([
                    'status'=>2
                ],['user_id'=>$uid]);
                $this->error('你已经申请过该活动，看看其他活动吧', Url('Active/index'));
            }
        }
    }
}