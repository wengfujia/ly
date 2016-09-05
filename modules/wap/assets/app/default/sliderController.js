/**
 * 滚动控制器
 */
angular.module('blogAdmin').controller('SliderController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	
	//初始化后台站点控制器
	SiteInit($rootScope, $scope, dataService);

	$scope.loadPosts('移动滚动', 1, 5);
	
	$(document).ready(function () {
		
	});
	
}]);

