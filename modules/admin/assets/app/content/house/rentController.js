/**
 * 出租房源管理控制器
 */
angular.module('blogAdmin').controller('RentController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.id = '';
	$scope.isEditItem = false;
	
	$scope.roomnum = '';//房号
	$scope.title = '';//楼宇名称
	$scope.floorcount = 0;//层数
	$scope.area = 0;//面积
	$scope.rent = 0;//租金
	$scope.servicefee = 0;//物业费
	$scope.linkphone = '';//联系电话
	
	//加载列表数据
	$scope.load = function () {
		var p = { username: session.getItem("uername"), body: '\t'+ $scope.orderBy+'\t'+$scope.recordCount+'\t'+$scope.currentPage+'\t15' };
        dataService.getItems('admin/rent/list', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$scope.setPagedItems(data);
            	}
            	else if (data.data) {
            		toastr.error('获取出租房源列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取出租房源列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取出租房源列表出错');
            });
	}
	
	//初始化分页控件
	pageInit($scope, $filter);
	
	$(document).ready(function () {

	});
	
	/*
	 * 信息操作
	 * */
	
	//获取获取详情
	$scope.get = function () {
		var p = { username: session.getItem("uername"), body: $scope.id };
        dataService.getItems('admin/rent/get', p)
            .success(function (data) {
            	if (data.result == 0) {
                	$scope.roomnum = data.data[0].content[1];//房号
                	$scope.title = data.data[0].content[2];//楼宇名称
                	$scope.floorcount = data.data[0].content[3];//层数
                	$scope.area = data.data[0].content[4];//面积
                	$scope.rent = data.data[0].content[5];//租金
                	$scope.servicefee = data.data[0].content[6];//物业费
                	$scope.linkphone = data.data[0].content[7];//联系电话               	
            	}
            	else if (data.data) {
            		toastr.error('获取出租详情出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取出租详情出错');
            	}
            })
            .error(function () {
                toastr.error('获取出租详情出错');
            });
	}
	
	//保存出租信息
	$scope.save = function () {
		if ($scope.roomnum == "") {
			toastr.error('房号不能为空');
			return;
		}
		if ($scope.title == "") {
			toastr.error('楼宇名称不能为空');
			return;
		}
		if ($scope.rent == "") {
			toastr.error('租金不能为空');
			return;
		}
		if ($scope.linkphone == "") {
			toastr.error('联系电话不能为空');
			return;
		}
		if (isNaN($scope.rent)) {
			toastr.error('租金有非法字符');
			return;
		}

		var p = 
		{
			username: session.getItem("uername"), 
			body: $scope.id+'\t'+$scope.roomnum+'\t'+$scope.title+'\t'+$scope.floorcount+'\t'+$scope.area+'\t'+
					$scope.rent+'\t'+$scope.servicefee+'\t'+$scope.linkphone
		};
        dataService.getItems('admin/rent/save', p)
            .success(function (data) {
            	if (data.result == 0) {
            		toastr.success('出租信息保存成功');
            	}
            	else if (data.data) {
            		toastr.error('出租信息保存失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('出租信息保存失败');
            	}
            })
            .error(function () {
                toastr.error('出租信息保存失败');
            });
	}
	
	//删除出租信息
	$scope.del = function (id) {		
		if (confirm("确定要删除吗？") == false) {
			return false;
		}
		
		var p = { username: session.getItem("uername"), body: id };
        dataService.getItems('admin/rent/del', p)
            .success(function (data) {
            	if (data.result == 0) { 
            		toastr.success('出租信息删除成功');
            		//从缓存中删除记录
            		for (var i=0; i<$scope.pagedItems.length; i++) {
            			if ($scope.pagedItems[i].content[0] == id) {
            				$scope.pagedItems.splice(i, 1);
            				break;
            			}
            		}
            	}
            	else {
            		toastr.error('出租信息删除失败'); //原因：' + data[0].content[0]);
            	}
            })
            .error(function () {
                toastr.error('出租信息删除失败');
            });
	}
	
	/*
	 * 窗体显示
	 * */
	
	//显示新增窗体
	$scope.loadNewForm = function (isedit) {
		$scope.id = '';
		$scope.isEditItem = true;
		$("#modal-edit-show").modal();
	}
	
	//显示修改窗体
	$scope.loadEditForm = function (id, isedit) {
		$scope.id = id;
		$scope.isEditItem = isedit;
		$scope.get();
		$("#modal-edit-show").modal();
	}
	
}]);