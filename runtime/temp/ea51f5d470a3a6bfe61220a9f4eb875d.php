<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"D:\phpStudy\WWW\twothink\public/../application/home/view/default/property\my_profile.html";i:1507473050;}*/ ?>



<div class="main-title">
    <h2>我的资料</h2>
</div>
<form action="" method="post" class="form-horizontal">
    <div class="form-item">
        <span class="item-label">用户名：<span class="check-tips"><?php echo $user['name']; ?></span></span>
    </div>
    <div class="form-item">
        <span class="item-label">业主姓名：<span class="check-tips"><?php echo $owner['name']; ?></span></span>
    </div>
    <div class="form-item">
        <span class="item-label">业主电话：<span class="check-tips"><?php echo $owner['tel']; ?></span></span>
    </div>
    <div class="form-item">
        <span class="item-label">住户编号：<span class="check-tips"><?php echo $owner['number']; ?></span></span>
    </div>
    <div class="form-item">
        <span class="item-label">小区名字：<span class="check-tips"><?php echo $owner['cell_name']; ?></span></span>
    </div>
    <div class="form-item">
        <span class="item-label">身份证：<span class="check-tips"><?php echo $owner['id_card']; ?></span></span>
    </div>
    <div class="form-item">
			<span class="item-label">与业主关系：<span class="check-tips">
				<?php echo $owner['relationship']; ?>
									</span></span>
    </div>
    <div class="form-item">
        <span class="item-label">认证时间：<span class="check-tips"><?php echo $owner['create_time']; ?></span></span>
    </div>
</form>


<script type="text/javascript" charset="utf-8">
    //导航高亮
    highlight_subnav('<?php echo url('index'); ?>');
</script>

