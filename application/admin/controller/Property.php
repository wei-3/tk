<?php
namespace app\admin\controller;
class Property extends Admin{
    public function index(){
        $name=input('name');
        $map=array('status' => array('gt', -1));
        if(is_numeric($name)){
            $map['uid|name']=   array('like','%'.$name.'%');
        }else{
            $map['name']    =   array('like', '%'.(string)$name.'%');
        }
//        $list = \think\Db::name('Property')->where($map)->paginate(5);
        $list = $this->lists('Property',$map,'id desc');
        to_handle($list);
        //分页
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
//        $page = $list->render();
//        $this->assign('page', $page);
        $this->assign('list', $list);
        return $this->fetch();
    }
    public function add(){
        if(request()->isPost()){
            $Property = model('property');
            $post_data=$this->request->post();
            $validate = validate('property');
            $post_data['repair_number']=date("Ymd",time()).sprintf('%05d',rand(1000,9999));
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
            $data = $Property->create($post_data);
//            var_dump($post_data);exit;
            if($data){

                $this->success('新增成功', url('index'));
                //记录行为
                action_log('update_property', 'property', $data->id, UID);
            } else {
                $this->error($Property->getError());
            }
        }else{
            $this->assign('info',null);
            return $this->fetch('edit');
        }
    }
    public function edit($id=0){
        if($this->request->isPost()){
            $postdata = \think\Request::instance()->post();
//            var_dump($postdata);exit;
            $Property = \think\Loader::model("property");
//            $postdata['update_time']=time();
            $data = $Property->update($postdata);
            if($data !== false){
                $this->success('编辑成功', url('index'));
            } else {
                $this->error('编辑失败');
            }
        }else {
            $info = array();
            /* 获取数据 */
            $info = \think\Db::name('property')->find($id);
//            var_dump($info);exit;
            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            return $this->fetch();
        }
    }
    public function del(){
        $id = array_unique((array)input('id/a',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
        if(\think\Db::name('property')->where($map)->delete()){
            //记录行为
            action_log('update_property', 'property', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

}
