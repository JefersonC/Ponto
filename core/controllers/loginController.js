;(function(){
    'use-strict';
    angular.module("Ponto").controller('loginController', function($scope, $location){
        
        $scope.logar = function(){
            $location.path('/');
        };
        
    });
})();