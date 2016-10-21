<?php

use yii\widgets\ActiveForm;
use app\models\Post;
use yii\helpers\Url;
use app\components\helper\httpServices;
use app\components\coder\COMMANDID;
/* @var $this yii\web\View */

//获取楼宇列表
$coder = httpServices::post(COMMANDID::$HOUSINGPHOTOLIST, 'guest', '		');
$buildings = $coder->getContent();
?>

<?php echo $this->render('_search',['buildings'=>$buildings]);?>
<div class="notice">
	<div class="noticeCon" style="margin-bottom: 11px;">
		<div class="title clr">
			<h3 class="single">公 告</h3>
			<a href="<?= Url::to(['/post/list', 'title' => '公告']); ?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
		</div>
		<ul>
			<?php
			$posts = Post::getPostsByCategoryName('公告', 4, 0);
			foreach ( $posts as $post ) {
				echo '<li><a href="' . $post->url . '">' . $post->Title . '</a></li>';
			}
			?>
		</ul>
	</div>

	<div class="noticeCon">
		<div class="title clr">
			<h3 class="single">政策法规</h3>
			<a href="<?= Url::to(['/post/list', 'title' => '政策法规']); ?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
		</div>
		<ul>
			<?php
			$posts = Post::getPostsByCategoryName ('政策法规', 4, 0);
			foreach ( $posts as $post ) {
				echo '<li><a href="' . $post->url . '">' . $post->Title . '</a></li>';
			}
			?>
		</ul>
	</div>
</div>

<div class="picnews">
	<div id="myFocus">
		  <div class="pic">
			<ul>
				<?php
				$posts = Post::getPostsByCategoryName ('滚动新闻', 5, 0);
				foreach ( $posts as $post ) {
					echo '<li><a href="' . $post->url . '"><img src="' . $post->coverimage . '" thumb="" alt="' . $post->Title . '" text="' . $post->Title . '" /></a></li>';
				}
				?>
			</ul>
		  </div>
	</div>
</div>

<div class="trends">
	<div class="title clr">
		<h3 class="active">楼宇动态</h3>
		<a href="<?= Url::to(['/post/list', 'title' => '楼宇动态']); ?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
	</div>
	<ul>
		<?php
		$posts = Post::getPostsByCategoryName ('楼宇动态', 7, 0);
		foreach ( $posts as $post ) {
			echo '<li><a href="' . $post->url . '">' . $post->Title . '</a></li>';
		}
		?>
	</ul>
</div>

<div class="clear"></div>

<div class="banner"><a href="guide/index"><img src="css/img/banner.png"></a></div>

<div class="lyShow">
	<div class="title clr">
		<h3 class="single">展示楼宇</h3>
		<a href="<?= Url::to(['/building/index']); ?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
	</div>

 <div class="picMarquee-left">
	<div class="bd">
		<ul class="picList">
			<?php 
			foreach ($buildings as $content) {
				echo '<li><a href="'. Url::to(['/building/show', 'id' => $content['content'][0]]) .'"><img src="'.Url::base().$content['content'][2].'"></a><h4><a href="#">'.$content['content'][1].'</a></h4></li>';
			}
			?>
		</ul>
	</div>
</div>

<script id="jsID" type="text/javascript">
 // var ary = location.href.split("&");
jQuery(".picMarquee-left").slide( { mainCell:".bd ul",autoPlay:true,effect:"leftMarquee",vis:5,interTime:50,opp:false,pnLoop:true,trigger:"click",mouseOverStop:true });
</script>

</div>

<div class="bmService">
	<div class="title clr">
		<h3 class="single">便民服务</h3>
		<a href="<?= Url::to(['/post/list', 'title' => '便民服务']); ?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
	</div>
	<ul class="clr">
		<li><a href="http://map.baidu.com/?newmap=1&s=s%26wd%3D萧山地图%26c%3D2489&fr=alat0&from=alamap">萧山地图</a></li>
		<li><a href="http://www.weather.com.cn/html/weather/101210102.shtml">天气预报</a></li>
		<li><a href="http://www.xsbus.com/bus.asp">公交线路</a></li>
		<li><a href="http://www.ldbz.xs.zj.cn/xslss/wsbs/login.jsp">社会保险</a></li>
		<li><a href="http://tool.114la.com/live/phone/">常用号码</a></li>
		<li><a href="http://www.xswater.com/">停水公告</a></li>
		<li><a href="http://fc.zjol.com.cn/">浙江福彩</a></li>
		<li><a href="http://www.zjlottery.com/">浙江体彩</a></li>
		<li><a href="http://flight.qunar.com/status/alphlet_order.jsp?ex_track=bd_aladding_flightsk_title">民航航班</a></li>
		<li><a href="http://www.chinapost.com.cn/">邮编查询</a></li>
		<li><a href="http://kuaidichaxun.51240.com/">快递查询</a></li>
		<li><a href="http://chaxun.weizhang8.cn/">违章查询</a></li>
		<li><a href="http://220.191.210.68/hyyy/">婚姻登记</a></li>
		<li><a href="http://www.hao123.com/rili">万年日历</a></li>
	</ul>
