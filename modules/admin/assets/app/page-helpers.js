function pageInit(scope, filter) {
	if (!scope.sortingOrder) {
		scope.sortingOrder = '';
	}
	if (!scope.reverse) {
		scope.reverse = false;
	}
	scope.orderBy = ''; //排序字段

	scope.pagedItems = []; //记录集
	scope.recordCount = 0; //总记录数
	scope.currentPage = 1; //当前页号

	// set default if not passed in
	if (!scope.itemsPerPage) {
		scope.itemsPerPage = 16; //每页显示记录数
	}

	/*
	获取记录
	 */
	scope.getPage = function() {
		scope.load();
	};

	/*
	设置翻页
	 */
	scope.setPage = function(page) {
		scope.currentPage = page;
		scope.getPage();
	};

	/*
	读取记录
	 */
	scope.setPagedItems = function(data) {
		scope.recordCount = data.data[0].content[0];
		if (scope.recordCount > 0) {
			data.data[0].content.splice(0, 1); //清除第一个记录数
			//深度拷贝记录
			angular.copy(data.data, scope.pagedItems);
		} else {
			scope.pagedItems = [];
		}
		scope.rowSpinOff(scope.pagedItems);
	}

	/*
	    排序
	 */
	scope.sort_by = function(newSortingOrder, e) {
		if (scope.sortingOrder == newSortingOrder)
			scope.reverse = !scope.reverse;

		scope.sortingOrder = newSortingOrder;

		scope.orderBy = scope.sortingOrder + ' asc';
		if (scope.reverse) { //降序
			scope.orderBy = scope.sortingOrder + ' desc';
		}
		scope.getPage();
	};

	scope.rowSpinOff = function(items) {
		/*if (items.length > 0) {
			$('#tr-spinner').hide();
		} else {
			$('#tr-spinner').show();
			$('#div-spinner').html(BlogAdmin.i18n.empty);
		}*/
	}

	scope.getPage();
}