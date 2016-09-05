<ul data-ng-controller='LayoutsController'>
	
	<li data-ng-if="checkPermission('ViewCommunities')"><span><a href="/admin/default/index#/community/cate1.0">社区管理</a></span>
		<ul class="childNode">
			<!-- <li><a href="#/community/cate1.1">社区所属楼宇</a></li> -->
		</ul>
	</li>
		
	<li data-ng-if="checkPermission('ViewBuildings')"><span><a href="/admin/default/index#/building/cate2.0">楼宇管理</a></span>
		<ul class="childNode">
			<li data-ng-if="checkPermission('AddBuilding')"><a href="/admin/default/index#/building/cate2.1">楼宇添加</a></li>
			<!-- <li><a href="cate2.2.html">楼宇基本信息修改</a></li>
			<li><a href="#/building/cate2.3">楼层信息管理</a></li> -->
			<li data-ng-if="checkPermission('EditBuilding')"><a href="/admin/default/index#/building/cate2.4">房间管理</a></li>
		</ul>
	</li>
	
	<li><span><a href="#/company/cate3.0">企业管理</a></span>
		<ul class="childNode">
			<li data-ng-if="checkPermission('AddCompany')"><a href="/admin/default/index#/company/cate3.1">企业入驻</a></li>
			<!-- <li><a href="cate3.2.html">企业信息修改</a></li> -->
			<li data-ng-if="checkPermission('LogoutCompany')"><a href="/admin/default/index#/company/cate3.2">企业注销</a></li>
		</ul>
	</li>
	
	<li><span><a href="">网站管理</a></span>
		<ul class="childNode">
			<li data-ng-if="checkPermission('AddPost')"><a href="/admin/default/index#/content/cate4.1">栏目管理</a></li>
			<li data-ng-if="checkPermission('AddPost')"><a href="/admin/default/index#/content/cate4.2">内容管理</a></li>
			<li data-ng-if="checkPermission('AddRent')"><a href="/admin/default/index#/content/cate4.3">楼宇出租</a></li>
			<li data-ng-if="checkPermission('AddSale')"><a href="/admin/default/index#/content/cate4.4">楼宇出售</a></li>
			<li><a href="#/content/cate4.5">意见反馈</a></li>
		</ul>
	</li>
	
	<li><span><a href="#/security/cate5.0">用户中心</a></span>
		<ul class="childNode">
			<li data-ng-if="checkPermission('ManageUser')"><a href="/admin/default/index#/security/cate5.1">用户管理</a></li>
			<li data-ng-if="checkPermission('ManageRole')"><a href="/admin/default/index#/security/cate5.2">角色管理</a></li>
			<li><a href="#/security/cate5.3">修改密码</a></li>
		</ul>
	</li>
	
</ul>
