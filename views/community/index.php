<?php

use yii\helpers\Url;
use yii\web\View;
use app\models\Post;

/**
 * @var yii\web\View $this
 * @var app\models\Post[] $posts
 * @var array $community
 */

$css ='sq1';
if (strpos($community[1], '绿意')!== false)
	$css ='sq1';
else if (strpos($community[1], '蓝苑')!== false)
	$css ='sq2';
else if (strpos($community[1], '瑞商')!== false)
	$css ='sq3';
else if (strpos($community[1], '太汇')!== false)
	$css ='sq4';
else if (strpos($community[1], '金城')!== false)
	$css ='sq5';
?>
	<div class="newsWrap">
		<div class="shequPics">
			<div id="SQmyFocus">
				<div class="pic">
					<ul>
						<?php 
							$cposts = Post::getPostsByCommunity('滚动新闻', $community[0]);
							foreach ( $cposts as $post ) {
								echo '<li><a href="' . $post->url . '"><img src="' . $post->coverimage . '" thumb="" alt="' . $post->Title . '" text="' . $post->Title . '" /></a></li>';
							}
						?>
						<!-- <li><a href=""><img src="<?= Url::base().$community[8] ?>" thumb="" alt="<?= $community[1] ?>" text="<?= $community[1] ?>" /></a></li> -->
					</ul>
				</div>
          	</div>
		</div>
		<div class="shequNews">
			<div class="title" style="background: url(<?= Url::base() ?>/css/img/<?=$css ?>/shequNews.png)"><a href="<?= Url::to(['/post/community', 'id' => $community[0]]); ?>">社区新闻</a></div>
			<ul>
				<?php
				foreach ( $posts as $post ) {
					echo '<li><a href="' . $post->url . '">' . $post->Title . '</a></li>';
				}
				?>				
			</ul>
			<a href="<?= Url::to(['/post/community', 'id' => $community[0]]); ?>" class="more">更多新闻&gt;&gt;</a>
		</div>
		<div class="shequInfo">
			<div class="title"><img src="<?= Url::base() ?>/css/img/shequInfo.png"></div>
			<div class="infoCon"><?= $community[7] ?></div>
			<a href="http://www.bglyjj.com/post/view?id=78c118d8-e8b4-3b02-a770-82bc8b196042"><img src="<?= Url::base() ?>/css/img/service1.png" class="serviceIcons"></a>
			<a href="http://www.bglyjj.com/post/view?id=54ca7486-675f-3d68-b3d8-6d06948cb60e"><img src="<?= Url::base() ?>/css/img/service2.png" class="serviceIcons"></a>
			<a href="http://www.bglyjj.com/post/view?id=ebfd2cb9-ef0d-3209-baa3-8688e800c953"><img src="<?= Url::base() ?>/css/img/service3.png" class="serviceIcons"></a>
		</div>
	</div>

	<div class="title"><img src="<?= Url::base() ?>/css/img/<?=$css ?>/b1.png"></div><!-- <a href="<?= Url::to(['/building/search', 'CommunityID' => $community[0]]); ?>"> </a>-->
	<div class="shequBelongs">
		<div class="picMarquee-left">
			<a class="next"></a>
			<a class="prev"></a>
			<div class="bd">
			<!-- 显示楼宇列表 -->
				<ul>
					<?php 
					foreach ($buildings as $building) {
						echo '<li><a href="'.Url::to(['/building/show', 'id' => $building['content'][0]]).'"><img src="'.Url::base().$building['content'][2].'"></a>'.$building['content'][1].'</li>';
					}
					?>
                    <!-- <li><a href="#"><img src="style/img/demo.gif"></a></li>
                    <li><a href="#"><img src="style/img/demo.gif"></a></li>
                    <li><a href="#"><img src="style/img/demo.gif"></a></li>
                    <li><a href="#"><img src="style/img/demo.gif"></a></li>
                    <li><a href="#"><img src="style/img/demo.gif"></a></li>
                    <li><a href="#"><img src="style/img/demo.gif"></a></li>
                    <li><a href="#"><img src="style/img/demo.gif"></a></li> -->
				</ul>
			</div>
		</div>

		<script id="jsID" type="text/javascript">
		 // var ary = location.href.split("&");
		jQuery(".picMarquee-left").slide( { mainCell:".bd ul",autoPlay:true,effect:"leftMarquee",vis:5,interTime:50,opp:false,pnLoop:true,trigger:"click",mouseOverStop:true });
		</script>

	</div>

	<div class="title"><a href="#"><img src="<?= Url::base() ?>/css/img/<?=$css ?>/b2.png"></a></div>
	<div class="shequCity">
		<a href=""><img src="<?= Url::base() ?>/css/img/<?=$css ?>/banner.jpg"></a>
	</div>

	<div class="shequContact">
		<div class="noth" style="left:0px"><img src="<?= Url::base() ?>/css/img/n1.gif"></div>
		<div class="noth" style="left: 260px"><img src="<?= Url::base() ?>/css/img/n2.gif"></div>
		<div class="noth" style="left: 520px"><img src="<?= Url::base() ?>/css/img/n3.gif"></div>


		<div class="info"><span>联系人</span><br><?= $community[3] ?></div>
		<div class="info"><span>联系方式</span><br><?= $community[4] ?></div>
		<div class="info" style="width: 360px"><span>联系地址</span><br><?= $community[6] ?></div>
	</div>