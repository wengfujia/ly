<?php 
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*
 * 意见反馈
 * */
?>

<div class="biaodan">
	<?= Html::activeTextInput($model,'title',['class'=>'txtS']); ?>
    <?= Html::activeTextInput($model,'username',['class'=>'txtS']); ?>
    <?= Html::activeTextInput($model,'contact',['class'=>'txtS']); ?>
    <?= Html::activeTextInput($model,'qq',['class'=>'txtS']); ?>
    <?= Html::activeTextarea($model,'content',['class'=>'txtM']); ?>
    <script type="text/javascript">
		alert('反馈成功');
    </script>
</div>