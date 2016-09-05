/**
 * 楼宇控制器
 */
angular.module('blogAdmin').controller('BuildingController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.id = '';
	$scope.isEditItem = false;
	
	$scope.communityItems = []; 	//社区名称列表
	$scope.settledStatsItems = [];	//楼宇入驻情况列表
	$scope.floorStatsItems = [];	//楼宇楼层入驻情况列表
	$scope.floorItems = []; //楼层信息列表
	$scope.roomItems = []; 	//房间信息列表
	
	//楼宇信息字段
	$scope.communityid = '0';	//所属社区
	$scope.buildingname = '';	//楼宇名称
	$scope.buildingaddress = '';//楼宇地址
	$scope.buildingpoint = '';	//楼宇地标
	$scope.usedarea = 0;	//占地面积
	$scope.buildarea = 0;	//建筑面积
	$scope.buildinghigh = 0;//楼宇总高度
	$scope.floornum = 0;	//楼层号
	$scope.floorcout = 0; 	//楼宇层数（层）
	$scope.floorhigh = 0; 	//楼宇单层高度
	$scope.floorarea = 0; 	//楼宇单层面积
	$scope.renovation = '0';//装修方式
	$scope.rent = 0;//租金
	$scope.buildingdescription = '';//楼宇简介
	
	$scope.floorimage = '';		//楼层平面图
	$scope.buildingphoto = '';	//楼于照片
	
	//车位信息
	$scope.upcars = 0; 	//地上车位数（个）
	$scope.downcars = 0;//地下车位数（个）
	
	//开发商信息字段
	$scope.developcompany = '';	//开发商名称
	$scope.developname = '';	//开发商联系人
	$scope.developphone = '';	//开发商联系电话
	
	//物业字段
	$scope.servicescompany = '';//物业公司名称
	$scope.servicesname = '';	//物业联系人
	$scope.servicesphone = '';	//物业联系电话
	$scope.servicesmemo = '';	//物业资质
	$scope.servicesprice = 0;	//物业费
	
	//业委会字段
	$scope.authoritycompany = '';	//业委会名称
	$scope.authorityname = '';		//业委会联系人
	$scope.authorityphone = '';		//业委会联系电话
	
	//其它
	$scope.devicememo = '';	//楼宇配套设施情况
	$scope.trafficmemo = '';//周边交通工具状况
	$scope.othermemo = '';	//其他需要说明事项
	
	//房间信息
	$scope.roomid = '';		//房间序号
	$scope.roomnum = ''; 	//房间号
	$scope.roomarea = '';	//房间面积
	$scope.roomstatus = 1;	//房间状态
	$scope.roomrent = '';	//租金价格
	$scope.roomrenovation = 1;//装修方式
	
	//初始化后台站点控制器
	SiteInit($rootScope, $scope, dataService);
	//初始化地图
	MapInit($scope);
	
	//加载社区信息
	$scope.loadCommunities('', '');
	
	//统计入驻情况
	$scope.loadStats = function () {
		//获取需要统计的楼宇序号，做为统计条件
		var ids = "";
		for (var i=0; i<$scope.pagedItems.length; i++) {
			ids += ",'" + $scope.pagedItems[i].content[0]+"'";
		}
		if (ids == '') {
			return false;
		}
		ids = ids.substring(1); //去掉第一个','
		
		var p = { username: session.getItem("uername"), body: ids };
        dataService.getItems('admin/building/settledstats', p)
            .success(function (data) {
            	if (data.result == 0) {
            		//转换成js字典序
            		for (var i=0; i<data.data.length; i++) {
            			$scope.settledStatsItems[data.data[i].content[0]] = data.data[i];
            		}
            	}
            	else if (data.data) {
            		toastr.error('获取楼宇列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取楼宇列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取楼宇列表出错');
            });
	}
	
	//加载列表数据
	$scope.load = function () {
		var p = { username: session.getItem("uername"), body: "\t"+ $scope.orderBy+"\t"+$scope.recordCount+"\t"+$scope.currentPage };
        dataService.getItems('admin/building/list', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$scope.setPagedItems(data);
            		$scope.loadStats();
            	}
            	else if (data.data) {
            		toastr.error('获取楼宇列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取楼宇列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取楼宇列表出错');
            });
	}

	//图片上传回调函数
	var callFloorimage = function (result) {
		$scope.floorimage = result.path;
		$('#floorimage').html('<img src="'+$scope.floorimage+'"/>');
	}
	//图片上传回调函数
	var callBuildingphoto = function (result) {
		$scope.buildingphoto = result.path;
		$('#buildingimage').html('<img src="'+$scope.buildingphoto+'"/>');
	}
	
	$(document).ready(function () {
		var url = window.location.href;
		if (url.indexOf("cate2.0")>0) { //获取列表
			//初始化分页控件
			pageInit($scope, $filter);
		}
		else if (url.indexOf("cate2.4")>0) {
			$scope.loadBuildings('', '');
		}
		//初始化上传组件
		//楼层结构图
		initCoverImageUploader("floorfiles","floorcontainer","1mb","/file/upload",'',callFloorimage);
		//楼宇图片
		initCoverImageUploader("buildingfiles","buildingcontainer","1mb","/file/upload",'',callBuildingphoto);
	});
	
	//统计楼宇楼层入驻情况
	$scope.loadFloorStats = function (buildingid) {		
		var p = { username: session.getItem("uername"), body: buildingid };
        dataService.getItems('admin/building/floorsettledstats', p)
            .success(function (data) {
            	if (data.result == 0) {
            		//转换成js字典序
            		for (var i=0; i<data.data.length; i++) {
            			$scope.floorStatsItems[data.data[i].content[0]] = data.data[i];
            		}
            	}
            	else if (data.data) {
            		toastr.error('获取楼宇楼层列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取楼宇楼层列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取楼宇楼层列表出错');
            });
	}
	
	/*
	 * 信息操作
	 * */
	//获取楼宇详情
	$scope.get = function () {
		$scope.floorimage = '';
		$scope.buildingphoto ='';
		
		var p = { username: session.getItem("uername"), body: $scope.id };
        dataService.getItems('admin/building/get', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$scope.communityid = data.data[0].content[1];//所属社区
            		$scope.buildingname = data.data[0].content[2];//楼宇名称
            		$scope.buildingaddress = data.data[0].content[3];//楼宇地址
            		$scope.buildingpoint = data.data[0].content[12];//楼宇地标
            		//去除前面的POINT( 与后面的 )
            		if ($scope.buildingpoint>'') {
            			$scope.buildingpoint = $scope.buildingpoint.substring(6, $scope.buildingpoint.length-1);
            		}

            		$scope.usedarea = data.data[0].content[4];//占地面积
            		$scope.buildarea = data.data[0].content[5];//建筑面积
            		$scope.buildinghigh = data.data[0].content[6];//楼宇总高度
            		$scope.floorcout = data.data[0].content[7]; //楼宇层数（层）
            		$scope.floorhigh = data.data[0].content[8]; //楼宇单层高度
            		$scope.floorarea = data.data[0].content[9]; //楼宇单层面积
            		$scope.renovation = data.data[0].content[11];//装修方式
            		$scope.rent = data.data[0].content[10];//租金
            		$scope.buildingdescription = data.data[0].content[13];//楼宇简介
            		
            		$scope.floorimage = data.data[0].content[31];//楼层平面图
            		$scope.buildingphoto = data.data[0].content[30];//楼于照片

            		//车位信息
            		$scope.upcars = data.data[0].content[14]; //地上车位数（个）
            		$scope.downcars = data.data[0].content[15];//地下车位数（个）
            		
            		//开发商信息字段
            		$scope.developcompany = data.data[0].content[16];//开发商名称
            		$scope.developname = data.data[0].content[17];//开发商联系人
            		$scope.developphone = data.data[0].content[18];//开发商联系电话
            		
            		//物业字段
            		$scope.servicescompany = data.data[0].content[19];//物业公司名称
            		$scope.servicesname = data.data[0].content[20];//物业联系人
            		$scope.servicesphone = data.data[0].content[21];//物业联系电话
            		$scope.servicesmemo = data.data[0].content[23];//物业资质
            		$scope.servicesprice = data.data[0].content[22];//物业费
            		
            		//业委会字段
            		$scope.authoritycompany = data.data[0].content[24];//业委会名称
            		$scope.authorityname = data.data[0].content[25];//业委会联系人
            		$scope.authorityphone = data.data[0].content[26];//业委会联系电话
            		
            		//其它
            		$scope.devicememo = data.data[0].content[27];//楼宇配套设施情况
            		$scope.trafficmemo = data.data[0].content[28];//周边交通工具状况
            		$scope.othermemo = data.data[0].content[29];//其他需要说明事项
            	}
            	else if (data.data) {
            		toastr.error('获取楼宇详情出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取楼宇详情出错');
            	}
            })
            .error(function () {
                toastr.error('获取楼宇详情出错');
            });
	}	

	//保存楼宇信息
	$scope.save = function () {
		if ($scope.buildingname == "") {
			toastr.error('楼宇名称不能为空');
			return;
		}
		if ($scope.communityid == "") {
			toastr.error('所属社区不能为空');
			return;
		}
		if ($scope.buildingaddress == "") {
			toastr.error('楼宇地址不能为空');
			return;
		}
		if ($scope.buildingpoint =="") {
			toastr.error('请选择楼宇地标');
			return;
		}
		if ($scope.developcompany =="") {
			toastr.error('开发商名称不能为空');
			return;
		}
		if ($scope.developname =="") {
			toastr.error('开发商联系人不能为空');
			return;
		}
		if ($scope.developphone =="") {
			toastr.error('开发商联系电话不能为空');
			return;
		}
		if ($scope.floorcout =="") {
			toastr.error('楼宇层数不能为空');
			return;
		}
		if ($scope.floorarea =="") {
			toastr.error('楼宇单层面积不能为空');
			return;
		}
		if (confirm("确定要保存吗？楼宇层数、楼宇名称、楼宇单层面积不允许被修改！") == false) {
			return false;
		}
		
		var p = 
		{
			username: session.getItem("uername"), 
			body: $scope.id+'\t'+$scope.communityid+'\t'+$scope.buildingname+'\t'+$scope.buildingaddress+'\t'+$scope.buildingpoint+'\t'+
					$scope.usedarea+'\t'+$scope.buildarea+'\t'+$scope.buildinghigh+'\t'+$scope.floorcout+'\t'+$scope.floorhigh+'\t'+$scope.floorarea+'\t'+
					$scope.renovation+'\t'+$scope.rent+'\t'+$scope.buildingdescription+'\t'+$scope.floorimage+'\t'+$scope.buildingphoto+'\t'+				
					$scope.upcars+'\t'+$scope.downcars+'\t'+				
					$scope.developcompany+'\t'+$scope.developname+'\t'+$scope.developphone+'\t'+					
					$scope.servicescompany+'\t'+$scope.servicesname+'\t'+$scope.servicesphone+'\t'+$scope.servicesmemo+'\t'+$scope.servicesprice+'\t'+
					$scope.authoritycompany+'\t'+$scope.authorityname+'\t'+$scope.authorityphone+'\t'+
					$scope.devicememo+'\t'+$scope.trafficmemo+'\t'+$scope.othermemo
		};
        dataService.getItems('admin/building/save', p)
            .success(function (data) {
            	if (data.result == 0) {
            		toastr.success('楼宇信息保存成功');
            	}
            	else if (data.data) {
            		toastr.error('楼宇信息保存失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('楼宇信息保存失败');
            	}
            })
            .error(function () {
                toastr.error('楼宇信息保存失败');
            });
	}
	
	//删除楼宇信息
	$scope.del = function (id) {		
		if (confirm("确定要删除吗？") == false) {
			return false;
		}

		var p = { username: session.getItem("uername"), body: id };
        dataService.getItems('admin/building/del', p)
            .success(function (data) {
            	if (data.result == 0) { 
            		toastr.success('楼宇删除成功');
            		//从缓存中删除记录
            		for (var i=0; i<$scope.pagedItems.length; i++) {
            			if ($scope.pagedItems[i].content[0] == id) {
            				$scope.pagedItems.splice(i, 1);
            				break;
            			}
            		}
            	}
            	else {
            		toastr.error('楼宇删除失败'); //原因：' + data[0].content[0]);
            	}
            })
            .error(function () {
                toastr.error('楼宇删除失败');
            });
	}
	
	//保存楼层面积
	$scope.saveFloor = function () {
		if ($scope.id == '' || $scope.floornum == '') {
			toastr.error('楼层修改失败，楼层号或楼宇序号为空！');
			return false;
		}
		
		var floorarea = $("#txtFloorArea").val();
		if (isNaN(floorarea) || floorarea=='') {
			toastr.error('楼层号有非数字！');
			return false;
		}
		
		var p = { username: session.getItem("uername"), body: $scope.id+'\t'+$scope.floornum+'\t'+floorarea };
        dataService.getItems('admin/building/savefloor', p)
            .success(function (data) {
            	if (data.result == 0) {           		
            		//从缓存中删除记录
            		for (var i=0; i<$scope.floorItems.length; i++) {
            			if ($scope.floorItems[i].content[0] == $scope.id && $scope.floorItems[i].content[1]==$scope.floornum) {
            				$scope.floorItems[i].content[2] = floorarea;
            				break;
            			}
            		}
            		$("#modal-editfloor-show").modal('hide');
            		toastr.success('楼层面积修改成功');
            	}
            	else {
            		toastr.error('楼层面积修改失败');
            	}
            })
            .error(function () {
                toastr.error('楼层面积修改失败');
            });
	}
	
	//获取房间信息
	$scope.getRoom = function () {
		var p = 
		{
			username: session.getItem("uername"), 
			body: $scope.roomid //$scope.id+'\t'+
		};
        dataService.getItems('admin/building/getroom', p)
            .success(function (data) {
            	if (data.result == 0) {
            		//toastr.success('获取房间信息成功');
            		//$scope.roomid = data.data[0].content[0];	//房间序号
            		$scope.roomnum = data.data[0].content[2]; 	//房间号            		
            		$scope.roomarea = data.data[0].content[3];	//房间面积
            		$scope.roomstatus = data.data[0].content[4];//房间状态
            		$scope.roomrent = data.data[0].content[5];	//租金价格
            		$scope.roomrenovation = data.data[0].content[6];//装修方式
            	}
            	else if (data.data) {
            		toastr.error('获取房间信息失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取房间信息失败');
            	}
            })
            .error(function () {
                toastr.error('获取房间信息失败');
            });       
	}
	
	//保存房间信息
	$scope.saveRoom = function () {
		if ($scope.roomnum == "") {
			toastr.error('房间号不能为空');
			return;
		}
		if ($scope.roomarea == "") {
			toastr.error('房间面积不能为空');
			return;
		}
		
		var p = 
		{
			username: session.getItem("uername"), 
			body: 
				$scope.id+'\t'+$scope.roomid+'\t'+
				$scope.floornum+'\t'+$scope.roomnum+'\t'+$scope.roomarea+'\t'+$scope.roomstatus+'\t'+$scope.roomrent+'\t'+$scope.roomrenovation
		};
        dataService.getItems('admin/building/saveroom', p)
            .success(function (data) {
            	if (data.result == 0) {
            		//保存到房间列表缓存中
            		if ($scope.roomid == '' || $scope.roomid == null) {
            			$scope.roomid = data.data[0].content[0];
            			var item = 
            			{'content':
            				[
								$scope.id,
								$scope.floornum,
								$scope.roomid,
								$scope.roomnum,
								$scope.roomarea,
								$scope.roomstatus,
								$scope.roomrent,
								$scope.roomrenovation 
							]
            			};
            			$scope.roomItems.push(item);
            		}
            		$("#modal-editroom-show").modal('hide');
            		toastr.success('房间保存成功');
            	}
            	else if (data.result == -27) {
            		toastr.error('房间号重复！');
            	}
            	else if (data.data) {
            		toastr.error('房间保存失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('房间保存失败');
            	}
            })
            .error(function () {
                toastr.error('房间保存失败');
            });
        
	}
	
	//删除房间信息
	$scope.delRoom = function (roomid) {		
		if (confirm("确定要删除吗？") == false) {
			return false;
		}

		var p = { username: session.getItem("uername"), body: roomid };
        dataService.getItems('admin/building/delroom', p)
            .success(function (data) {
            	if (data.result == 0) { 
            		toastr.success('房间删除成功');
            		//从缓存中删除记录
            		for (var i=0; i<$scope.roomItems.length; i++) {
            			if ($scope.roomItems[i].content[2] == roomid) {
            				$scope.roomItems.splice(i, 1);
            				break;
            			}
            		}
            	}
            	else {
            		toastr.error('房间删除失败'); //原因：' + data[0].content[0]);
            	}
            })
            .error(function () {
                toastr.error('房间删除失败');
            });
	}
	
	/*
	 * 函数 
	 * */
	
	//计算楼宇面积
	//param:count楼层数，value单位面积
	$scope.calcArea = function (count, value) {
		if (isNaN(count)==true || isNaN(value) == true) {
			return 0;
		}
		return count*value;
	}
	
	//计算空置率
	//param:value1楼宇面积，value2入驻面积
	$scope.calcVacancyRate = function (value1, value2) {
		if (isNaN(value1)==true || isNaN(value2) == true) {
			return 100;
		}
		return (((value1-value2)/value1)*100).toFixed(2);
	}
	
	//计算空置面积
	//param:value1楼层面积，value2入驻面积
	$scope.calcLeftArea = function (value1, value2) {
		if (isNaN(value1)==true || isNaN(value2) == true) {
			return 0;
		}
		return parseInt(value1)-parseInt(value2);
	}
	
	//获取社区名称
	$scope.getCommunityName = function(id) {
		for (var i=0; i<$scope.communityItems.length; i++) {
			if (id == $scope.communityItems[i].content[0]) {
				return $scope.communityItems[i].content[1];
			}
		}
	}

	//获取状态名称
	$scope.getStatusName = function (status) {
		if (status == 1) {
			return '自住';
		}
		else if (status == 2) {
			return '闲置';
		}
		else if (status == 3) {
			return '出租';
		}
		else return '未知';
	}
	
	//获取装修方式名称
	$scope.getRenovationName = function (renovation) {
		if (renovation == 1) {
			return '精装';
		}
		else if (renovation == 2) {
			return '简装';
		}
		else if (renovation == 3) {
			return '毛坯';
		}
		else return '未知';
	}
	
	/*地图相关*/
	//地理编码返回结果展示
	$scope.geocoder_CallBack = function (data) {
	    var resultStr = "";
	    //地理编码结果数组
	    var geocode = data.geocodes;
	    for (var i = 0; i < geocode.length; i++) {
	        //拼接输出html
	        resultStr += "<span style=\"font-size: 12px;padding:0px 0 4px 2px; border-bottom:1px solid #C1FFC1;\">" + "<b>地址</b>：" + geocode[i].formattedAddress + "" + "&nbsp;&nbsp;<b>的地理编码结果是:</b><b>&nbsp;&nbsp;&nbsp;&nbsp;坐标</b>：" + geocode[i].location.getLng() + ", " + geocode[i].location.getLat() + "" + "<b>&nbsp;&nbsp;&nbsp;&nbsp;匹配级别</b>：" + geocode[i].level + "</span>";
	        $scope.addMarker(geocode[i].location.getLng(), geocode[i].location.getLat(), geocode[i].formattedAddress);
	        $scope.buildingpoint = geocode[i].location.getLng() + " " + geocode[i].location.getLat();
	        break;
	    }
	    $scope.map.setFitView();
	    $scope.map.setZoom(14);
	    document.getElementById("mapresult").innerHTML = resultStr;
	}
	
	//为地图注册click事件获取鼠标点击出的经纬度坐标
    var clickEventListener = $scope.map.on('click', function(e) {
        //清除地图覆盖物
    	$scope.map.clearMap();
    	$scope.addMarker(e.lnglat.getLng(), e.lnglat.getLat(), e.formattedAddress);
    	$scope.buildingpoint = e.lnglat.getLng() + " " + e.lnglat.getLat();
    });
    
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
	
	//显示楼层窗体
	$scope.loadFloorForm = function (id) {
		$scope.id = id;
		//获取楼层信息
		$scope.floorItems = [];
		
		//从楼宇列表中获取楼层简要信息
		for (var i=0; i<$scope.buildingItems.length; i++) {
			if (id == $scope.buildingItems[i].content[0]) {
				$scope.buildingname = $scope.buildingItems[i].content[1];
				break;
			}
		}
		
		var p = { username: session.getItem("uername"), body: id };
        dataService.getItems('admin/building/floorlist', p)
            .success(function (data) {
            	if (data.result == 0) {
            		angular.copy(data.data, $scope.floorItems);
            		//统计楼层入驻情况
            		$scope.loadFloorStats(id);
            		$("#modal-floor-show").modal();
            	}
            	else if (data.data) {
            		toastr.error('获取楼层信息出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取楼层信息出错');
            	}
            })
            .error(function () {
                toastr.error('获取楼层信息出错');
            });
	}	
	
	//显示修改楼层窗体
	$scope.loadEditFloorForm = function (floornum) {
		$scope.floornum = floornum;
		$("#modal-editfloor-show").modal();
	}
	
	//显示房间窗体
	//param:floornum楼层号
	$scope.loadRoomForm = function (floornum) {
		$scope.floornum = floornum;
		$scope.loadRooms($scope.id, $scope.floornum, 0);
		$("#modal-room-show").modal();		
	}
	
	//显示修改房间窗体
	$scope.loadEditRoomForm = function (roomid, isedit) {
		$scope.roomid = roomid;
		$scope.isEditItem = isedit;
		$scope.getRoom();
		$("#modal-editroom-show").modal();
	}
	
	//显示新增房间窗体
	$scope.loadAddRoomForm = function () {
		$scope.roomid = '';
		$scope.isEditItem = true;
		$("#modal-editroom-show").modal();
	}
	
	//显示地图窗体
	$scope.loadMapForm = function () {
		if ($scope.buildingpoint>'') {
			var point = $scope.buildingpoint.split(' ');
			$scope.addMarker(point[0], point[1], $scope.buildingaddress);
			$scope.map.panTo([parseFloat(point[0]), parseFloat(point[1])]);
		}
		else if ($scope.buildingaddress>'') {
			$scope.geocoder($scope.buildingaddress);//获取地理编码
		}
		
		$("#modal-map-show").modal();
	}
	
}]);