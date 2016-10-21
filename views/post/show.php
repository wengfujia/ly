<?php

use yii\web\View;
use app\components\XUtils;
use app\models\Post;
use yii\base\Response;

/**
 * @var yii\web\View $this
 * @var app\models\Post $post
 */

?>
<?php echo $this->render("_nav"); ?>

<?php if ($post->OutUrl>'') { //如果存在外面连接，进行页面跳转
	header("Location:".$post->OutUrl);
}
?>
<div class="Show">
	<h2><?= $post->Title?></h2>
	<h4><?= XUtils::XDateFormatter($post->DateCreated)?>&nbsp;<?= $post->CopyFrom?></h4>
	<?= $post->PostContent?>
</div>