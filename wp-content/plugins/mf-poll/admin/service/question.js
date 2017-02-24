/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


mfpoll_app.service('Question', function ($http) {
   
    
    this.get_html = function (question, success) {
        $http({
            method: 'POST',
            url: 'http://localhost/wordpress/wp-content/plugins/mf-poll/application/bootstrap.php?controller=question&action=index',
            data: question
        }).then(function(response) {
            success(response);
        }, function errorCallback(response) {
            success(response);
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };
        
    this.sayHello = function () {
        return 'Hello, ' + _username;
    };
    
});