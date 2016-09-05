<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

/*
 * 首页布局
 * */
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>北干楼宇网</title>
	<?php $this->head() ?>
	<link rel="stylesheet" href="<?= Url::base() ?>/css/main.css">
	<script type="text/javascript" src="<?= Url::base() ?>/assets/js/lib/jQuery.js"></script>
	<script type="text/javascript" src="<?= Url::base() ?>/assets/js/jquery.SuperSlide.2.1.1.js"></script>	
</head>
<body>
	<div class="main">
		<div class="topInfo">
			<span>2016年7月27日 星期日</span>
			<span>设为首页</span>
			<span>加入收藏</span>
		</div>
		<div class="logo">
			<h1>萧山区北干楼宇经济网</h1>
		</div>
		<div class="topNav">
			<a href="<?= Url::base(true) ?>" class="active">首页</a>
			<span>|</span>
			<a href="<?= Url::to(['/post/list', 'title' => '楼宇动态']); ?>">楼宇动态</a>
			<span>|</span>
			<a href="<?= Url::to(['/post/list', 'title' => '政策法规']); ?>">政策法规</a>
			<span>|</span>
			<a href="<?= Url::to(['/building/index']); ?>">招商引资</a>
			<span>|</span>
			<a href="<?= Url::to(['/post/list', 'title' => '招商引资']); ?>">楼宇资源</a>
			<span>|</span>
			<a href="<?= Url::to(['/post/list', 'title' => '服务办理']); ?>">服务办理</a>
			<span>|</span>
			<a href="<?= Url::to(['/post/list', 'title' => '便民服务']); ?>">便民服务</a>
			<span>|</span>
			<a href="<?= Url::to(['/post/list', 'title' => '招聘信息']); ?>">招聘信息</a>
			<span>|</span>
			<a href="<?= Url::to(['/book/index']); ?>">意见箱</a>
		</div>
		<div class="nbsp"></div>
		<!-- 内容加载 -->
		<?= $content ?>	
	</div>

	<div class="footer">
		<a href="<?= Url::base(true) ?>">首页</a><span>-</span>
		<a href="<?= Url::to(['/post/list', 'title' => '楼宇动态']); ?>">楼宇动态</a><span>-</span>
		<a href="<?= Url::to(['/post/list', 'title' => '政策法规']); ?>">政策法规</a><span>-</span>
		<a href="<?= Url::to(['/post/list', 'title' => '招商引资']); ?>">招商引资</a><span>-</span>
		<a href="<?= Url::to(['/building/index']); ?>">楼宇资源</a><span>-</span>
		<a href="<?= Url::to(['/post/list', 'title' => '服务办理']); ?>">服务办理</a><span>-</span>
		<a href="<?= Url::to(['/post/list', 'title' => '便民服务']); ?>">便民服务</a><span>-</span>
		<a href="<?= Url::to(['/post/list', 'title' => '招聘信息']); ?>">招聘信息</a><span>-</span>
		<a href="<?= Url::to(['/book/index']); ?>">意见箱</a>
		<p>Copyright&nbsp;&nbsp;&copy;1998-2016&nbsp;All Rights Reserved</p>
		<p>客服热线：400-8888-8888&nbsp;招商热线：400-8888-8888</p>
		<p>浙ICP备88888888号</p>
	</div>
</body>

<script type="text/javascript" src="<?= Url::base() ?>/assets/js/bglySite.js"></script>
<script src="<?= Url::base() ?>/assets/js/myfocus-2.0.4.min.js"></script>
<script type="text/javascript">
myFocus.set({
	id:'myFocus',//id
	pattern:'mF_YSlider'//style
});
</script>
</html>