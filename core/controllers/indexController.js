;(function () {
    'use-strict';
    angular.module("Ponto").controller('indexController', function ($scope, $location, API) {

        var check = function(){
            API.checkLogin().then(function(response){
                if(!response.data.status){
                    Materialize.toast('Seu tempo expirou.', 3000);
                    logout();
                }
            });
        };
        check();
        
        var logout = function(){
            API.logout().then(function(response){
                if(response.data.status){
                    Materialize.toast('Deslogado com sucesso.', 1000);
                    $location.path('/login');
                }
            });
        }

        $scope.sair = function () {
            logout();
        };
    });
})();