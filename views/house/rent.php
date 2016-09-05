<?php
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/**
 * 出租展示页
 * @var View $this
 * @var ActiveDataProvider $companyProvider
 */

?>

<div class="navigate">您的位置：萧山区北干楼宇经济网&nbsp;&gt;&nbsp;楼宇资源（出租）</div>

<div class="listSource">
	<table>
		<tr style="height: 38px">
			<th>楼宇名称</th>
			<th>层数</th>
			<th>面积</th>
			<th>租金</th>
			<th>物业费</th>
		</tr>
		<?php
        $i = 1;
        $rents = $rentProvider->getModels();
        foreach ($rents as $rent) {
        	if (sizeof($rent['content'])<5) continue;
        	
        	echo 
				'<tr>'.
					'<td>'.$rent['content'][2].'</td>'.
					'<td>'.$rent['content'][3].'</td>'.
					'<td>'.$rent['content'][4].'</td>'.
					'<td>'.$rent['content'][5].'</td>'.
					'<td>'.$rent['content'][6].'</td>'.
				'</tr>';
        }
        ?>
	</table>

	<div class="page">
		<?= LinkPager::widget([
    		'pagination' => $rentProvider->pagination,
    	    'nextPageLabel' => '下一页',
    	    'prevPageLabel' => '上一页',
    	    'firstPageLabel' => '首页',
    	    'lastPageLabel' => '末页',
    	]);?>
	</div>
</div>
