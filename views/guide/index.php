<?php ?>

<div class="ZhaoShang clr" style="padding-bottom: 30px;">
	<div class="tabNav">
		<h5 class='clr'>办事服务大厅</h5>
		<span class="active">党员服务中心</span> <span>计生服务</span> <span>劳动保障监察</span>
		<span>民政与社区</span> <span>卫生服务</span> <span>有线电视</span> <span>地税服务</span>
		<span>国税服务</span> <span>城建土管</span> <span>招投标中心</span>
	</div>
	<style>
		.tabShow p a span {
			color: #ff8878;
			padding: 0 5px;
		}
		
		.tabShow p a {
			padding-left: 30px;
		}
		
		.tabShow p {
			font-family: "Microsoft Yahei";
			padding-top: 10px;
			height: 49px;
			line-height: 49px;
			font-size: 18px;
		}
	</style>
	<div class="tabShow">
		<h5 class='clr'>
			<div class="navigate"
				style="width: 400px; text-align: right; padding-right: 20px; font-size: 14px;">当前位置：首页&nbsp;&gt;&nbsp;办事服务大厅</div>
		</h5>
		<p>
			<a href="/post/view?id=be1d61b8-22b4-3df7-b4cd-27392f6f1483"><span>&gt;&gt;</span>服务办理指南</a> <a href="/post/view?id=84f666e3-95e9-3105-98e6-787c7de65519"><span>&gt;&gt;</span>党员服务中心窗口流程图</a>
		</p>
		<p>
			<a href="/post/view?id=9029b3d9-a170-3705-aa91-a70c7513e50a"><span>&gt;&gt;</span>服务办理指南</a> <a href="/post/view?id=442bc128-8016-3c9c-ad1a-c9e4cdc9eff9"><span>&gt;&gt;</span>计划生育各类证明（证件）办理流程图</a>
		</p>
		<p>
			<a href="/post/view?id=264262fe-844b-32e1-89da-3ba3e7fd6958"><span>&gt;&gt;</span>受理条件及程序</a> <a href="/post/view?id=90254a2b-7e2c-3b4f-80f3-f28db3f7f397"><span>&gt;&gt;</span>劳动保障监察服务窗口流程图</a>
		</p>
		<p>
			<a href="/post/view?id=b5865d6b-0812-3fc3-a281-288785a3647e"><span>&gt;&gt;</span>服务办理程序</a> <a href="/post/view?id=a01b6f1e-05c6-3e44-bf6a-6fe574558b76"><span>&gt;&gt;</span>民政与社区服务窗口流程图</a>
		</p>
		<p>
			<a href="/post/view?id=5cca62ab-f93c-3398-81e9-f7502d057f23"><span>&gt;&gt;</span>卫生服务内容</a> <a href="/post/view?id=d920440c-0b1c-39ca-8bf6-17f9c02ade0e"><span>&gt;&gt;</span>卫生服务窗口流程图</a>
		</p>
		<p>
			<a href="/post/view?id=96c8922a-0cb7-31c5-8e54-174e29f5951b"><span>&gt;&gt;</span>服务办理指南</a> <a href="/post/view?id=e478f78c-7085-340a-b192-9df702f892a9"><span>&gt;&gt;</span>有线电视窗口服务流程图</a>
		</p>
		<p>
			<a href="/post/view?id=05105df7-3c3c-3e65-9e95-06a78c17ae20"><span>&gt;&gt;</span>服务办理要求</a> <a href="/post/view?id=1f36250c-9fbd-3cb1-9ca0-f0c76e39e95c"><span>&gt;&gt;</span>地税服务窗口业务流程图</a>
		</p>
		<p>
			<a href="/post/view?id=3fb50ef4-4083-35a0-be36-680a9b132491"><span>&gt;&gt;</span>服务办理指南</a> <a href="/post/view?id=c36bd44d-e6a3-3524-96f8-4fec04ba9c35"><span>&gt;&gt;</span>国税服务窗口流程图</a>
		</p>
		<p>
			<a href="/post/view?id=ef400e5b-5b70-3f2b-a080-c59742ef1776"><span>&gt;&gt;</span>服务办理指南</a> <a href="/post/view?id=7f19200c-58a6-3203-88ad-ae20020431d8"><span>&gt;&gt;</span>城建土管窗口服务流程图</a>
		</p>
		<p>
			<a href="/post/view?id=b7499c0b-5aae-3c77-ba81-db2d9b8dfc44"><span>&gt;&gt;</span>服务办理指南</a> <a href="/post/view?id=fa463275-218a-3e2b-a18c-01e12a7f2b45"><span>&gt;&gt;</span>招投标受理窗口流程图</a>
		</p>
	</div>
</div>

<script>
    $(function() {
        console.log($('.tabNav span').eq(1).text());
        $('.tabShow').find('p').eq(0).css('font-weight', 'bold');
        $('.tabNav span').on('mouseover', function() {
            var index = $(this).index();
            console.log(index);
            $('.tabShow p').eq(index-1).css('font-weight', 'bold').siblings().css('font-weight', '');
        });
    });
</script>