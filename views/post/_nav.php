<?php 
	$categoryName = '';
	$title = '';
	if (isset($this->params['breadcrumbs'])) {
		$categoryName = $this->params['breadcrumbs'][0];
	}
	if (isset($this->params['breadcrumbs'][1])) {
		$title = $this->params['breadcrumbs'][1];
	}
?>
<div class="navigate">
	您的位置：萧山区北干楼宇经济网&nbsp;&gt;&nbsp;<?= $categoryName?>&nbsp;&gt;&nbsp;<?= $title?>
</div>