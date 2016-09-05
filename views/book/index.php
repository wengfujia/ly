<?php 
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*
 * 意见反馈
 * */
?>

<div class="biaodan">
	<?php $form = ActiveForm::begin(['action' => ['book/create'], 'method'=>'post']); ?>
	
    	<?= Html::activeTextInput($model,'title',['class'=>'txtS']); ?>
    	<?= Html::activeTextInput($model,'username',['class'=>'txtS']); ?>
    	<?= Html::activeTextInput($model,'contact',['class'=>'txtS']); ?>
    	<?= Html::activeTextInput($model,'qq',['class'=>'txtS']); ?>
    	<?= Html::activeTextarea($model,'content',['class'=>'txtM']); ?>
    	<?= Html::submitButton('保存', ['class' => 'txtB']) ?>
    	<?= Html::resetButton('重置', ['class' => 'txtB']) ?>
    	
    <?php ActiveForm::end(); ?>
</div>