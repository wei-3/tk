<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\phpStudy\WWW\twothink\public/../application/home/view/default/property\ajaxpage.html";i:1507449393;}*/ ?>
<?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?>
<div class="text-info text-center lead">我是有底线的</div>
<?php else: if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$property): $mod = ($i % 2 );++$i;?>
<div class="container-fluid">
    <div class="row noticeList">
        <a href="<?php echo url('Property/detail?id='.$property['id']); ?>">
            <div class="col-xs-3">
                <p class="title text-info ">报修人：<?php echo $property['name']; ?></p>
            </div>
            <div class="col-xs-6">
                <p class="title">报修问题：<?php echo $property['problem']; ?></p>
            </div>
            <div class="col-xs-push-3">
                <p class="title text-danger"><?php echo $property['status']; ?></p>
            </div>
        </a>
    </div>
</div>
<?php endforeach; endif; else: echo "" ;endif; ?>
<div class="text-center">
    <button type="button" class="btn btn-default btn_load btn-block" onclick="loadPage(<?php echo $no; ?>)">点击我获取跟多~~~</button>
</div>
<?php endif; ?>

