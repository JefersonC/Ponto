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
})();


