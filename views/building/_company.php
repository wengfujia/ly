<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<h5 class='clr'>企业资源
	<div class="navigate">当前位置：首页&nbsp;&gt;&nbsp;招商资源&nbsp;&gt;&nbsp;企业资源</div>
	<div class="search">
		<?php echo $this->render('_search',['title'=>'企业资源']); ?>
	</div>
</h5>

<ul class="clr">
<?php
$i = 1;
$companies = $companyProvider->getModels();
foreach ($companies as $company) {
	if ($i == 1) {
		echo '<li style="margin-left: 0"><a href="'.$company->url.'"><img src="'.$company.coverimage.'"></a><h4><a href="'.$company->url.'">'.$company->Title.'</a></h4></li>';
	}
	else {
		echo '<li><a href="'.$company->url.'"><img src="'.$company.coverimage.'"></a><h4><a href="'.$company->url.'">'.$company->Title.'</a></h4></li>';
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
		'pagination' => $companyProvider->pagination,
	    'nextPageLabel' => '下一页',
	    'prevPageLabel' => '上一页',
	    'firstPageLabel' => '首页',
	    'lastPageLabel' => '末页',
	]);?>
</div>
