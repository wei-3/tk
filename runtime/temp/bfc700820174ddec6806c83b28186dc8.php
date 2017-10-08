<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\phpStudy\WWW\twothink\public/../application/home/view/default/active\detail.html";i:1507447247;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="/cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo url('Index/list_index'); ?>" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo url('Service/list_index'); ?>" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo url('Property/find'); ?>" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo url('Property/index'); ?>" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid">
        <div class="blank"></div>
        <h3 class="noticeDetailTitle"><strong><?php echo $info['title']; ?></strong></h3>
        <div class="noticeDetailInfo">发布者:<?php echo $info['name']; ?></div>
        <div class="noticeDetailInfo">发布时间：<?php echo date('Y-m-d H:i',$info['create_time']); ?></div>
        <div class="noticeDetailInfo" data-id="<?php echo $info['deadline']; ?>" id="times">活动截止时间：<?php echo date('Y-m-d H:i',$info['deadline']); ?></div>
        <div class="noticeDetailInfo pull-right"><a class="ajax-page confirm" href="<?php echo url('Active/join?id='.$info['id']); ?>">申请参与活动</a></div><br/>
        <div class="noticeDetailContent">
            <?php echo $info['content']; ?>
        </div>
        <div class="noticeDetailInfo"><img src="<?php echo get_cover($info['cover_id'],$field = path); ?>"></div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function(){
        var url=$('.confirm').attr('href');
        $('.ajax-page').click(function () {
            if($(this).hasClass('ajax-page')){
                $.get('url',{times:t},function(data){
                    console.log(data);
                    if(data['status']==1){
                        $('.ajax-page').html(data.info).removeClass('ajax-page')
                    }else if(data['status']==0){
                        alert(data.info);
                        location.href=data.url;
                    }else {
                        $('.ajax-page').html(data.info).removeClass('ajax-page')
                    }
                })
            }
        });
    });
</script>
</body>
</html>