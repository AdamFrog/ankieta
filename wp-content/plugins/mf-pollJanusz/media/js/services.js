
(function () {

  var apps = angular.module('mfpoll_services', []);

  apps.factory('getQ', ['$http', function($http, $scope){

    var _getPolls = function(callback){

        callback = callback||function(){};//zabezpieczenie -jezeli nie ma callbacka to zwroci pusta funkcje
        $http.get(PLUGIN_URL + '/api.php?controller=mfpoll&action=getpolls') //pobranie klientow z udostepnionego api
             .then(function (data) {
               callback(data);

             }, function(data) {
              //Second function handles error
              console.log("Problem z pobraniem ankiet");
          });

    };
    var _getQuestions = function(poll_id, callback){

        callback = callback||function(){};//zabezpieczenie -jezeli nie ma callbacka to zwroci pusta funkcje
        $http.get(PLUGIN_URL + '/api.php?controller=mfpoll&action=getquestions&pollid='+poll_id) //pobranie klientow z udostepnionego api
             .then(function (data) {
               callback(data);
             }, function(data) {
              //Second function handles error
              console.log("Problem z pobraniem pytań");
          });
    };

    //zwraca obiekt
    return {
        getQuestions: _getQuestions,
        getPolls: _getPolls
    };

}]);

})();
