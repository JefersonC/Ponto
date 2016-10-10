;
(function () {
    'use-strict';
    angular.module("Ponto").controller('indexController', function ($scope, $location) {

        $scope.sair = function () {
            $location.path('/login');
        };

    });
})();