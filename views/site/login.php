<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */
$this->title = '登录';
$this->params['breadcrumbs'] = [$this->title];

?>

<?php $this->beginPage()?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <?php $this->head() ?>
    <!-- <script src='http://libs.baidu.com/jquery/1.9.1/jquery.min.js'></script> -->
	<script>
	    (function($) {
	        var settings = {
	            e: 'idcode',
	            codeType: {
	                name: 'follow',
	                len: 4
	            },
	            codeTip: '看不清，换一组',
	            inputID: ''
	        };
	
	        var _set = {
	            storeLable: 'codeval',
	            store: '#ehong-code-input',
	            codeval: '#ehong-code'
	        }
	        $.idcode = {
	            getCode: function(option) {
	                _commSetting(option);
	                return _storeData(_set.storeLable, null);
	            },
	            setCode: function(option) {
	                _commSetting(option);
	                _setCodeStyle("#" + settings.e, settings.codeType.name, settings.codeType.len);
	
	            },
	            validateCode: function(option) {
	                _commSetting(option);
	                var inputV;
	                if (settings.inputID) {
	                    inputV = $('#' + settings.inputID).val();
	                } else {
	                    inputV = $(_set.store).val();
	                }
	
	                if (inputV == _storeData(_set.storeLable, null)) {
	                    return true;
	                } else {
	                    _setCodeStyle("#" + settings.e, settings.codeType.name, settings.codeType.len);
	                    return false;
	                }
	            }
	        };
	
	        function _commSetting(option) {
	            $.extend(settings, option);
	        }
	
	        function _storeData(dataLabel, data) {
	            var store = $(_set.codeval).get(0);
	            if (data) {
	                $.data(store, dataLabel, data);
	            } else {
	                return $.data(store, dataLabel);
	            }
	        }
	
	        function _setCodeStyle(eid, codeType, codeLength) {
	            var codeObj = _createCode(settings.codeType.name, settings.codeType.len);
	            var randNum = Math.floor(Math.random() * 6);
	            var htmlCode = ''
	            if (!settings.inputID) {
	                htmlCode = '<span><input id="ehong-code-input" type="text" maxlength="4" /></span>';
	            }
	            htmlCode += '<div id="ehong-code" class="ehong-idcode-val ehong-idcode-val';
	            htmlCode += String(randNum);
	            htmlCode += '" href="#" onblur="return false" onfocus="return false" oncontextmenu="return false" onclick="$.idcode.setCode()">' + _setStyle(codeObj) + '</div>' + '<span id="ehong-code-tip-ck" class="ehong-code-val-tip" onclick="$.idcode.setCode()">' + settings.codeTip + '</span>';
	            $(eid).html(htmlCode);
	            _storeData(_set.storeLable, codeObj);
	        }
	
	        function _setStyle(codeObj) {
	            var fnCodeObj = new Array();
	            var col = new Array('#BF0C43', '#E69A2A', '#707F02', '#18975F', '#BC3087', '#73C841', '#780320', '#90719B', '#1F72D8', '#D6A03C', '#6B486E', '#243F5F', '#16BDB5');
	            var charIndex;
	            for (var i = 0; i < codeObj.length; i++) {
	                charIndex = Math.floor(Math.random() * col.length);
	                fnCodeObj.push('<font color="' + col[charIndex] + '">' + codeObj.charAt(i) + '</font>');
	            }
	            return fnCodeObj.join('');
	        }
	
	        function _createCode(codeType, codeLength) {
	            var codeObj;
	            if (codeType == 'follow') {
	                codeObj = _createCodeFollow(codeLength);
	            } else if (codeType == 'calc') {
	                codeObj = _createCodeCalc(codeLength);
	            } else {
	                codeObj = "";
	            }
	            return codeObj;
	        }
	
	        function _createCodeCalc(codeLength) {
	            var code1, code2, codeResult;
	            var selectChar = new Array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	            var charIndex;
	            for (var i = 0; i < codeLength; i++) {
	                charIndex = Math.floor(Math.random() * selectChar.length);
	                code1 += selectChar[charIndex];
	
	                charIndex = Math.floor(Math.random() * selectChar.length);
	                code2 += selectChar[charIndex];
	            }
	            return [parseInt(code1), parseInt(code2), parseInt(code1) + parseInt(code2)];
	        }
	
	        function _createCodeFollow(codeLength) {
	            var code = "";
	            var selectChar = new Array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	
	            for (var i = 0; i < codeLength; i++) {
	                var charIndex = Math.floor(Math.random() * selectChar.length);
	                if (charIndex % 2 == 0) {
	                    code += selectChar[charIndex].toLowerCase();
	                } else {
	                    code += selectChar[charIndex];
	                }
	            }
	            return code;
	        }
	
	    })(jQuery);
	
	    $(function() {
	        $.idcode.setCode();
	        $('#subMit').on('click', function() {	
	        	if($('#ehong-code-input').val() !== $('#ehong-code').text() || $('#userName').val() == '' || $('#checkPwd').val() == ''){
	                alert('输入有误')
	            } else {
	                alert('符合')
	            }
	        });
	        $('#clearAll').on('click', function() {
	        	$('#ehong-code-input').val('');
	        	$('#userName').val('');
	        	$('#checkPwd').val('');
	        });
	    })
	</script>

<style>
    /*reset*/
