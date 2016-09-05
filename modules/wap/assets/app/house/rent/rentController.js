/**
 * 出租房源管理控制器
 */
angular.module('blogAdmin').controller('RentController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.items = [];
	
	function isUserAtBottom() {
		return ((($(document).height() - $(window).height()) - $(window).scrollTop()) <= 50) ? true : false;
	}
	
	// 随机数
	function getRandom(n) {
		return Math.floor(Math.random() * n + 1)
	}
	
	//加载列表数据
	$scope.load = function () {
		//计算是否还有数据
		$left = $scope.recordCount - $scope.currentPage*5;
		if ($left<=0) {
			$('#overing').show();
			$('#loading').hide();
			return;
		}
		
		var p = { username: 'guest', body: '\t'+ $scope.orderBy+'\t'+$scope.recordCount+'\t'+$scope.currentPage+'\t5' };
        dataService.getItems('admin/rent/list', p)
            .success(function (data) {
            	if (data.result == 0) {
            		$scope.setPagedItems(data);
            		//添加记录集
            		for (var i = 0; i < pagedItems.length; i++) {
                        $scope.items.push(pagedItems[i]);
                    }
                    $scope.recordCount++; //页号增加
                    $('#loading').hide();
    				$(window).scroll($scope.loadPage);
    				$('.list-2 img').eq(0).css('margin-left', '0px');
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
	
	//加载页面
	$scope.loadPage = function () {
		$scope.setPage($scope.recordCount);
	}
	
	$(document).ready(function () {
		$(window).scroll($scope.loadPage);
		$('#overing').hide();
	});

}]);
