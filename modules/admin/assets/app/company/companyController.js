/**
 * 企业管理控制器
 */
angular.module('blogAdmin').controller('CompanyController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.id = '';
	$scope.body = '';
	$scope.isEditItem = false;
	
	$scope.communityid = '';
	$scope.buildingid = '';
	$scope.floornum = '';
	$scope.roomid = '';
	
	$scope.floorItems = [];
	
	//企业信息字段
	//1.
	$scope.companyname = ''; //企业名称
	$scope.companyregstatus = 0;//企业是否注册
	$scope.companyregcapital = 0;//注册资金（万元）
	$scope.injectionname = '';//注册法人
	$scope.injectionpeoplecode = '';//法人身份证号
	$scope.companynature = '';//单位性质
	$scope.companyregnum = '';//企业注册号
	$scope.companymergenum = '';//五证合一号
	$scope.companyisscale = 0;//规上企业
	
	//2.
	$scope.companymainbusiness = ''; //主营业务
	$scope.companyindustry = '';//行业类别
	$scope.companyoperationform = '';//经营形式
	$scope.companyoperationstatus = '';//经营状态
	$scope.companysales = 0;//销售额（或营业额）（万元）
	$scope.companylastyeartax = 0;//企业上年税收（万元）
	$scope.companyincrements = 0;//增加值
	$scope.companyinvestment = 1;//招商引资
	
	//3.
	$scope.injectionphone = ''; //法人联系电话
	$scope.injectiontax = ''; //法人传真
	$scope.managername = '';//行政负责人
	$scope.managerphone = '';//行政联系电话
	$scope.managerqq = '';//行政QQ
	$scope.financername = '';//财务姓名
	$scope.financerphone = '';//财务联系电话
	$scope.financerqq = '';//财务QQ
	$scope.employees = 0;//员工总数
	$scope.womens = 0;//女职工数
	$scope.yongers = 0;//青年职工数（28周岁以下）
	$scope.minds = 0;//海归、港澳台人员
	$scope.partymembers = 0;//党员数
	$scope.partyname = '';//党组织名称
	$scope.partymanagername = '';//党组织书记
	$scope.partymanagerphone = '';//党组织书记联系电话
	$scope.partymanagerqq = '';//党组织书记QQ
	$scope.tradeunions = 0;//工会数
	
	//4.
	$scope.oldaddress = ''; //入驻前所在地
	$scope.datelogin = '';//入驻时间
	$scope.roomaddress = '';//入驻地址
	$scope.roomarea = '';//入驻面积（m2）
	
	//企业注销字段
	$scope.datelogout = (new Date()).Format('yyyy-MM-dd hh:mm:ss');//注销时间
	$scope.logoutreason = 1;//注销原因
	$scope.ischangeaddress = 1;	//注销后注册地址是否变更
	$scope.newaddress = '';		//注销后新注册地
	$scope.logoutlinkname = '';	//注销后联系人
	$scope.logoutlinkphone = '';//注销后联系电话
	$scope.logoutmemo = '';		//备注
	$scope.logoutchkdesc = '';  //审核意见
	
	//初始化后台站点控制器
	SiteInit($rootScope, $scope, dataService);
	
	//加载社区信息
	$scope.loadCommunities('', '');	
	
	//加载列表数据
	$scope.load = function () {
		var p = { username: session.getItem("uername"), body: $scope.body+'\t'+Settings.communityid+'\t'+ $scope.orderBy+'\t'+$scope.recordCount+'\t'+$scope.currentPage };
        dataService.getItems('admin/company/list', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$scope.setPagedItems(data);
            	}
            	else if (data.data) {
            		toastr.error('获取企业列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取企业列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取企业列表出错');
            });
	}
	
	//初始化分页控件
	pageInit($scope, $filter);
	
	$(document).ready(function () {

	});
	
	/*
	 * 信息操作
	 * */
	
	//获取企业详情
	$scope.get = function () {
		var p = { username: session.getItem("uername"), body: $scope.id };
        dataService.getItems('admin/company/get', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$scope.roomid = data.data[0].content[1];
                	$scope.companyname = data.data[0].content[2];
                	$scope.companyregstatus = data.data[0].content[3];
                	$scope.employees = data.data[0].content[4];
                	$scope.companyregcapital = data.data[0].content[5];
    				$scope.companynature = data.data[0].content[6];
    				$scope.companyregnum = data.data[0].content[7];   				
    				$scope.companymergenum = data.data[0].content[8];
    				$scope.companyisscale = data.data[0].content[9]; 				
    				$scope.companymainbusiness = data.data[0].content[10];
    				$scope.companyindustry = data.data[0].content[11];
    				$scope.companyoperationform = data.data[0].content[12];
    				$scope.companyoperationstatus = data.data[0].content[13];
    				$scope.companysales = data.data[0].content[14];
    				$scope.companylastyeartax = data.data[0].content[15];
    				$scope.companyincrements = data.data[0].content[16];
    				$scope.companyinvestment = data.data[0].content[17];
    				$scope.injectionname = data.data[0].content[18];
    				$scope.injectionpeoplecode = data.data[0].content[19];
    				$scope.injectionphone = data.data[0].content[20];
    				$scope.injectiontax = data.data[0].content[21];
    				$scope.managername = data.data[0].content[22];
    				$scope.managerphone = data.data[0].content[23];
    				$scope.managerqq = data.data[0].content[24];
    				$scope.financername = data.data[0].content[25];
    				$scope.financerphone = data.data[0].content[26];
    				$scope.financerqq = data.data[0].content[27];
    				$scope.womens = data.data[0].content[28];
    				$scope.yongers = data.data[0].content[29];
    				$scope.minds = data.data[0].content[30];
    				$scope.partymembers = data.data[0].content[31];
    				$scope.tradeunions = data.data[0].content[32];
    				$scope.partyname = data.data[0].content[33];
    				$scope.partymanagername = data.data[0].content[34];
    				$scope.partymanagerphone = data.data[0].content[35];
    				$scope.partymanagerqq = data.data[0].content[36];
    				$scope.oldaddress = data.data[0].content[37];    				
    				$scope.roomaddress = data.data[0].content[38];
    				$scope.roomarea = data.data[0].content[39];
    				$scope.datelogin = data.data[0].content[40];
            	}
            	else if (data.data) {
            		toastr.error('获取企业详情出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取企业详情出错');
            	}
            })
            .error(function () {
                toastr.error('获取企业详情出错');
            });
	}
	
	//保存企业信息
	$scope.save = function () {
		if ($scope.companyname == "") {
			toastr.error('企业名称不能为空');
			return;
		}
		if ($scope.injectionname == "") {
			toastr.error('注册法人不能为空');
			return;
		}
		/*if ($scope.injectionpeoplecode == "") {
			toastr.error('法人身份证号不能为空');
			return;
		}
		if ($scope.companynature =="") {
			toastr.error('单位性质不能为空');
			return;
		}
		if ($scope.injectionphone =="") {
			toastr.error('法人联系电话不能为空');
			return;
		}
		if ($scope.managername =="") {
			toastr.error('行政负责人不能为空');
			return;
		}
		if ($scope.managerphone =="") {
			toastr.error('行政联系电话不能为空');
			return;
		}
		if ($scope.financername =="") {
			toastr.error('财务姓名不能为空');
			return;
		}
		if ($scope.financerphone =="") {
			toastr.error('财务联系电话不能为空');
			return;
		}*/
		if ($scope.datelogin =="") {
			toastr.error('入驻时间不能为空');
			return;
		}
		if ($scope.roomid =="") {
			toastr.error('入驻地址不能为空');
			return;
		}
		//获取入驻地址
		var communityName = $("#selcommunity").find("option:selected").text();
		var buildingName = $("#selbuilding").find("option:selected").text();
		var floorName = $("#selfloor").find("option:selected").text();
		var roomName = $("#selroom").find("option:selected").text();
		$scope.roomaddress = communityName+buildingName+'-'+floorName+'-'+roomName;

		var p = 
		{
			username: session.getItem("uername"), 
			body: 
				$scope.id+'\t'+$scope.roomid+'\t'+
				$scope.companyname+'\t'+$scope.companyregstatus+'\t'+$scope.employees+'\t'+$scope.companyregcapital+'\t'+
					$scope.companynature+'\t'+$scope.companyregnum+'\t'+$scope.companymergenum+'\t'+$scope.companyisscale+'\t'+
				$scope.companymainbusiness+'\t'+$scope.companyindustry+'\t'+$scope.companyoperationform+'\t'+$scope.companyoperationstatus+'\t'+$scope.companysales+'\t'+
					$scope.companylastyeartax+'\t'+$scope.companyincrements+'\t'+$scope.companyinvestment+'\t'+
				$scope.injectionname+'\t'+$scope.injectionpeoplecode+'\t'+$scope.injectionphone+'\t'+$scope.injectiontax+'\t'+
				$scope.managername+'\t'+$scope.managerphone+'\t'+$scope.managerqq+'\t'+$scope.financername+'\t'+$scope.financerphone+'\t'+$scope.financerqq+'\t'+
				$scope.womens+'\t'+$scope.yongers+'\t'+$scope.minds+'\t'+$scope.partymembers+'\t'+$scope.tradeunions+'\t'+
				$scope.partyname+'\t'+$scope.partymanagername+'\t'+$scope.partymanagerphone+'\t'+$scope.partymanagerqq+'\t'+
				$scope.oldaddress+'\t'+$scope.datelogin+'\t'+$scope.roomaddress+'\t'+$scope.roomarea
		};
        dataService.getItems('admin/company/save', p)
            .success(function (data) {
            	if (data.result == 0) {
            		toastr.success('企业保存成功');
            		if ($scope.id) { //修改，关闭窗口
            			$("#modal-edit-show").modal('hide');
            		}
            		else { //入驻，跳转到管理页面
            			window.location.href = '#/company/cate3.0';
            		}
            	}
            	else if (data.data) {
            		toastr.error('企业保存失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('企业保存失败');
            	}
            })
            .error(function () {
                toastr.error('企业保存失败');
            });
	}
	
	//删除企业信息
	$scope.del = function (id) {		
		if (confirm("确定要删除吗？") == false) {
			return false;
		}
		
		var p = { username: session.getItem("uername"), body: id };
        dataService.getItems('admin/company/del', p)
            .success(function (data) {
            	if (data.result == 0) { 
            		toastr.success('企业删除成功');
            		//从缓存中删除记录
            		for (var i=0; i<$scope.pagedItems.length; i++) {
            			if ($scope.pagedItems[i].content[0] == id) {
            				$scope.pagedItems.splice(0, 1);
            				break;
            			}
            		}
            	}
            	else if (data.data) {
            		toastr.error('企业删除失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('企业删除失败');
            	}
            })
            .error(function () {
                toastr.error('社区删除失败');
            });
	}
	
	//获取企业注消详情
	$scope.getLogout = function () {
		var p = { username: session.getItem("uername"), body: $scope.id };
        dataService.getItems('admin/company/getlogout', p)
            .success(function (data) {
            	if (data.result == 0) {
                	$scope.datelogout = data.data[0].content[1];	//注销时间
                	$scope.logoutreason = data.data[0].content[2];	//注销原因
                	$scope.ischangeaddress = data.data[0].content[3];//注销后注册地址是否变更
                	$scope.newaddress = data.data[0].content[4];	 //注销后新注册地
                	$scope.logoutlinkname = data.data[0].content[5]; //注销后联系人
                	$scope.logoutlinkphone = data.data[0].content[6];//注销后联系电话
                	$scope.logoutmemo = data.data[0].content[7];	 //备注
                	$scope.logoutchkdesc = data.data[0].content[8];  //审核意见
            	}
            	else if (data.data) {
            		toastr.error('获取企业注销详情出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取企业注销详情出错');
            	}
            })
            .error(function () {
                toastr.error('获取企业注销详情出错');
            });
	}
	
	//保存注销信息
	$scope.saveLogout = function () {
		var p = 
		{
			username: session.getItem("uername"), 
			body: 
				$scope.id+'\t'+
				$scope.datelogout+'\t'+$scope.logoutreason+'\t'+$scope.ischangeaddress+'\t'+$scope.newaddress+'\t'+
				$scope.logoutlinkname+'\t'+$scope.logoutlinkphone+'\t'+$scope.logoutmemo
		};
        dataService.getItems('admin/company/savelogout', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$("#modal-logout-show").modal('hide');
            		toastr.success('企业注销登记成功');
            	}
            	else if (data.data) {
            		toastr.error('企业注销登记失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('企业注销登记失败');
            	}
            })
            .error(function () {
                toastr.error('企业注销登记失败');
            });
	}
	
	//企业注销审核
	$scope.savePass = function (action) {
		var content = '';
		if (action == '1') {
			if (confirm("确定要审核通过吗？") == false) {
				return false;
			}			
		}
		else {
			content = $("#txtUnpass").val();
		}
		
		var p = 
		{
			username: session.getItem("uername"), 
			body: $scope.id+'\t'+content+'\t'+action
		};
        dataService.getItems('admin/company/checklogout', p)
            .success(function (data) {
            	if (data.result == 0) {
            		if (action == '0') {
            			$("#modal-unpass-show").modal('hide');
            		}
            		$("#modal-logout-show").modal('hide');
            		toastr.success('企业注销审核成功');
            	}
            	else if (data.data) {
            		toastr.error('企业注销审核失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('企业注销审核失败');
            	}
            })
            .error(function () {
                toastr.error('企业注销审核失败');
            });
	}
	
	//查询
	$scope.search = function () {
		var companyName = $("#txtCompanyName").val();
		if (companyName == '') {
			toastr.error('请输入需要查询的企业名称！');
			return false;
		}
		//刷新
		$scope.body = 'a.CompanyName like \'%'+companyName+'%\'';
		$scope.load();
		$("#modal-search-show").modal('hide');
	}
	
	//根据社区序号获取楼宇信息
	$scope.getBuildings = function (communityid) {
		if (!empty(communityid))
			$scope.communityid =communityid;
		
		$scope.loadBuildings('b.CommunityID=\''+$scope.communityid+'\'', '');
	}
	
	//获取楼层信息
	$scope.getFloors = function (buildingid) {
		if (!empty(buildingid))
			$scope.buildingid =buildingid;
		
		var floorcount = 20;
		//获取楼层数
		for (var i=0; i<$scope.buildingItems.length; i++) {
			if ($scope.buildingItems[i].content[0] == $scope.buildingid) {			
				floorcount = parseInt($scope.buildingItems[i].content[2]);
				break;
			}
		}
		$scope.floorItems =[];
		$scope.roomItems = [];
		for (var i=1; i<=floorcount; i++) {
			$scope.floorItems.push(i);
		}		
	}
	
	//获取房间信息
	$scope.getRooms = function (floornum) {
		if (!empty(floornum))
			$scope.floornum =floornum;
		
		$scope.loadRooms($scope.buildingid, $scope.floornum, 1);
	}
	
	//获取房间面积
	$scope.getRoomArea = function (roomid) {
		if (!empty(roomid))
			$scope.roomid =roomid;
		
		for (var i=0; i<$scope.roomItems.length; i++) {
			if ($scope.roomItems[i].content[2] == $scope.roomid) {
				$scope.roomarea = $scope.roomItems[i].content[4];
				break;
			}
		}
	}
	
	//获取企业状态
	$scope.getStatus = function (companyid) {
		var result = '';
		for (var i=0; i<$scope.pagedItems.length; i++) {
			if ($scope.pagedItems[i].content[0] == companyid) {
				//Status=1表示入驻
				if ($scope.pagedItems[i].content[5] == '1') {
					result = '入驻';
				}
				else if ($scope.pagedItems[i].content[7] == '1') { //未入驻，查找注销原因 
					result = '外迁';
				}
				else if ($scope.pagedItems[i].content[7] == '2') {
					result = '关停';
				}
				else if ($scope.pagedItems[i].content[7] == '3') {
					result = '其他';
				}
				break;
			}
		}
		return result;
	}
	
	//获取注销状态
	//审核中/已注销
	$scope.getLogoutStatus = function (companyid) {
		var result = '';
		for (var i=0; i<$scope.pagedItems.length; i++) {			
			if ($scope.pagedItems[i].content[0] == companyid) {
				//是否注销 （1是、2审核中、0否）
				if ($scope.pagedItems[i].content[6] == '1') { 
					result = '已注销';
				}
				else if ($scope.pagedItems[i].content[6] == '2') {
					result = '审核中';
				}
				else if ($scope.pagedItems[i].content[6] == '3') {
					result = '未通过';
				}
				break;
			}
		}
		return result;
	}
	
	/*
	 * 窗体显示
	 * */
	//显示修改窗体
	$scope.loadEditForm = function (id, isedit) {
		$scope.id = id;
		$scope.isEditItem = isedit;
		$scope.get();
		$("#modal-edit-show").modal();
	}
	
	//企业注销
	$scope.loadLogOutForm = function (id, isedit) {
		//读取企业名称
		for (var i=0;i<$scope.pagedItems.length;i++) {
			if ($scope.pagedItems[i].content[0] == id) {
				$scope.companyname = $scope.pagedItems[i].content[1];
				break;
			}
		}		
		$scope.id = id;
		$scope.isEditItem = isedit;
		$scope.getLogout();
		$("#modal-logout-show").modal();
	}
	
	//显示企业注销审核主界面
	$scope.loadLogOutCheckForm = function (id) {
		//读取企业名称
		for (var i=0;i<$scope.pagedItems.length;i++) {
			if ($scope.pagedItems[i].content[0] == id) {
				$scope.companyname = $scope.pagedItems[i].content[1];
				break;
			}
		}		
		$scope.id = id;
		$scope.getLogout();
		$("#modal-logoutcheck-show").modal();
	}	
	
	//显示审核未通过窗体
	$scope.loadUnpassForm = function () {
		$("#modal-unpass-show").modal();
	}
	
	//显示查询窗体
	$scope.loadSearchForm = function () {
		$("#modal-search-show").modal();
	}
	
}]);