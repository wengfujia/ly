<?php
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use app\components\XUtils;

/**
 * 文章列表页
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */
?>

<?php echo $this->render("_nav"); ?>
<div class="List">
	<ul>
	  <?php   
    	  $posts = $dataProvider->getModels();
    	  if (empty($posts)) {
    	      echo '<article class="list-group-item"><h1>暂时没有公开的文章发布，请关注本站更新！</h1></article>';
    	  } else {
    	      foreach ($posts as $post) {
    	          echo '<li><span>'.XUtils::XDateFormatter($post->DateCreated).'</span><a href="'.$post->url.'">'.$post->Title.'</a></li>';
    	      }
    	  }
	  ?>
	</ul>

	<div class="page">
		<?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
            'firstPageLabel' => '首页',
            'lastPageLabel' => '末页',
        ]);?>
	</div>
</div>