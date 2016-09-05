/**
 * 楼宇控制器
 */
angular.module('blogAdmin').controller('BuildingController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.id = getUrlParam('id'); //获取楼宇id
	$scope.buildings = [];
	$scope.detail = [];
	
	//加载楼宇图片列表数据
	$scope.loadBuildings = function () {
		var p = { body: '\t\t' };
		dataService.getItems('wap/default/buildings', p)
            .success(function (data) {      	
            	if (data.result == 0) {
            		angular.copy(data.data, $scope.buildings);
            	}
            	else if (data.data) {
            		toastr.error('获取楼宇列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取楼宇列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取楼宇列表失败');
            });
	}
	
	//获取楼宇详情
	$scope.loadOne = function () {
		var p = { username: 'guest', body: $scope.id };
        dataService.getItems('admin/building/get', p)
            .success(function (data) {
            	console.log(data);
            	if (data.result == 0) {
            		angular.copy(data.data, $scope.detail);           		
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
	
	$(document).ready(function () {
		if ($scope.id) {
			console.log($scope.id);
			$scope.loadOne();
			$('#loading').hide();
		}
		else {
			$scope.loadBuildings();
		}
		$('#overing').hide();
	});	
	
}]);