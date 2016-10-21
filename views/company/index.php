<?php
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/**
 * 入驻企业查询结果页
 * @var View $this
 * @var ActiveDataProvider $companyProvider
 */
?>

<div class="navigate">您的位置：萧山区北干楼宇经济网&nbsp;&gt;&nbsp;入驻企业</div>

<div class="listSource">
	<table>
		<tr style="height: 38px">
			<th>企业名</th>
			<th>地址</th>
			<th>行政电话</th>
		</tr>
		<?php
		$first = true;
        $companies = $companyProvider->getModels();
      
        foreach ($companies as $company) {
        	if (sizeof($company['content'])<5) continue;
        	if ($first) {
        		$first = false;
        		echo
	        		'<tr>'.
	        		'<td>'.$company['content'][2].'</td>'.
	        		'<td>'.$company['content'][4].'</td>'.	        		
	        		'<td>'.$company['content'][5].'</td>'.
	        		'</tr>';
        	}
        	else {
        		echo
	        		'<tr>'.
	        		'<td>'.$company['content'][1].'</td>'.
	        		'<td>'.$company['content'][3].'</td>'.
	        		'<td>'.$company['content'][4].'</td>'.
	        		'</tr>';
        	}
        }
        ?>
	</table>

	<div class="page">
		<?= LinkPager::widget([
    		'pagination' => $companyProvider->pagination,
    	    'nextPageLabel' => '下一页',
    	    'prevPageLabel' => '上一页',
    	    'firstPageLabel' => '首页',
    	    'lastPageLabel' => '末页',
    	]);?>
	</div>
</div>
