/**
 * 意见反馈管理控制器
 */
angular.module('blogAdmin').controller('BookController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.items = []

	$scope.detail = [];//反馈详情
	
	//加载列表数据
	$scope.load = function () {
		dataService.getItems('admin/book/index')
            .success(function (data) {
            	angular.copy(data, $scope.items);
				gridInit($scope, $filter);
            })
            .error(function () {
                toastr.error('获取意见反馈失败');
            });
	}
	$scope.load();
	
	$(document).ready(function () {

	});
	
	//获取反馈详情
	$scope.loadOne = function (id) {
        var url = 'admin/book/view?id=' + id;
        dataService.getItems(url)
        .success(function (data) {
        	angular.copy(data, $scope.detail);
        })
        .error(function () {
            toastr.error('加载反馈出错');
        });
    }
	
	/*
	 * 窗体显示
	 * */
	
	//显示查看详情窗体
	$scope.loadShowForm = function (id) {
		$scope.loadOne(id);
		$("#modal-show-form").modal();
	}
	
}]);