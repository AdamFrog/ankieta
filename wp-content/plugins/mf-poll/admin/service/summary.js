/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


mfpoll_app.service('Summary', function ($http, $httpParamSerializerJQLike) {
   
    this.get_summary_poll = function (poll_id, success) {
        $http({
            method: 'POST',
            url: MFPOLL_CONFIG.url +'/wp-content/plugins/mf-poll/application/bootstrap.php?controller=summary&action=get_summary_poll',
            data: 'poll_id='+ poll_id,
            //data: $httpParamSerializerJQLike({json: JSON.stringify(question)}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            success(response);
        }, function errorCallback(response) {
            success(response);
        });
    };
    
    this.get_summary_question = function (question_id, success) {
        $http({
            method: 'POST',
            url: MFPOLL_CONFIG.url +'/wp-content/plugins/mf-poll/application/bootstrap.php?controller=summary&action=get_summary_question',
            data: 'question_id='+ question_id,
            //data: $httpParamSerializerJQLike({json: JSON.stringify(question)}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            success(response);
        }, function errorCallback(response) {
            success(response);
        });
    };
    
    this.get_question_reply = function (question_id, offset, success) {
        $http({
            method: 'POST',
            url: MFPOLL_CONFIG.url +'/wp-content/plugins/mf-poll/application/bootstrap.php?controller=summary&action=get_question_reply',
            data: 'question_id='+question_id+'&offset='+offset,
            //data: $httpParamSerializerJQLike({json: JSON.stringify(question)}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            success(response);
        }, function errorCallback(response) {
            success(response);
        });
    };
 
});