<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/*
 * 楼宇资源查询
 * */
?>

<?php $form = ActiveForm::begin(['action' => ['building/search'], 'method'=>'post']); ?>

    <input type="hidden" id="title" name="title" value="<?= $title ?>">
	<input type="text" placeholder="请输入关键字" id="keywords" name="keywords">
	<button type="submit"><img src="<?= Url::base() ?>/css/img/search.png"></button>
	
<?php ActiveForm::end(); ?>