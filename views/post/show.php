<?php

use yii\web\View;
use app\components\XUtils;
use app\models\Post;

/**
 * @var yii\web\View $this
 * @var app\models\Post $post
 */

?>
<?php echo $this->render("_nav"); ?>
<div class="Show">
	<h2><?= $post->Title?></h2>
	<h4><?= XUtils::XDateFormatter($post->DateCreated)?>&nbsp;<?= $post->CopyFrom?></h4>
	<?= $post->PostContent?>
</div>