<?php 

$title = '楼宇资源';
if (isset($this->params['breadcrumbs'])) {
	$title = $this->params['breadcrumbs'][0];
}

?>
<div class="ZhaoShang tabBlock">
	<div class="tabNav">
		<h5 class='clr'>招商资源</h5>
		<span <?= $title=='楼宇资源'? 'class="active"':''; ?>>楼宇资源</span>
		<span <?= $title=='地块资源'? 'class="active"':''; ?>>地块资源</span>
		<span <?= $title=='园区资源'? 'class="active"':''; ?>>园区资源</span>
		<span <?= $title=='企业资源'? 'class="active"':''; ?>>企业资源</span>
	</div>
	<div class="tabShow" <?= $title=='楼宇资源'? 'style="display: block;"':'style="display: none;"'; ?>>
		<!-- 楼宇资源 -->
		<?php echo $this->render('_building',['buildingProvider'=>$buildingProvider]); ?>
	</div>
	<!-- <script>
		$(function(){
			$('.tabShow').hide().eq(0).show();
		})
	</script> -->
	<div class="tabShow" <?= $title=='地块资源'? 'style="display: block;"':'style="display: none;"'; ?>>
		<!-- 地块资源 -->
		<?php echo $this->render('_land',['landProvider'=>$landProvider]); ?>
	</div>

	<div class="tabShow" <?= $title=='园区资源'? 'style="display: block;"':'style="display: none;"'; ?>>
		<!-- 园区资源 -->
		<?php echo $this->render('_park',['parkProvider'=>$parkProvider]); ?>
	</div>

	<div class="tabShow" <?= $title=='企业资源'? 'style="display: block;"':'style="display: none;"'; ?>>
		<!-- 企业资源 -->
		<?php echo $this->render('_company',['companyProvider'=>$companyProvider]); ?>
	</div>
</div>