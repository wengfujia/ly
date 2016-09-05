/**
 * 布局管理控制器
 */
angular.module('blogAdmin').controller('LayoutsController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	
	//初始化后台站点控制器
	SiteInit($rootScope, $scope, dataService);
	
	$(document).ready(function () {
		
	});

}]);