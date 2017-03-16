/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


mfpoll_app.service('Question', function ($http, $httpParamSerializerJQLike) {
   
    
    this.get_html = function (question, success) {
        $http({
            method: 'POST',
            url: MFPOLL_CONFIG.url +'/wp-content/plugins/mf-poll/application/bootstrap.php?controller=question&action=index',
            data: $httpParamSerializerJQLike(angular.copy(question)),
            //data: $httpParamSerializerJQLike({json: JSON.stringify(question)}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            console.log(response);
            success(response);
        }, function errorCallback(response) {
            console.log(response);
            success(response);
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };
    
    
    this.saveForms = function(model, success) {
        console.log(model);
        angular.forEach(model, function (value, key) {
            alert('param 1' + param(value));
        });
        $http({
            method: 'POST',
            url: MFPOLL_CONFIG.url +'/wp-content/plugins/mf-poll/application/bootstrap.php?controller=question&action=save',
            data: param(model),
            //data: $httpParamSerializerJQLike({json: JSON.stringify(question)}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
           alert(response.data);
        }, function errorCallback(response) {
            console.log(response);
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };

});