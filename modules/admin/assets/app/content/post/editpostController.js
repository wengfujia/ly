/**
 * 文章编辑管理控制器
 */
angular.module('blogAdmin').controller('EditPostController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.id = getUrlParam('id');
	
	$scope.categories = [];
	$scope.items = [];
	
	$scope.Post = newPost;
	$scope.isEditItem = false;

	var ue = UE.getEditor('editor'); 	//创建编辑器
	
	//初始化后台站点控制器
	SiteInit($rootScope, $scope, dataService);
	//加载社区信息
	$scope.loadCommunities('', '');
	
	//加载列表数据
	$scope.loadCategoies = function () {
		dataService.getItems('admin/category/index')
            .success(function (data) {
            	angular.copy(data, $scope.categories);
            })
            .error(function () {
                toastr.error('获取分类列表出错');
            });
	}
	$scope.loadCategoies();
	
	$(document).ready(function () {
		if ($scope.id) {
			$scope.loadPost($scope.id);
		}
	});
	
	//获取文章详情
	$scope.loadPost = function (id) {
        var url = 'admin/post/view?id=' + id;
        dataService.getItems(url)
        .success(function (data) {
        	angular.copy(data, $scope.Post);
            UE.getEditor('editor').setContent($scope.Post.PostContent);
            console.log($scope.Post);
			//设置选择 社区
            //console.log($scope.Post.CommunityID);
            //$("#selCommunity").find("option[value='"+$scope.Post.CommunityID+"']").attr("selected",true);
            
			// check post categories in the list
            /*if ($scope.Post.Categories != null) {
                for (var i = 0; i < $scope.Post.Categories.length; i++) {
                	var categoryId = $scope.Post.Categories[i].CategoryID;
                	$("input:checkbox[value='"+categoryId+"']").attr('checked','true');
                }
            }*/
        })
        .error(function () {
            toastr.error('加载文章出错');
        });
    }
	
	/*
	 * 信息操作
	 * */
	//保存文章
	$scope.save = function () {
		if ($scope.Post.Title.length == 0) {
            toastr.error('标题不能为空');
            return false;
        }
		
		$scope.Post.PostContent = UE.getEditor('editor').getContent();
		if ($scope.Post.PostContent.length == 0) {
            toastr.error('内容不能为空');
            return false;
        }
		
        //$scope.Post.Author = $scope.selectedAuthor.OptionValue;

        // get selected categories
        /*$scope.Post.Categories = [];
        if ($scope.categories != null) {
			$('input[name="categories"]:checked').each(function(){
				var catid=$(this).val();
				for (var i = 0; i < $scope.categories.length; i++) {
					var cat = $scope.categories[i];
					if (cat.CategoryID == catid) {
						var catAdd = { "CategoryID": cat.CategoryID, "CategoryName": cat.CategoryName };
						$scope.Post.Categories.push(catAdd);
					}
				}
			});
        } */
		
		$scope.Post.Categories = '';
        if ($scope.categories != null) {
			$('input[name="categories"]:checked').each(function(){
				var catid=$(this).val();
				$scope.Post.Categories += '|'+catid;
			});
        } 
        if ($scope.Post.Categories == '') {
        	toastr.error('请选择分类');
            return false;
        }
        $scope.Post.Categories = $scope.Post.Categories.substring(1);
        console.log($scope.Post.Categories);
        
        if ($scope.Post.PostID) {
            dataService.addItem('admin/post/update?id='+ $scope.Post.PostID, $scope.Post)
           .success(function (data) {
        	   toastr.success('文章更新成功');
           })
           .error(function () { toastr.error('文章更新失败'); });
        }
        else {        	
            dataService.addItem('admin/post/create', $scope.Post)
           .success(function (data) {
               toastr.success('文章新增成功');
               if (data) {
            	   $scope.Post.PostID = data;
               }
           })
           .error(function () { toastr.error('文章新增失败'); });
        }
	}
	
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
	
	//设置是否选中
	$scope.setChecked = function (id) {
		if ($scope.Post.Categories.indexOf(id)>=0) {
			return true;
		}
		else {
			return false;
		}
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

var newPost = {
    "PostId": "",
    "Title": "",
    "Author": "Admin",
    "PostContent": "",
    //"DateCreated": new Date().Format("yyyy-MM-dd hh:mm"),
    "CommunityID": "",
    "Categories": "",
    "IsCommentEnabled": true,
    "Status": 1
}
