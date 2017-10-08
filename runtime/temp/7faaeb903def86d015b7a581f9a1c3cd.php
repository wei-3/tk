<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"D:\phpStudy\WWW\twothink\public/../application/home/view/default/notice\ajaxpage.html";i:1507440931;}*/ ?>
<?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?>
<div class="text-info text-center lead">我是有底线的</div>
<?php else: if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$notice): $mod = ($i % 2 );++$i;?>
<div class="container-fluid">
    <div class="row noticeList">
        <a href="<?php echo url('Notice/detail?id='.$notice['id']); ?>">
            <div class="col-xs-2">
                <img class="noticeImg" src="<?php echo get_cover($notice['cover_id'],$field = path); ?>" alt="该图片被外星人拉走了" />
            </div>
            <div class="col-xs-10">
                <p class="title"><?php echo $notice['title']; ?></p>
                <p class="intro"><?php echo $notice['description']; ?></p>
                <p class="info">浏览: <?php echo $notice['view']; ?> <span class="pull-right"><?php echo $notice['create_time']; ?></span> </p>
            </div>
        </a>
    </div>
</div>
<?php endforeach; endif; else: echo "" ;endif; ?>
<div class="text-center">
    <button type="button" class="btn btn-default btn_load btn-block" onclick="loadPage(<?php echo $no; ?>)">获取跟多~~~</button>
</div>
<?php endif; ?>

