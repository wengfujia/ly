/**
 * 文章管理控制器
 */
angular.module('blogAdmin').controller('PostController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.id = getUrlParam('id'); //获取文章id
	$scope.post = [];
	
	$scope.page = 1;
	$scope.pageSize = 13;
	$scope.category = getUrlParam('category'); //分类标题
	$scope.posts = [];	

	function isUserAtBottom() {
		return ((($(document).height() - $(window).height()) - $(window).scrollTop()) <= 50) ? true : false;
	}
	
	// 随机数
	function getRandom(n) {
		return Math.floor(Math.random() * n + 1)
	}
	
	//获取文章详情
	$scope.loadPost = function () {
        var url = 'wap/post/view?id=' + $scope.id;
        console.log(url);
        dataService.getItems(url)
        .success(function (data) {
        	angular.copy(data, $scope.post);
        	$("#txtContent").html($scope.post.PostContent);
        })
        .error(function () {
            toastr.error('加载文章出错');
        });
    }
	
	//加载新闻列表
	$scope.loadPosts = function () {		
		var p = { 'category':$scope.category, 'page':$scope.page, 'pageSize':$scope.pageSize };
		dataService.getItems('wap/post/search', p)
            .success(function (data) {
            	var items = [];
            	angular.copy(data, items);
            	if (items.length<=0) {
        			$('#overing').show();
        			$('#loading').hide();
        			return;
        		}
            	
            	//添加记录集
        		for (var i = 0; i < items.length; i++) {
                    $scope.posts.push(items[i]);
                }
                $scope.page++; //页号增加
                
                $('#loading').hide();
    			$(window).scroll($scope.loadPosts);
    			$('.list-2 img').eq(0).css('margin-left', '0px');
    			
            })
            .error(function () {
                toastr.error('获取文章列表失败');
            });
	}

	$(document).ready(function () {
		if ($scope.id) {
			$scope.loadPost();
			$('#loading').hide();
		}
		else if ($scope.category) {
			$scope.loadPosts();
			$(window).scroll($scope.loadPosts);		
		}
		$('#overing').hide();
	});
	
	//公用

	/*
	 * 长整型转日期
	 * times基础值
	 * diff差值
	 * */
	$scope.longToDate = function (times, diff) {
    	if (isNaN(diff)) {
    		return '';
    	}
    	
    	var longs = parseInt(times)*diff;
		return new Date(longs).Format('yyyy-MM-dd hh:mm:ss');
	}
    
}]);

