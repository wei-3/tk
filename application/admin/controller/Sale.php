<?php
namespace app\admin\controller;
class Sale extends Admin{
    public function index(){
        $name=input('title');
        $map=array('status' => array('gt', -1));
        if(is_numeric($name)){
            $map['uid|title']=   array('like','%'.$name.'%');
        }else{
            $map['title']    =   array('like', '%'.(string)$name.'%');
        }

        $list = $this->lists('Sale',$map,'id desc');
        to_handle($list);
        //分页
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('list', $list);
        return $this->fetch();
    }
    public function add(){
        if(request()->isPost()){
            $Property = model('sale');
            $post_data=$this->request->post();
            $validate = validate('sale');
//            var_dump($post_data);exit;
            var_dump(UID);exit;
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }

            $data = $Property->create($post_data);
//            var_dump($post_data);exit;
            if($data){

                $this->success('新增成功', url('index'));
                //记录行为
                action_log('update_sale', 'sale', $data->id, UID);
            } else {
                $this->error($Property->getError());
            }
        }else{
            $model_id   =   input('model_id',0);
            // 获取当前的模型信息
            $model    =   get_document_model($model_id);
            $fields = get_model_attribute($model['id']);
            $this->assign('info',null);
            return $this->fetch('edit');
        }
    }
    public function edit($id=0){
        if($this->request->isPost()){
            $postdata = \think\Request::instance()->post();
//            var_dump($postdata);exit;
            $Property = \think\Loader::model("sale");
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
            $info = \think\Db::name('sale')->find($id);
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
        if(\think\Db::name('sale')->where($map)->delete()){
            //记录行为
            action_log('update_sale', 'sale', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('path');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                var_dump($info->getSaveName());exit;
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}
