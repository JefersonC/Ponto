;(function(){
    'use-strict';
    angular.module("Ponto").controller('loginController', function($scope, $location, API){
        
        $scope.login = {};
        
        $scope.logar = function(form){
            logar(form);
        };
        
        var logar = function(form){
            if(form.$valid){
                API.login($scope.login).then(function(response){
                    if(response.data.status){
                        $location.path('/');  
                        Materialize.toast('Logado!', 3000);
                    }else{
                        Materialize.toast(response.data.message, 3000);
                    }
                });
            }else{
                Materialize.toast('Dados inválidos.', 3000);
            }
        }
        
    });
})();