body, div, ul, ol, li, h1, h2, h3, h4, h5, h6, p, th, td, img {
  margin: 0;
  padding: 0;
  border: 0; }

table {
  border-collapse: collapse;
  border-spacing: 0; }

img {
  border: none;
  vertical-align: top; }

ul, li {
  list-style: none; }

h1, h2, h3, h4, h5, h6 {
  font-size: 100%;
  font-weight: normal;
  text-align: center; }

input, textarea, select {
  font-family: inherit;
  font-size: inherit;
  font-weight: inherit;
  *font-size: 100%; }

.clear {
  clear: both;
  height: 0;
  line-height: 0;
  font-size: 0;
  font-size: 0;
  overflow: hidden; }

.clr {
  zoom: 1; }

.clr:after {
  display: block;
  clear: both;
  height: 0;
  content: "\0020";
  overflow: hidden; }
    #ehong-code-input {
        width: 42px;
        letter-spacing: 2px;
        margin: 0px 8px 0px 0px;
    }
    
    .ehong-idcode-val {
        position: relative;
        padding: 1px 4px 1px 4px;
        top: 0px;
        *top: -3px;
        letter-spacing: 4px;
        display: inline;
        cursor: pointer;
        font-size: 16px;
        font-family: "Courier New", Courier, monospace;
        text-decoration: none;
        font-weight: bold;
    }
    
    .ehong-idcode-val0 {
        border: solid 1px #A4CDED;
        background-color: #ECFAFB;
    }
    
    .ehong-idcode-val1 {
        border: solid 1px #A4CDED;
        background-color: #FCEFCF;
    }
    
    .ehong-idcode-val2 {
        border: solid 1px #6C9;
        background-color: #D0F0DF;
    }
    
    .ehong-idcode-val3 {
        border: solid 1px #6C9;
        background-color: #DCDDD8;
    }
    
    .ehong-idcode-val4 {
        border: solid 1px #6C9;
        background-color: #F1DEFF;
    }
    
    .ehong-idcode-val5 {
        border: solid 1px #6C9;
        background-color: #ACE1F1;
    }
    
    .ehong-code-val-tip {
        font-size: 12px;
        color: #fff;
        top: 0px;
        *top: -3px;
        position: relative;
        margin: 0px 0px 0px 4px;
        cursor: pointer;
    }
    
    #login {
        width: 600px;
        min-height: 450px;
        overflow: hidden;
        margin: -200px 0 0 -300px;
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 999;
        background: #1098EC;
        border-radius: 10px;
        font: 16px/1.5 "Microsoft YaHei";
        color: #fff;
    }
    #login h2{
    	font-size: 36px;
		padding: 30px 0 50px;
    }
    .inputCon{
    	margin: 0 auto;
    	text-align: center;
    	padding: 10px;
    }
    .inputCon input{
    	width: 200px;
    	padding: 2px 5px;
    	border: 1px solid #ddd;
    }
    #idcode{
    }
    #btn{
    	text-align: center;
    	padding: 20px 0 0 0;
    }
    #btn input{
		width: 88px;
		height: 44px;
		background: none;
		border: none;
		background: #0789ab;
		border: 1px solid #fff;
		color: #fff;
    }
    .button {
    	width: 88px;
	    height: 44px;
	    background: none;
	    border: none;
	    background: #0789ab;
	    border: 1px solid #fff;
	    color: #fff;
    }
    </style>
	
</head>

<body>
<?php $this->beginBody()?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div id="login">
    	<h2>楼宇信息管理平台</h2>
        <!-- <div class="inputCon">用户名　
            <input type="text" id="userName">
        </div>
        <div class="inputCon">密　码　
            <input type="text" id="checkPwd">
        </div>
        <div id="idcode" class="inputCon">验证码</div> -->
        
        <div class="inputCon">
            <?= $form->field($model, 'username')->textInput(['placeholder' => '用户名', 'tabindex' => '1']); ?>
        </div>
        <div class="inputCon">
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码', 'tabindex' => '2'])->label('密　码') ?>
        </div>
        <div class="inputCon">
        	<?= $form->field($model,'captcha')->widget(yii\captcha\Captcha::className(),
				['options' => ['tabindex' => '3', 'style'=>'width: 118px;'],
				'imageOptions'=>['alt'=>'点击换图','title'=>'点击换图', 'style'=>'cursor:pointer']]);?>       	
        </div>
        <div style="text-align: center;">
        	<?= $form->field($model, 'rememberMe')->checkbox(['class' => 'inputCon', 'tabIndex' => 4]) ?>
        </div>

        <div class="clear"></div>
        <div id="btn">
         	<?= Html::submitButton('登录', ['tabIndex' => 5, 'id' => 'login-button', 'class' => 'button']) ?>
			<?= Html::resetButton('重置', ['tabIndex' => 6, 'id' => 'reset-button', 'class' => 'button']) ?>
            <!-- <input type="button" id="subMit" value="登录">　
            <input type="button" id="clearAll" value="清空"> -->
        </div>
        <div id="errorMsg"></div>
        
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger col-md-offset-1 col-md-3']); ?>
        <?php
		$message = Yii::$app->session->getFlash('RegOption');
		if($message && empty($model->errors))
		    echo '<div id="errorMsg">', $message, '</div>';
		
		 ?>
    </div>

<?php ActiveForm::end(); ?>

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage() ?>