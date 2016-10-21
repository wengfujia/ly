<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

/*
 * 首页布局
 * */
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>北干楼宇网</title>
	<?php $this->head() ?>
	<link rel="stylesheet" href="<?= Url::base() ?>/css/main.css">
	<script type="text/javascript" src="<?= Url::base() ?>/assets/js/lib/jQuery.js"></script>
	<script type="text/javascript" src="<?= Url::base() ?>/assets/js/jquery.SuperSlide.2.1.1.js"></script>	
</head>
<body>
	<div class="main">
		<div class="topInfo">
			<span>2016年7月27日 星期日</span>
			<span>设为首页</span>
			<span>加入收藏</span>
		</div>
		<div class="logo">
			<h1>萧山区北干楼宇经济网</h1>
		</div>
		<div class="topNav">
			<a href="<?= Url::base(true) ?>" class="active">首页</a><span>|</span><a href="<?= Url::to(['/post/list', 'title' => '楼宇动态']); ?>">楼宇动态</a><span>|</span><a href="<?= Url::to(['/post/list', 'title' => '政策法规']); ?>">政策法规</a><span>|</span><a href="<?= Url::to(['/building/index']); ?>">招商引资</a><span>|</span><a href="<?= Url::to(['/building/index']); ?>">楼宇资源</a><span>|</span><a href="<?= Url::to(['/guide/index']); ?>">服务办理</a><span>|</span><a href="<?= Url::to(['/post/list', 'title' => '便民服务']); ?>">便民服务</a><span>|</span><a href="<?= Url::to(['/post/list', 'title' => '招聘信息']); ?>">招聘信息</a><span>|</span><a href="<?= Url::to(['/book/index']); ?>">意见箱</a>
		</div>
		<div class="nbsp"></div>
		<!-- 内容加载 -->
		<?= $content ?>	
	</div>

	<div class="footer">
		<a href="<?= Url::base(true) ?>">首页</a><span>-</span><a href="<?= Url::to(['/post/list', 'title' => '楼宇动态']); ?>">楼宇动态</a><span>-</span><a href="<?= Url::to(['/post/list', 'title' => '政策法规']); ?>">政策法规</a><span>-</span><a href="<?= Url::to(['/building/index']); ?>">招商引资</a><span>-</span><a href="<?= Url::to(['/building/index']); ?>">楼宇资源</a><span>-</span><a href="<?= Url::to(['/guide/index']); ?>">服务办理</a><span>-</span><a href="<?= Url::to(['/post/list', 'title' => '便民服务']); ?>">便民服务</a><span>-</span><a href="<?= Url::to(['/post/list', 'title' => '招聘信息']); ?>">招聘信息</a><span>-</span><a href="<?= Url::to(['/book/index']); ?>">意见箱</a>
		<p>Copyright&nbsp;&nbsp;&copy;1998-2016&nbsp;All Rights Reserved</p>
		<p>北干街道 &nbsp;招商办电话：83733385，82733383</p>
		<p>浙ICP备14000393号</p>
	</div>
	<!-- 新添加 -->
    <style>
    #downBtn {
        position: fixed;
        z-index: 99;
        right: 10px;
        bottom: 10px;
        width: 35px;
        height: 165px;
        font-size: 18px;
        line-height: 20px;
        color: #fff;
        font-family: 'Microsoft Yahei';
    }
    
    #toTop,
    #weiXin {
        height: 69px;
        background: #ff7676;
        padding-left: 8px;
        padding-top: 11px;
        cursor: pointer;
    }
    
    #weiXin {
        background: #99c0ff;
        margin-top: 5px;
        position: relative;
    }
    
    #erWei {
        width: 150px;
        height: 150px;
        overflow: hidden;
        position: absolute;
        /*-webkit-transform: all .5s;*/
        background: #eee;
        display: none;
        left: -155px;
        bottom: 0;
    }
    </style>
    <script>
    $(function() {
        $('#weiXin').hover(function() {
            $('#erWei').show();
        }, function() {
            $('#erWei').hide();
        })
        $('#toTop').on('click', function() {
            $('body').stop().animate({
                scrollTop: 0
            }, 1000);
        })
    })
    </script>
    <div id="downBtn">
        <div id="toTop">回
            <br>顶
            <br>部</div>
        <div id="weiXin">加
            <br>微
            <br>信
            <div id="erWei"><img src="<?= Url::base() ?>/css/img/bg2w.png"></div>
        </div>
    </div>
</body>

<script type="text/javascript" src="<?= Url::base() ?>/assets/js/bglySite.js"></script>
<script src="<?= Url::base() ?>/assets/js/myfocus-2.0.4.min.js"></script>
<script type="text/javascript">
myFocus.set({
	id:'myFocus',//id
	pattern:'mF_YSlider'//style
});
</script>
</html>