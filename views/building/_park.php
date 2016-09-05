<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<h5 class='clr'>园区资源
	<div class="navigate">当前位置：首页&nbsp;&gt;&nbsp;招商资源&nbsp;&gt;&nbsp;园区资源</div>
	<div class="search">
		<?php echo $this->render('_search',['title'=>'园区资源']); ?>
	</div>
</h5>

<ul class="clr">
<?php
$i = 1;
$parks = $parkProvider->getModels();
foreach ($parks as $park) {
	if ($i == 1) {
		echo '<li style="margin-left: 0"><a href="'.$park->url.'"><img src="'.$park.coverimage.'"></a><h4><a href="'.$park->url.'">'.$park->Title.'</a></h4></li>';
	}
	else {
		echo '<li><a href="'.$park->url.'"><img src="'.$park.coverimage.'"></a><h4><a href="'.$park->url.'">'.$park->Title.'</a></h4></li>';
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
		'pagination' => $parkProvider->pagination,
	    'nextPageLabel' => '下一页',
	    'prevPageLabel' => '上一页',
	    'firstPageLabel' => '首页',
	    'lastPageLabel' => '末页',
	]);?>
</div>
