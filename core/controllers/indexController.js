;
(function () {
    'use-strict';
    angular.module("Ponto").controller('indexController', function ($scope, $location, API, $timeout, $filter) {

        $scope.load = false;

        var check = function () {
            API.checkLogin().then(function (response) {
                if (!response.data.status) {
                    Materialize.toast('Seu tempo expirou.', 3000);
                    logout();
                }
            });
        };
        check();

        var logout = function () {
            API.logout().then(function (response) {
                if (response.data.status) {
                    Materialize.toast('Deslogado com sucesso.', 1000);
                    $location.path('/login');
                }
            });
        }

        $scope.sair = function () {
            logout();
        };


        var getPontos = function () {
            $scope.load = true;
            $scope.pontos = null;

            var param = {
                date: $filter('date')($scope.currentDate, 'yyyy-MM-dd')
            };

            API.getPontos(param).then(function (response) {
                if (response.data.status) {
                    $scope.pontos = response.data.content;
                    $timeout(function () {
                        $('.collapsible').collapsible({});
                    });
                } else {
                    Materialize.toast(response.data.message, 3000);
                }
                $scope.load = false;
            });
        };

        var getPontosAtual = function () {
            $scope.currentDate = new Date();
            getPontos();
        };

        $scope.prevMonth = function () {
            var temp = new Date($scope.currentDate);
            $scope.currentDate = temp.setMonth(temp.getMonth() - 1);
            getPontos();
        };

        $scope.nextMonth = function () {
            var temp = new Date($scope.currentDate);
            $scope.currentDate = temp.setMonth(temp.getMonth() + 1);
            getPontos();
        };

        getPontosAtual();

        var getIndicadores = function () {
            $scope.load = true;
            $scope.indicadores = null

            API.getIndicadores().then(function (response) {
                if (response.data.status) {
                    $scope.indicadores = response.data.content;
                } else {
                    Materialize.toast(response.data.message, 3000);
                }
                $scope.load = false;
            });
        };

        getIndicadores();

        $scope.fechar = function () {
            $scope.load = true;

            API.fecharPonto().then(function (response) {
                console.log(response);
                if (response.data.status) {
                    getIndicadores();
                    getPontosAtual();
                } else {
                    Materialize.toast(response.data.message, 3000);
                }
                $scope.load = false;
            });
        };

        $scope.abrir = function () {
            $scope.load = true;

            API.abrirPonto().then(function (response) {
                if (response.data.status) {
                    getIndicadores();
                    getPontosAtual();
                } else {
                    Materialize.toast(response.data.message, 3000);
                }
                $scope.load = false;
            });
        };

    });
})();