/**
 * 社区控制器
 */
angular.module('blogAdmin').controller('CommunityController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.id = Settings.communityid;
	$scope.isEditItem = false;
	
	//社区信息字段
	$scope.name = '';
	$scope.code = '';
	$scope.linkname = '';
	$scope.linkphone = '';
	$scope.mobile = '';
	$scope.address = '';
	$scope.desc = '';
	$scope.photopath = '';

	//初始化后台站点控制器
	SiteInit($rootScope, $scope, dataService);
	
	//加载列表数据
	$scope.load = function () {
		var p = { username: session.getItem("uername"), body: '\t'+ $scope.orderBy+'\t'+$scope.recordCount+'\t'+$scope.currentPage };
        dataService.getItems('admin/community/list', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$scope.setPagedItems(data);
            	}
            	else if (data.data) {
            		toastr.error('获取社区列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取社区列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取社区列表出错');
            });
	}
	
	//图片上传回调函数
	var callback = function (result) {
		$scope.photopath = result.path;
		$('#imgArea').html('<img src="'+$scope.photopath+'">');
	}
	
	//初始化分页控件
	pageInit($scope, $filter);
	
	//获取社区详情
	$scope.get = function () {
		$scope.photopath = '';
		var p = { username: session.getItem("uername"), body: $scope.id };
        dataService.getItems('admin/community/get', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$scope.name = data.data[0].content[1];
                	$scope.code = data.data[0].content[2];
                	$scope.linkname = data.data[0].content[3];
                	$scope.linkphone = data.data[0].content[4];
                	$scope.mobile = data.data[0].content[5];
                	$scope.address = data.data[0].content[6];
                	$scope.desc = data.data[0].content[7];
                	$scope.photopath = data.data[0].content[8];
            	}
            	else if (data.data) {
            		toastr.error('获取社区详情出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取社区详情出错');
            	}
            })
            .error(function () {
                toastr.error('获取社区详情出错');
            });
	}
	
	$(document).ready(function () {
		//初始化上传组件
		initCoverImageUploader("browfiles","container","1mb","/file/upload",'',callback);
		if ($scope.id) {
			$scope.get();
		}
	});
	
	/*
	 * 信息操作
	 * */
	
	//保存社区信息
	$scope.save = function () {
		if ($scope.name == "") {
			toastr.error('社区名称不能为空');
			return;
		}
		if ($scope.code == "") {
			toastr.error('社区代码不能为空');
			return;
		}
		if ($scope.linkname == "") {
			toastr.error('联系人不能为空');
			return;
		}
		if ($scope.linkphone =="") {
			toastr.error('联系电话不能为空');
			return;
		}
		if ($scope.address =="") {
			toastr.error('地址不能为空');
			return;
		}

		var p = 
		{
			username: session.getItem("uername"), 
			body: $scope.id+'\t'+$scope.name+'\t'+$scope.code+'\t'+$scope.linkname+'\t'+$scope.linkphone+'\t'+
					$scope.mobile+'\t'+$scope.address+'\t'+$scope.desc+'\t'+$scope.photopath
		};
        dataService.getItems('admin/community/save', p)
            .success(function (data) {
            	if (data.result == 0) {
            		toastr.success('社区保存成功');
            	}
            	else if (data.data) {
            		toastr.error('社区保存失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('社区保存失败');
            	}
            })
            .error(function () {
                toastr.error('社区保存失败');
            });
	}
	
	//删除社区信息
	$scope.del = function (id) {		
		if (confirm("确定要删除吗？") == false) {
			return false;
		}
		
		var p = { username: session.getItem("uername"), body: id };
        dataService.getItems('admin/community/del', p)
            .success(function (data) {
            	if (data.result == 0) { 
            		toastr.success('社区删除成功');
            		//从缓存中删除记录
            		for (var i=0; i<$scope.pagedItems.length; i++) {
            			if ($scope.pagedItems[i].content[0] == id) {
            				$scope.pagedItems.splice(i, 1);
            				break;
            			}
            		}
            	}
            	else {
            		toastr.error('社区删除失败'); //原因：' + data[0].content[0]);
            	}
            })
            .error(function () {
                toastr.error('社区删除失败');
            });
	}
	
	
	//保存社区信息
	$scope.updateProfile = function () {
		if ($scope.name == "") {
			toastr.error('社区名称不能为空');
			return;
		}
		if ($scope.code == "") {
			toastr.error('社区代码不能为空');
			return;
		}
		if ($scope.linkname == "") {
			toastr.error('联系人不能为空');
			return;
		}
		if ($scope.linkphone =="") {
			toastr.error('联系电话不能为空');
			return;
		}
		if ($scope.address =="") {
			toastr.error('地址不能为空');
			return;
		}

		var p = 
		{
			username: session.getItem("uername"), 
			body: $scope.id+'\t'+$scope.name+'\t'+$scope.code+'\t'+$scope.linkname+'\t'+$scope.linkphone+'\t'+
					$scope.mobile+'\t'+$scope.address+'\t'+$scope.desc+'\t'+$scope.photopath
		};
        dataService.getItems('admin/community/save', p)
            .success(function (data) {
            	if (data.result == 0) {
            		Settings.communityid = data.data[0].content[0];
            		$scope.updateAccount();
            		toastr.success('社区保存成功');
            	}
            	else if (data.data) {
            		toastr.error('社区保存失败，原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('社区保存失败');
            	}
            })
            .error(function () {
                toastr.error('社区保存失败');
            });
	}
	
	//更新社区序号到用户表中
	$scope.updateAccount = function () {
		var p = {communityid: $scope.id};
		dataService.getItems('admin/account/changecommunity', p)
        .success(function (data) {
        	console.log(data);
        	toastr.success('更新资料成功');
        })
        .error(function () {
            toastr.error('更新资料失败');
        });
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
	
}]);