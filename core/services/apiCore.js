;
(function () {
    'use-strict';
    angular.module("Ponto").service('API', function ($http) {

        var _api = '/Ponto/app/';

        this.checkLogin = function () {
            var url = _api + 'user/check';
            return $http.get(url);
        }

        this.logout = function () {
            var url = _api + 'user/logout';
            return $http.get(url);
        }

        this.login = function (credentials) {
            var url = _api + 'user/logar';
            return $http.post(url, credentials);
        }


    });
})();

