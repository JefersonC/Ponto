angular.module('Ponto').filter('bddate', function ($filter) {
    return function (date, format) {
        var formatDate = format ? format : "dd/MM/yyyy";
        if (!date) {
            return;
        }
        if (!angular.isDate(date)) {
            var temp = new Date(date);
            date = new Date(
                    temp.getUTCFullYear(), 
                    temp.getUTCMonth(), 
                    temp.getUTCDate(),
                    temp.getHours(),
                    temp.getMinutes(),
                    temp.getSeconds()
            );
        }
        return $filter('date')(date, formatDate);
    };
});