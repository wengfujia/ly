<?php
use app\modules\admin\assets\AdminAsset;
use app\modules\admin\assets\AppAsset;
use yii\helpers\Html;
use app\modules\admin\assets\SystemAsset;
use yii\helpers\Url;

$rights = '';
$community_id = '';

if (!Yii::$app->user->isGuest) {
	/* @var User $current_user */
	$current_user = Yii::$app->user->identity;
	$community_id = $current_user->community_id;
	$permissions = yii::$app->authManager->getPermissionsByRole($current_user->role);
	foreach ($permissions as $permission) {
		$rights = $rights.'|'.$permission->name;
	}
}
else {
	$this->context->redirect(Url::to(['/site/login']));
}

//注册组件
SystemAsset::register($this);
AdminAsset::register($this);
$app = AppAsset::register($this);

?>

<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />

<!-- ueditor -->
<script type="text/javascript" charset="utf-8" src="<?= Url::base() ?>/assets/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?= Url::base() ?>/assets/ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="<?= Url::base() ?>/assets/ueditor/lang/zh-cn/zh-cn.js"></script>

<title>北干楼宇管理系统</title>
<?php $this->head() ?>
<style>
	input[type=file] {
	    display: inline;
	}
</style>
<!--[if lte IE 7]>
  <script src="<?= $app->baseUrl?>/scripts/json2.js"></script>
<![endif]-->
<script>
	var Settings = { "templateUrl": "<?= $app->baseUrl?>", "rights": "<?= $rights ?>", "communityid": "<?= $community_id ?>" };
</script>
</head>

<body data-ng-app="blogAdmin" id="ng-app">
<?php $this->beginBody()?>
	<header id="header">
		<h1>北干楼宇经济管理平台</h1>
		<span>
			<a href="#" title="退出" id="logout-btn">退出</a>
			<?php echo Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form']) . Html::endForm()?>
            <?php $this->registerJs('$("#logout-btn").click(function(){ $("#logout-form").submit();});');?>
        </span> 
		<span><a href="#/security/cate5.0">设置</a></span> <span>北干街道</span>
	</header>

	<nav id="navSide">
		<?= $this->render('sidebar') ?>
	</nav>

	<div id="show">
		<?= $content ?>
	</div>
<?php $this->endBody()?>
</body>
</html>

<?php $this->endPage() ?>