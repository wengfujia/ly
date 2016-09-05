<?php
use app\modules\wap\assets\AdminAsset;
use app\modules\wap\assets\AppAsset;
use app\modules\admin\assets\SystemAsset;
use yii\helpers\Html;

SystemAsset::register($this);
AdminAsset::register($this);
$app = AppAsset::register($this);

?>

<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<title>北干楼宇经济网</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1, minimum-scale=1.0">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta content="telephone=no" name="format-detection">
<?php $this->head() ?>

<script>
	var Settings = { "templateUrl": "<?= $app->baseUrl?>" };
</script>

</head>
<body data-ng-app="blogAdmin" id="ng-app">
<?php $this->beginBody()?>
	<div id="header" class="">
		<input class="h-more" id="shownavi" value="&equiv;" type="button"><a
			href="#" class="h-logo">北干楼宇经济网</a>
	</div>
	<!-- /header -->

	<div id="navi">
		<ul class="clr">
			<li><a href="#/house/rent/list">楼宇资源</a></li>
			<li><a href="#/content/post/list#/&category=楼宇社区">楼宇社区</a></li>
			<li><a href="#/building/list">楼宇服务</a></li>
			<li><a href="#/content/post/list#/&category=楼宇企业">楼宇企业</a></li>
			<li><a href="#/content/post/list#/&category=招聘信息">楼宇招聘</a></li>
			<li><a href="#/content/post/list#/&category=公告">楼宇公告</a></li>
		</ul>
	</div>
	<!-- angular 加载模板 -->
	<div data-ng-view></div>
	
	<footer></footer>
	
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage() ?>