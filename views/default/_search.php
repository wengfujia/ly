<?php 
	
use yii\widgets\ActiveForm;
use app\components\helper\httpServices;
use app\components\coder\COMMANDID;

$coder = httpServices::post(COMMANDID::$RESOURCENAMELIST, 'guest', '1');
$names = $coder->getContent();
?>

<?php $form = ActiveForm::begin(['action' => ['house/search', 'commandid'=>COMMANDID::$RENTLIST],'method' => 'post' ]); ?>

<div class="selectInfo">
	<!-- 楼宇名称 -->
	<select class="txtSelect" id="buildingname" name="buildingname">
		<!-- onchange='ajaxGetArea(this)' -->
		<option value="0" selected="selected">楼宇名称</option>
		<?php
		foreach ( $names as $name ) {
			echo '<option value="' . $name['content'][0] . '">' . $name['content'][0] . '</option>';
		}
		?>
	</select>
	<!-- 楼层数 -->
	<!-- <select class="txtSelect" id="floornum" name="floornum">  
		  <option value="0" selected="selected">所属楼层</option>
		  <option value="2">绿茵园社区</option>
		  <option value="3">华达社区</option>
		  <option value="4">广德社区</option>
		</select> -->
	<!-- 所需面积 -->
	<select class="txtSelect" id="area" name="area">
		<option value="0" selected="selected">所需面积</option>
		<option value="1">100平方以下</option>
		<option value="2">100至200平方</option>
		<option value="3">200至300平方</option>
		<option value="4">300平方以上</option>
	</select>
	<!-- 物业费 -->
	<select class="txtSelect" id="services" name="services">
		<option value="0" selected="selected">物业费(月/平方)</option>
		<option value="1">1元以下</option>
		<option value="2">1至2元</option>
		<option value="3">2至3元</option>
		<option value="4">3元以上</option>
	</select>
	<!-- 特色楼宇 -->
	<!-- <select class="txtSelect">
		  <option value="0" selected="selected">特色楼宇</option>  
		  <option value="1">绿茵园社区</option>  
		  <option value="2">华达社区</option>  
		  <option value="3">广德社区</option>
		</select> -->
	<!-- 租金 -->
	<select class="txtSelect" id="rent" name="rent">
		<option value="0" selected="selected">租金(月)</option>
		<option value="1">2000元以下</option>
		<option value="2">2000至4000元</option>
		<option value="3">4000至6000元</option>
		<option value="4">6000元以上</option>
	</select>
	<button title="查询">查询</button>
</div>

<?php ActiveForm::end(); ?>

<!-- <script>
	function ajaxGetArea(obj) {
		alert(obj.value);
	}

</script> -->