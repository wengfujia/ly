<?php 
use yii\helpers\Url;

/*
 * 社区首页
 * */

$title = '金城社区';
if (isset($this->params['breadcrumbs'])) {
	$title = $this->params['breadcrumbs'][0];
}

$css ='sq1';
if (strpos($title, '绿意')!== false)
	$css ='sq1';
else if (strpos($title, '蓝苑')!== false)
	$css ='sq2';
else if (strpos($title, '瑞商')!== false)
	$css ='sq3';
else if (strpos($title, '太汇')!== false)
	$css ='sq4';
else if (strpos($title, '金城')!== false)
	$css ='sq5';
				
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>北干楼宇网</title>
	<link rel="stylesheet" href="<?= Url::base() ?>/css/main.css">
	<script type="text/javascript" src="<?= Url::base() ?>/assets/js/lib/jQuery.js"></script>
	<script type="text/javascript" src="<?= Url::base() ?>/assets/js/jquery.SuperSlide.2.1.1.js"></script>
	<?php $this->head() ?>
</head>
<body style="background: url(<?= Url::base() ?>/css/img/<?=$css ?>/body.jpg) center top no-repeat #fff">
	<div class="cateLouyu">
		<div class="cateLogo"></div>
		<div class="shequNav" style="background: url(<?= Url::base() ?>/css/img/sq5/shequNav.png) no-repeat;">
			<a href="<?= Url::base() ?>/" class="backToIndex">返回楼宇网首页</a>
		</div>
		<?= $content ?>
	</div>

	<div class="ly_footer" style="background: url(<?= Url::base() ?>/css/img/sq5/sq_footer.png)">
		<p>Copyright&nbsp;&nbsp;&copy;1998-2016&nbsp;All Rights Reserved</p>
		<p>客服热线：400-8888-8888&nbsp;招商热线：400-8888-8888</p>
		<p>浙ICP备88888888号</p>
	</div>

	<script src="<?= Url::base() ?>/assets/js/myfocus-2.0.4.min.js"></script>
	<script type="text/javascript">
	myFocus.set({
		id:'SQmyFocus',//id
		pattern:'mF_YSlider'//style
	});
	</script>
</body>
</html>