<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"D:\phpStudy\WWW\twothink\public/../application/home/view/default/active\ajaxpage.html";i:1507441976;}*/ ?>
<?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?>
<div class="text-info text-center lead">我是有底线的</div>
<?php else: if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$active): $mod = ($i % 2 );++$i;?>
<div class="container-fluid">
        <div class="row noticeList">
            <a href="<?php echo url('Active/detail?id='.$active['id']); ?>">
            <div class="col-xs-2">
                <img class="noticeImg img-circle" src="<?php echo get_cover($active['cover_id'],$field = path); ?>" alt="该图片被外星人拉走了"/>
            </div>
            <div class="col-xs-10">
                <p class="title"><?php echo $active['title']; ?></p>
                <p class="intro"><?php echo $active['description']; ?></p>
                <p class="info">浏览: <?php echo $active['view']; ?> <span class="pull-right"><?php echo $active['create_time']; ?></span></p>
            </div>
            </a>
        </div>
    </div>
<?php endforeach; endif; else: echo "" ;endif; ?>
<div class="text-center">
    <button type="button" class="btn btn-default btn_load btn-block" onclick="loadPage(<?php echo $no; ?>)">获取跟多~~~</button>
</div>
<?php endif; ?>

