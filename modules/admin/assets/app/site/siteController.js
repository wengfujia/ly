/**
 * 后台站点基础控制器
 */
function SiteInit(rootScope, scope,dataService) {
	scope.communityItems = []; 	//社区名称列表
	scope.buildingItems = [];	//楼宇名称列表
	scope.roomItems = [];		//楼宇房间列表
	scope.companyItems = [];	//企业名称列表
	
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
    
	//获取权限
	scope.checkPermission = function (permission) {
		if (Settings.rights.indexOf(permission)>=0) 
			return true;
		return false;
	}
	
}
