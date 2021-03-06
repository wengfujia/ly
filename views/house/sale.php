<?php
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

use app\components\helper\httpServices;
use app\components\coder\COMMANDID;

/**
 * 出售展示页
 * @var View $this
 * @var ActiveDataProvider $companyProvider
 */
	//获取楼宇列表
	$coder = httpServices::post(COMMANDID::$HOUSINGPHOTOLIST, 'guest', '		');
	$buildings = $coder->getContent();
?>
<?php echo $this->render('../default/_search',['buildings'=>$buildings]);?>

<div class="navigate">您的位置：萧山区北干楼宇经济网&nbsp;&gt;&nbsp;楼宇资源（出售）</div>

<div class="listSource">
	<table>
		<tr style="height: 38px">
			<th>楼宇名称</th>
			<th>所在楼层</th>
			<th>面积</th>
			<th>售价(平方/元)</th>
			<th>物业费(平方/月)</th>
			<th>联系电话</th>
		</tr>
		<?php
			$first = true;
            $sales = $saleProvider->getModels();
            foreach ($sales as $sale) {
            	if (sizeof($sale['content'])<5) continue;
            	
            	if ($first) {
            		$first = false;
	            	echo 
	    				'<tr>'.
	    					'<td>'.$sale['content'][3].'</td>'.
	    					'<td>'.$sale['content'][4].'</td>'.
	    					'<td>'.$sale['content'][5].'</td>'.
	    					'<td>'.$sale['content'][6].'</td>'.
	    					'<td>'.$sale['content'][7].'</td>'.
	    					'<td>'.$sale['content'][8].'</td>'.
	    				'</tr>';
            	}
            	else {
            		echo
	            		'<tr>'.
	            		'<td>'.$sale['content'][2].'</td>'.
	            		'<td>'.$sale['content'][3].'</td>'.
	            		'<td>'.$sale['content'][4].'</td>'.
	            		'<td>'.$sale['content'][5].'</td>'.
	            		'<td>'.$sale['content'][6].'</td>'.
	            		'<td>'.$sale['content'][7].'</td>'.
	            		'</tr>';
            	}
            }
		?>
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
