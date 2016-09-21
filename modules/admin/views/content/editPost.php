<?php
use yii\web\View;
/* @var View $this */
/* @var array $server */

$this->title = "修改文章页";
?>

<h2 class="catName">内容管理</h2>

<style>
	.txtIn span{
		width: 100px;
	}
	.txtS {
		width:30%
	}
	.txtM {
		width:30%
	}
	.txtSelect {
		width:30%
	}
</style>

<div data-ng-controller="EditPostController">
	<article class="txtIn">
		<span>所属栏目</span>
		<label data-ng-repeat="item in categories"><input type="checkbox" ng-checked="setChecked(item.CategoryID)" value="{{item.CategoryID}}" name="categories">{{item.CategoryName}}</label>
	</article>
	<article class="txtIn">
		<span>所属社区</span>
		<select class="txtSelect" id="selCommunity" data-ng-model="Post.CommunityID">  
			<option value="" selected="selected">请选择</option>
			<option data-ng-repeat="item in communityItems" value="{{item.content[0]}}">{{item.content[1]}}</option>
		</select>	
	</article>
	<article class="txtIn">
		<span>标题</span>
		<input type="text" class="txtS" data-ng-model="Post.Title">
	</article>
	<!-- <article class="txtIn">
		<span>缩略图</span>
		<input type="file" class="txtF">
	</article> -->
	<article class="txtIn">
		<span>来源</span>
		<input type="text" class="txtS" data-ng-model="Post.CopyFrom">
	</article>
	<article class="txtIn">
		<span>作者</span>
		<input type="text" class="txtS" data-ng-model="Post.Writer">
	</article>
	<article class="txtIn">
		<span>编辑</span>
		<input type="text" class="txtS" data-ng-model="Post.Editor">
	</article>
	<article class="txtIn">
		<span>外部链接</span>
		<input type="text" class="txtS" data-ng-model="Post.OutUrl">
	</article>
	<article class="txtIn">
		<span style="vertical-align: top">摘要</span>
		<textarea class="txtM" style=" height: 135px;" data-ng-model="Post.Description"></textarea>
	</article>
	<article class="txtIn">
		<span style="vertical-align: top">内容</span>		
		<!-- 加载编辑器的容器 -->
    	<script id="editor" type="text/plain" style="height: 300px; width: 90%"></script>
	</article>
	
	<h4 class="txtB" data-ng-click='save()'>保存</h4>
</div>
