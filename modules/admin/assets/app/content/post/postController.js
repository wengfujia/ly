/**
 * 文章管理控制器
 */
angular.module('blogAdmin').controller('PostController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.items = [];

	//加载列表数据
	$scope.load = function () {
		dataService.getItems('admin/post/index')
            .success(function (data) {
            	angular.copy(data, $scope.items);
				gridInit($scope, $filter);
            })
            .error(function () {
                toastr.error('获取文章列表失败');
            });
	}
	$scope.load();
	
	$(document).ready(function () {
		
	});
	
	//删除文章
	$scope.del = function (id) {		
		if (confirm("确定要删除吗？") == false) {
			return false;
		}

        dataService.getItems('admin/post/delete?id='+id)
            .success(function (data) {
            	toastr.success('删除成功');
        		//从缓存中删除记录
        		for (var i=0; i<$scope.pagedItems.length; i++) {
        			if ($scope.pagedItems[i].PostID == id) {
        				$scope.pagedItems.splice(i, 1);
        				break;
        			}
        		}
            })
            .error(function () {
                toastr.error('删除失败');
            });
	}
	
}]);
