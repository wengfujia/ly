<?php
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/**
 * 出售展示页
 * @var View $this
 * @var ActiveDataProvider $companyProvider
 */

?>

<div class="navigate">您的位置：萧山区北干楼宇经济网&nbsp;&gt;&nbsp;楼宇资源（出售）</div>

<div class="listSource">
	<table>
		<tr style="height: 38px">
			<th>楼宇名称</th>
			<th>层数</th>
			<th>面积</th>
			<th>售价</th>
			<th>物业费</th>
		</tr>
		<tr>
			<?php
            $sales = $saleProvider->getModels();
            foreach ($sales as $sale) {
            	if (sizeof($sale['content'])<5) continue;
            	
            	echo 
    				'<tr>'.
    					'<td>'.$sale['content'][2].'</td>'.
    					'<td>'.$sale['content'][3].'</td>'.
    					'<td>'.$sale['content'][4].'</td>'.
    					'<td>'.$sale['content'][5].'</td>'.
    					'<td>'.$sale['content'][6].'</td>'.
    				'</tr>';
            }
            ?>
		</tr>
	</table>

	<div class="page">
		<?= LinkPager::widget([
			'pagination' => $saleProvider->pagination,
		    'nextPageLabel' => '下一页',
		    'prevPageLabel' => '上一页',
		    'firstPageLabel' => '首页',
		    'lastPageLabel' => '末页',
		]);?>
	</div>
</div>
