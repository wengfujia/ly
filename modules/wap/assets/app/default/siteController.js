/**
 * 后台站点基础控制器
 */
function SiteInit(rootScope, scope,dataService) {
	scope.communityItems = []; 	//社区名称列表
	scope.buildingItems = [];	//楼宇名称列表
	scope.roomItems = [];		//楼宇房间列表
	scope.companyItems = [];	//企业名称列表
	scope.posts = []; //文章列表
	
	//获取社区名称列表
	scope.loadCommunities = function (condition, orderby) {
		var p = { username: session.getItem("uername"), body: condition+'\t'+orderby };
        dataService.getItems('admin/community/simple', p)
            .success(function (data) {
            	if (data.result == 0) {
            		angular.copy(data.data, scope.communityItems);
            	}
            	else if (data.data) {
            		toastr.error('获取社区信息出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取社区信息出错');
            	}
            })
            .error(function () {
                toastr.error('获取社区信息出错');
            });
	}
	
	//获取楼宇名称列表
	scope.loadBuildings = function (condition, orderby) {
		var p = { username: session.getItem("uername"), body: condition+'\t'+orderby };
        dataService.getItems('admin/building/simple', p)
            .success(function (data) {
            	if (data.result == 0) {
            		angular.copy(data.data, scope.buildingItems);
            	}
            	else if (data.data) {
            		toastr.error('获取楼宇列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取楼宇列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取楼宇列表出错');
            });
	}
	
	//获取房间列表
	//isexclude表示是否需要排除已租房间，1需要排除，0不需要
	scope.loadRooms = function (buildingid, floornum, isexclude) {
		var p = { username: session.getItem("uername"), body: buildingid+'\t'+floornum+'\t'+isexclude };
        dataService.getItems('admin/building/roomlist', p)
            .success(function (data) {
            	if (data.result == 0) {
            		angular.copy(data.data, scope.roomItems);
            	}
            	else if (data.data) {
            		toastr.error('获取房间列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取房间列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取房间列表出错');
            });
	}
	
	//获取企业名称列表
	scope.loadCompanies = function (condition, orderby) {
		var p = { username: session.getItem("uername"), body: condition+'\t'+orderby };
        dataService.getItems('admin/company/simple', p)
            .success(function (data) {
            	if (data.result == 0) {
            		angular.copy(data.data, scope.companyItems);
            	}
            	else if (data.data) {
            		toastr.error('获取企业列表出错,原因：' + data.data[0].content[0]);
            	}
            	else {
            		toastr.error('获取企业列表出错');
            	}
            })
            .error(function () {
                toastr.error('获取企业列表出错');
            });
	}
	
	//加载列表数据
	scope.loadPosts = function (category, page, pageSize) {
		var p = { 'category':category, 'page':page, 'pageSize':pageSize };
		dataService.getItems('wap/post/search', p)
            .success(function (data) {
            	angular.copy(data, scope.posts);
            	console.log(scope.posts);
            })
            .error(function () {
                toastr.error('获取文章列表失败');
            });
	}
	
	/*
    	上传
    */
	scope.uploadFile = function (action, files) {
        var fd = new FormData();
        fd.append("file", files[0]);

        dataService.uploadFile("/file/upload&action=" + action, fd)
        .success(function (data) {
            toastr.success(rootScope.lbl.uploaded);
            alert(data);
            //反射函数
            scope.uploaded(data);
        })
        .error(function () { toastr.error('上传出错'); });
    }
    
	//正规取图片
	scope.getImageSrc = function (html) {
		//匹配图片（g表示匹配所有结果i表示区分大小写）
		var imgReg = /<img.*?(?:>|\/>)/gi;
		//匹配src属性
		var srcReg = /src=[\'\"]?([^\'\"]*)[\'\"]?/i;
		var arr = html.match(imgReg);
		for (var i = 0; i < arr.length; i++) {
			var src = arr[i].match(srcReg);
			//获取图片地址
			return src[1];
			
			/*if(src[1]){
				alert('已匹配的图片地址'+(i+1)+'：'+src[1]);
			}
			//当然你也可以替换src属性
			if (src[0]) {
				var t = src[0].replace(/src/i, "href");
				//alert(t);
			}*/
		}
		return '';
	}
}
