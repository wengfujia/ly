/**
 * 分类管理控制器
 */
angular.module('blogAdmin').controller('CategoryController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.items = []
	
	$scope.id = '';
	$scope.isEditItem = false;
	
	$scope.detail = { "CategoryID":"", "CategoryName":"", "Description":"" };// 明细分类
	
	//加载列表数据
	$scope.load = function () {
		dataService.getItems('admin/category/index')
            .success(function (data) {
            	angular.copy(data, $scope.items);
            })
            .error(function () {
                toastr.error('获取分类列表出错');
            });
	}
	
	$scope.load();
	
	$(document).ready(function () {

	});
	
	//获取分类详情
	$scope.get = function () {
		//从缓存中获取一条记录
		for (var i=0; i<$scope.items.length; i++) {
			if ($scope.items[i].CategoryID == $scope.id) {
				$scope.detail = $scope.items[i];
				break;
			}
		}
		//判断是否有效数据
		if ($scope.detail.CategoryID == '') {
			toastr.error('获取分类详情出错');
		}
	}
	
	/*
	 * 信息操作
	 * */
	//保存分类信息
	$scope.save = function () {
		if ($scope.detail.CategoryName == "") {
			toastr.error('分类名称不能为空');
			return;
		}

		//var p = {"_csrf":"","Category":{"CategoryID":$scope.id,"CategoryName":$scope.detail.CategoryName,"SortOrder":1,"ParentID":"","Description":$scope.detail.Description}};
        var p = {"CategoryID":$scope.id,"CategoryName":$scope.detail.CategoryName,"Description":$scope.detail.Description};
		dataService.addItem('admin/category/save', p)
            .success(function (data) {
            	console.log(data);
            	toastr.success('社区保存成功');
            })
            .error(function () {
                toastr.error('社区保存失败');
            });
	}
	
	//删除分类
	$scope.del = function (id) {		
		if (confirm("确定要删除吗？") == false) {
			return false;
		}
		
		var p = { id: id };
        dataService.getItems('admin/category/delete', p)
            .success(function (data) {
            	for (var i=0; i<$scope.items.length; i++) {
        			if ($scope.items[i].CategoryID == data) {
        				$scope.items.splice(0, 1);
        				break;
        			}
        		}
            	toastr.success('分类删除成功');            	
            })
            .error(function () {
                toastr.error('分类删除失败');
            });
	}
	
	/*
	 * 窗体显示
	 * */
	//显示新增窗体
	$scope.loadNewForm = function () {
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