/**
 * 用户管理控制器
 */
angular.module('blogAdmin').controller('SecurityController', ["$rootScope", "$scope", "$location", "$http", "$filter", "dataService", function ($rootScope, $scope, $location, $http, $filter, dataService) {
	$scope.roles = [];
	$scope.permissions = [];
	$scope.users = [];
	
	$scope.isEditItem = false;
	//权限管理字段
	$scope.securityTitle = '';
	
	$scope.userid = '';
	//用户新增字段
	$scope.nickname = '';
	$scope.username = '';
	$scope.passwrd = '';
	$scope.passwrd_repeat = '';
	$scope.role = '';
	
	$scope.old_password = '';
	
	//加载角色列表
	$scope.loadRoles = function () {
		dataService.getItems('admin/security/list')
            .success(function (data) {
            	angular.copy(data, $scope.roles);
            })
            .error(function () {
                toastr.error('获取角色列表出错');
            });
	}
	
	//加载权限列表
	$scope.loadPermissions = function (roleName) {
		dataService.getItems('admin/security/permissions?roleName='+roleName)
            .success(function (data) {
            	angular.copy(data, $scope.permissions);
            })
            .error(function () {
                toastr.error('获取权限列表出错');
            });
	}
	
	//加载用户列表
	$scope.loadUsers = function () {
		dataService.getItems('admin/account/index')
            .success(function (data) {
            	angular.copy(data, $scope.users);
            })
            .error(function () {
                toastr.error('获取用户列表出错');
            });
	}
	
	$(document).ready(function () {
		$scope.loadRoles();
		var url = window.location.href;
		if (url.indexOf("cate5.1")>0) { //用户添加
			$scope.loadUsers();
		}
	});
	
	/*
	 * 信息操作
	 * */
	$scope.saveUser = function () {
		console.log($scope.passwrd_repeat);
		console.log($scope.passwrd);
		console.log($scope.username);
		
		if (empty($scope.username)) {
			toastr.error('用户名不能为空');
			return;
		}
		if (empty($scope.passwrd)) {
			toastr.error('密码不能为空');
			return;
		}
		if ($scope.passwrd.length <8) {
			toastr.error('密码长度必须8位以上');
			return;
		}
		if ($scope.passwrd != $scope.passwrd_repeat) {
			toastr.error('两次输入的密码不一不致');
			return;
		}
		
		var roleName = $('#role').val();
		var p = {
			'nickname' : $scope.nickname,
			'username' : $scope.username,
			'password' : $scope.passwrd,
			'password_repeat' : $scope.passwrd_repeat,
			'email' : $scope.username+'@sina.com',
			'role' : roleName
		};
        dataService.addItem('admin/account/register', p)
            .success(function (data) {
            	if (data.result == 0) {
            		toastr.success('注册成功');
            	}
            	else {
            		toastr.error('注册失败');
            	}
            })
            .error(function () {
                toastr.error('注册失败');
            });
	}
	
	//更新用户
	$scope.updateUser = function () {
		if (empty($scope.userid)) {
			toastr.error('请选择要修改的用户');
			return false;
		}
		var roleName = $('#role').val();
		if (roleName === '') {
			toastr.error('请选择权限');
			return false;
		}
		
		var p = {
			'nickname' : $scope.nickname,
			'username' : $scope.username,
			'email' : $scope.username+'@sina.com',
			'status': 1,
			'role' : roleName
		};
        dataService.addItem('admin/account/update?id='+$scope.userid, p)
            .success(function (data) {
            	if (data.result == 0) {
            		toastr.success('保存成功');
            	}
            	else {
            		toastr.error('保存失败');
            	}
            })
            .error(function () {
                toastr.error('保存失败');
            });
	}
	
	/*
	 * 删除用户
	 * */
	$scope.delUser = function (id) {
		if (confirm("确定要删除吗？") == false) {
			return false;
		}
		
		dataService.getItems('admin/account/delete?id='+id)
        .success(function (data) {
        	toastr.success('删除成功');
    		//从缓存中删除记录
    		for (var i=0; i<$scope.users.length; i++) {
    			if ($scope.users[i].id == id) {
    				$scope.users.splice(i, 1);
    				break;
    			}
    		}
        })
        .error(function () {
            toastr.error('删除失败');
        });
	}
	
	//保存权限信息
	$scope.saveRole = function () {
		if ($scope.securityTitle == "") {
			toastr.error('权限名称不能为空');
			return;
		}
		
		var limit = '';
		$('input[name="power"]:checked').each(function(){
			var value=$(this).val();
			limit += '|'+value;
		});

		var p = {'name': $scope.securityTitle, 'items': limit};
        dataService.addItem('admin/security/save', p)
            .success(function (data) {
            	toastr.success('权限保存成功');
            })
            .error(function () {
                toastr.error('权限保存失败');
            });
	}
	
	/*
	 * 删除角色
	 * */
	$scope.delRole = function (name) {
		if (confirm("确定要删除吗？") == false) {
			return false;
		}
		
		dataService.getItems('admin/security/delete?roleName='+name)
        .success(function (data) {
        	toastr.success('删除成功');
    		//从缓存中删除记录
    		for (var i=0; i<$scope.roles.length; i++) {
    			if ($scope.roles[i].name == name) {
    				$scope.roles.splice(i, 1);
    				break;
    			}
    		}
        })
        .error(function () {
            toastr.error('删除失败');
        });
	}
	
	//修改密码
	$scope.changePassword = function () {
		if ($scope.passwrd != $scope.passwrd_repeat) {
			toastr.error('两次密码输入不一致');
			return;
		}
		
		var p = {'password': $scope.passwrd, 'old_password': $scope.old_password};
        dataService.addItem('admin/account/changepassword', p)
            .success(function (data) {
            	if (data.result == 0) {
            		toastr.success('密码修改成功');
            	}
            	else {
            		toastr.error('密码修改失败');
            	}
            })
            .error(function () {
                toastr.error('密码修改失败');
            });
	}
	
	/*
	 * 窗体显示
	 * */
	//显示新建窗体
	$scope.loadUserAddForm = function () {
		$scope.isEditItem = true;
		$scope.username = '';
		$scope.nickname = '';
		$("#modal-edit-show").modal();
	}
	
	//显示修改窗体
	$scope.loadUserEditForm = function (id) {
		$scope.isEditItem = false;
		for (var i=0; i<$scope.users.length; i++) {
			var user = $scope.users[i];
			if (user.id === id) {
				$scope.userid = id;
				$scope.username = user.username;
				$scope.nickname = user.nickname;
				//设置权限
				$("#role option[value='"+user.role+"']").prop("selected", 'selected');
				
				break;
			}
		}
		$("#modal-edit-show").modal();
	}
	
	//显示新建角色窗体
	$scope.loadRoleAddForm = function () {
		$scope.isEditItem = true;
		$('input[name="power"]:checked').prop("checked", false);
		$("#modal-edit-show").modal();
	}
	
	//显示修改角色窗体
	$scope.loadRoleEditForm = function (name) {
		$scope.isEditItem = false;
		$scope.securityTitle = name;
		$('input[name="power"]:checked').prop("checked", false);
		
		dataService.getItems('admin/security/permissions?roleName='+name)
        .success(function (data) {
        	angular.copy(data, $scope.permissions);
        	for (var i=0; i<$scope.permissions.length; i++) {
        		var permission = $scope.permissions[i];
        		$("input:checkbox[value='"+permission.name+"']").prop('checked','checked');
        	}
        	$("#modal-edit-show").modal();
        })
        .error(function () {
            toastr.error('获取权限列表出错');
        });
	}
	
}]);