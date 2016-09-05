(function () {
    var app = angular.module("blogAdmin", ['bw.paging', 'ngRoute']);   

    /*app.config(function ($sceDelegateProvider) {
        $sceDelegateProvider.resourceUrlWhitelist([
            // Allow same origin resource loads.
            'self',
            // Allow loading from our assets domain.  Notice the difference between * and **.
            'http://wap.hzxsga.gov.cn/**']);
    });*/
    
    app.config(function($sceProvider) {
    	  // Completely disable SCE to support IE7.
    	  $sceProvider.enabled(false);
    	});
    
    var config = ["$routeProvider", function ($routeProvider) {      
        $routeProvider
	        .when("/", { templateUrl: Settings.templateUrl+"/site/wellcome.html" }) //../admin/index.html
	
	        .when("/community/cate1.0", { templateUrl: Settings.templateUrl+"/community/cate1.0.html" })
	        //.when("/community/cate1.1", { templateUrl: "app/community/cate1.1.html" })
			
	        .when("/building/cate2.0", { templateUrl: Settings.templateUrl+"/building/cate2.0.html" })
	        .when("/building/cate2.1", { templateUrl: Settings.templateUrl+"/building/cate2.1.html" })
			//.when("/building/cate2.2", { templateUrl: "app/building/cate2.2.html" })
	        .when("/building/cate2.3", { templateUrl: Settings.templateUrl+"/building/cate2.3.html" })
	        .when("/building/cate2.4", { templateUrl: Settings.templateUrl+"/building/cate2.4.html" })
	        
	        .when("/company/cate3.0", { templateUrl: Settings.templateUrl+"/company/cate3.0.html" })
	        .when("/company/cate3.1", { templateUrl: Settings.templateUrl+"/company/cate3.1.html" })
	        .when("/company/cate3.2", { templateUrl: Settings.templateUrl+"/company/cate3.2.html" })
	        
	        .when("/content/cate4.1", { templateUrl: Settings.templateUrl+"/content/category/cate4.1.html" })
	        .when("/content/cate4.2", { templateUrl: Settings.templateUrl+"/content/post/cate4.2.html" })
	        .when("/content/cate4.3", { templateUrl: Settings.templateUrl+"/content/house/cate4.3.html" })
	        .when("/content/cate4.4", { templateUrl: Settings.templateUrl+"/content/house/cate4.4.html" })
	        .when("/content/cate4.5", { templateUrl: Settings.templateUrl+"/content/book/cate4.5.html" })
	        
	        .when("/security/cate5.0", { templateUrl: Settings.templateUrl+"/security/cate5.0.html" })
	        .when("/security/cate5.1", { templateUrl: Settings.templateUrl+"/security/cate5.1.html" })
	        .when("/security/cate5.2", { templateUrl: Settings.templateUrl+"/security/cate5.2.html" })
	        .when("/security/cate5.3", { templateUrl: Settings.templateUrl+"/security/cate5.3.html" })

	        .otherwise({ redirectTo: "/" });
    }];
    app.config(config);
    
    /*app.directive('focusMe', ['$timeout', function ($timeout) {
        return function (scope, element, attrs) {
            scope.$watch(attrs.focusMe, function (value) {
                if (value) {
                    $timeout(function () {
                        element.focus();
                    }, 700);
                }
            });
        };
    }]);*/

    var run = ["$rootScope", "$log", function ($rootScope, $log) {

        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.backgroundpositionClass = 'toast-bottom-right';
    }];

    app.run(run);

})();