</div>
<div class="lySource tabBlock">
	<div class="title clr tabNav">
		<h3 class="single">楼宇资源</h3>
		<span class="active">出租</span><span>出售</span>
	</div>
	<div class="tabShow">
		<table>
			<tr style="height: 38px">
				<th>楼宇名称</th>
				<th>所在楼层</th>
				<th>面积</th>
				<th>租金(平方/天/元)</th>
				<th>物业费(平方/月)</th>
				<th>联系电话</th>
			</tr>
			<?php
			$coder = httpServices::post(COMMANDID::$RENTLIST, 'guest', '		0	1	8');
			$items_array = $coder->getContent();
			for ($i = 0; $i < count($items_array); $i++) { 
				$content= $items_array[$i]['content'];
				if ($i==0) { //去掉第一个总记录数
					array_splice($content,0,1);
				}
				echo 
					'<tr>'.
						'<td>'.$content[2].'</td>'.
						'<td>'.$content[3].'</td>'.
						'<td>'.$content[4].'</td>'.
						'<td>'.$content[5].'</td>'.
						'<td>'.$content[6].'</td>'.
						'<td>'.$content[7].'</td>'.
					'</tr>';
			}
			?>
		</table>
		<a href="<?= Url::to(['/house/rent'])?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
	</div>
	<div class="tabShow" style="display: none">
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
			$coder = httpServices::post(COMMANDID::$SELLLIST, 'guest', '		0	1	8');
			$items_array = $coder->getContent();
			for ($i = 0; $i < count($items_array); $i++) { 
				$content= $items_array[$i]['content'];
				if ($i==0) { //去掉第一个总记录数
					array_splice($content,0,1);
				}
				echo 
					'<tr>'.
						'<td>'.$content[2].'</td>'.
						'<td>'.$content[3].'</td>'.
						'<td>'.$content[4].'</td>'.
						'<td>'.$content[5].'</td>'.
						'<td>'.$content[6].'</td>'.
						'<td>'.$content[7].'</td>'.
					'</tr>';
			}
			?>
		</table>
		<a href="<?= Url::to(['/house/sale'])?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
	</div>
</div>
<div class="clear"></div>
<div class="lyArea">
	<div class="title clr">
		<h3 class="single">楼宇社区</h3>
		<!-- <a href="#" class="more"><img src="css/img/more.png"></a> -->
	</div>
	<ul class="clr">
		<?php 
		$coder = httpServices::post(COMMANDID::$COMMUNITYPHOTOLIST, 'guest', '	a.SortNum');
		
		$items_array = $coder->getContent();
		foreach ($items_array as $content) {
			echo '<li><a href="'. Url::to(['/community/index', 'id' => $content['content'][0]]) .'"><img src="'.Url::base().$content['content'][2].'"></a><h4><a href="#">'.$content['content'][1].'</a></h4></li>';
		}
		?>
	</ul>
</div>

<div class="corp tabBlock">
	<div class="title clr tabNav">
		<span class="active">入驻企业</span><span>上市企业</span>		
	</div>
	<div class="tabShow">
		<ul style="padding-bottom:9px;">
			<?php
			$posts = Post::getPostsByCategoryName ('入驻企业', 10, 0);
			foreach ( $posts as $post ) {
				echo '<li><a href="' . $post->url . '">' . $post->Title . '</a></li>';
			}
			?>
		</ul>
		<a href="<?= Url::to(['/post/list', 'title' => '入驻企业']); ?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>		
	</div>
	<div class="tabShow" style="display: none">
		<ul style="padding-bottom:9px;">
			<?php
			$posts = Post::getPostsByCategoryName ('上市企业', 10, 0);
			foreach ( $posts as $post ) {
				echo '<li><a href="' . $post->url . '">' . $post->Title . '</a></li>';
			}
			?>
		</ul>
		<a href="<?= Url::to(['/post/list', 'title' => '上市企业']); ?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
	</div>
	<div class="searchCorp">
		<?php $form = ActiveForm::begin(['action' => ['company/index'],'method' => 'post' ]); ?>
			<input type="text" id='keyword' name='keyword' placeholder="请输入关键字">
			<button type="submit"><img src="css/img/search.png"></button>
		<?php ActiveForm::end(); ?>
	</div>
</div>

<div class="zpInfo">
	<div class="title clr">
		<h3 class="single">招聘信息</h3>
		<a href="<?= Url::to(['/post/list', 'title' => '招聘信息']); ?>" class="more"><img src="<?= Url::base() ?>/css/img/more.png"></a>
	</div>
	<ul>
		<?php
		$posts = Post::getPostsByCategoryName ('招聘信息', 9, 0);
		foreach ( $posts as $post ) {
			echo '<li><a href="' . $post->url . '">' . $post->Title . '</a></li>';
		}
		?>
	</ul>
</div>

<!-- 加载友情连接 -->
<?php echo $this->render("_link"); ?>