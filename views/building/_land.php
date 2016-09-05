<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<h5 class='clr'>地块资源
	<div class="navigate">当前位置：首页&nbsp;&gt;&nbsp;招商资源&nbsp;&gt;&nbsp;地块资源</div>
	<div class="search">
		<?php echo $this->render('_search',['title'=>'地块资源']); ?>
	</div>
</h5>

<ul class="clr">
<?php
$i = 1;
$lands = $landProvider->getModels();
foreach ($lands as $land) {
	if ($i == 1) {
		echo '<li style="margin-left: 0"><a href="'.$land->url.'"><img src="'.$land.coverimage.'"></a><h4><a href="'.$land->url.'">'.$land->Title.'</a></h4></li>';
	}
	else {
		echo '<li><a href="'.$land->url.'"><img src="'.$land.coverimage.'"></a><h4><a href="'.$land->url.'">'.$land->Title.'</a></h4></li>';
	}
	if ($i == 4) {
		$i = 0;
	}
	$i = $i +1;
}
?>
</ul>

<div class="page">
	<?= LinkPager::widget([
		'pagination' => $landProvider->pagination,
	    'nextPageLabel' => '下一页',
	    'prevPageLabel' => '上一页',
	    'firstPageLabel' => '首页',
	    'lastPageLabel' => '末页',
	]);?>
</div>
