;
(function () {
    'use-strict';
    angular.module("Ponto").service('API', function ($http) {

        var _api = '/Ponto/app/';

        this.checkLogin = function () {
            var url = _api + 'user/check';
            return $http.get(url);
        };

        this.logout = function () {
            var url = _api + 'user/logout';
            return $http.get(url);
        };

        this.login = function (credentials) {
            var url = _api + 'user/logar';
            return $http.post(url, credentials);
        };

        this.getPontos = function(mes){
            var url = _api + 'ponto/pontos';
            return $http.post(url, mes);
        };
        
        this.getIndicadores = function(){
            var url = _api + 'ponto/indicadores';
            return $http.get(url);
        };
        
        this.fecharPonto = function(){
            var url = _api + 'ponto/fechar';
            return $http.get(url);
        };
        
        this.abrirPonto = function(){
            var url = _api + 'ponto/abrir';
            return $http.get(url);
        };

    });
})();

