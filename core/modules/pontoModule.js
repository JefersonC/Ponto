;
(function () {
    'use-strict';
    angular.module("Ponto", ["ngRoute", "ngAnimate"]);
    angular.module("Ponto").config(function ($routeProvider) {
        $routeProvider
                .when("/", {
                    templateUrl: "core/views/index.html",
                    controller: 'indexController'
                })
                .when("/login", {
                    templateUrl: "core/views/login.html",
                    controller: 'loginController'
                }).otherwise({
            redirectTo: '/'
        });
      });

    angular.module("Ponto").run(function ($rootScope, $templateCache) {
        $rootScope.$on('$viewContentLoaded', function () {
            $templateCache.removeAll();
        });
    });
})();


