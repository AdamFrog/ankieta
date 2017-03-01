/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


mfpoll_app.service('Poll', function ($http, $httpParamSerializerJQLike) {
   
    this.add = function (poll, success) {
        $http({
            method: 'POST',
            url: 'http://localhost/wordpress/wp-content/plugins/mf-poll/application/bootstrap.php?controller=poll&action=add',
            data: $httpParamSerializerJQLike(poll),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            success(response.data);
        }, function errorCallback(response) {
            console.log(response);
            console.log('Coś poszło nie tak! - Poll/add');
        });
    };
    
    this.get = function (poll_id, success) {
        $http({
            method: 'POST',
            url: 'http://localhost/wordpress/wp-content/plugins/mf-poll/application/bootstrap.php?controller=poll&action=get',
            data: 'poll_id='+ poll_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            success(response.data);
        }, function errorCallback(response) {
            console.log(response);
            console.log('Coś poszło nie tak! - Poll/get');
        });
    };
    
    this.save = function (poll, success) {
        $http({
            method: 'POST',
            url: 'http://localhost/wordpress/wp-content/plugins/mf-poll/application/bootstrap.php?controller=poll&action=save',
            data: $httpParamSerializerJQLike(poll),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            console.log(response);
            success(response.data);
        }, function errorCallback(response) {
            console.log(response);
            console.log('Coś poszło nie tak! - Poll/save');
            
        });
    };
    
});