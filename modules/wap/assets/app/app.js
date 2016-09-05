(function () {
    var app = angular.module("blogAdmin", ['ngRoute']);   

    
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
	        .when("/", { templateUrl: Settings.templateUrl+"/default/index.html" })	
	        .when("/content/post/show", { templateUrl: Settings.templateUrl+"/content/post/show.html" })
	        .when("/content/post/list", { templateUrl: Settings.templateUrl+"/content/post/list.html" })
	        .when("/building/list", { templateUrl: Settings.templateUrl+"/building/list.html" })
	        .when("/building/show", { templateUrl: Settings.templateUrl+"/building/show.html" })
	        .when("/house/rent/list", { templateUrl: Settings.templateUrl+"/house/rent/rent.html" })
	        
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
