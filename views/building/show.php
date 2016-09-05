<?php
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/**
 * 楼宇展示页
 * @var View $this
 * @var ActiveDataProvider $companyProvider
 */

//分解坐标点
if (!empty($building[12])) {
	$p = substr($building[12], 6, strlen($building[12])-7);
	$point = explode(' ', $p);	
}
else {
	$point = array();
	$point[] = 120.272067;
	$point[] = 30.180286;
}
?>

<script src="http://cache.amap.com/lbs/static/es5.min.js"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=0143bfe638be12058fe7487b172b4917&plugin=AMap.Geocoder"></script>
<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
<style>
    #container {
		position: relative;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		height: 400px;
	}
</style>
    
<div class="navigate">
	您的位置：萧山区北干楼宇经济网&nbsp;&gt;&nbsp;楼宇展示
</div>

<div class="lyzs clr">
	<div class="qyName">
		<ul>
			<?php 
			$companies = $companyProvider->getModels();
			foreach ($companies as $company) {
				echo '<li>'.
					'<h2>'.$company['content'][1].'</h2>'.
					'<h4>电话：'.$company['content'][2].'</h4>'.
					'<h4>地址：'.$company['content'][3].'</h4>'.
				'</li>';
			}		
			?>
		</ul>
	</div>
	<div class="page">
		<?= LinkPager::widget([
			'pagination' => $companyProvider->pagination,
		    'nextPageLabel' => '下一页',
		    'prevPageLabel' => '上一页',
		    'firstPageLabel' => '首页',
		    'lastPageLabel' => '末页',
		]);?>
	</div>

	<div class="qyResume">
		<img alt="" src="<?= $building[30]?>">
		<h2><?= $building[2]?></h2>
		<span class="resume"><?= $building[13]?></span>
	</div>

	<div class="qyMap">
		<h4>楼宇位置</h4>
		<div class="mapCon"><div id="container"></div></div>
	</div>
</div>

<script>
    var map = new AMap.Map('container', {
        resizeEnable: true,
        zoom:16,
        center: [120.272067, 30.180286]        
    });

    var marker = null; 
    // 实例化点标记
    function addMarker() {
        if (marker) {
            return;
        }
        marker = new AMap.Marker({
            icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
            position: [<?=$point[0] ?>, <?=$point[1] ?>]
        });
        marker.setMap(map);
    }
    addMarker();
</script>
