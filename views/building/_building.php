<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<h5 class='clr'>楼宇资源
	<div class="navigate">当前位置：首页&nbsp;&gt;&nbsp;招商资源&nbsp;&gt;&nbsp;楼宇资源</div>
	<div class="search">
		<?php echo $this->render('_search',['title'=>'楼宇资源']); ?>
	</div>
</h5>

<ul class="clr">
<?php
$i = 1;
$buildings = $buildingProvider->getModels();
foreach ($buildings as $building) {
	$url = Url::to(['/building/show', 'id'=>$building['content'][0]]);
	$title = $building['content'][1];
	$imgSrc = $building['content'][2];
	if ($i == 1) {
		echo '<li style="margin-left: 0"><a href="'.$url.'"><img src="'.$imgSrc.'"></a><h4><a href="'.$url.'">'.$title.'</a></h4></li>';
	}
	else {
		echo '<li><a href="'.$url.'"><img src="'.$imgSrc.'"></a><h4><a href="'.$url.'">'.$title.'</a></h4></li>';
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
		'pagination' => $buildingProvider->pagination,
	    'nextPageLabel' => '下一页',
	    'prevPageLabel' => '上一页',
	    'firstPageLabel' => '首页',
	    'lastPageLabel' => '末页',
	]);?>
</div>
