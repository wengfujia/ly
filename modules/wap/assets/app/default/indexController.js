/**
 * 首页控制器
 */
angular.module('blogAdmin').controller('IndexController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.buildings = [];
	
	//初始化后台站点控制器
	SiteInit($rootScope, $scope, dataService);

	$scope.loadPosts('楼宇动态', 1, 4);
	
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
	$scope.loadBuildings();
	
	$(document).ready(function () {
		
	});
	
}]);
