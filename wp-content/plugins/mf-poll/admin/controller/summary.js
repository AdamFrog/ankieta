mfpoll_app.controller('SummaryController', function ($scope, $routeParams, Poll, Summary) {
    
    $scope.page_load = true;
    
    $scope.config = MFPOLL_CONFIG;    
    $scope.params = $routeParams;
    
    $scope.poll = {};
    
    Poll.get($scope.params.id, function(data){
        $scope.poll = data;
        console.log($scope.poll);
        
        Summary.get_summary_poll($scope.poll.id, function(response){
            console.log(response);
            $scope.summary = response.data.steps;
            $scope.page_load = false;
        });
        
    });
    
    $scope.getTemplate = function(type){
        return MFPOLL_CONFIG['plugin_url'] + '/admin/view/summary/single_choice.html';
    };
    
    
});

mfpoll_app.component('questionSummary', {
    templateUrl: MFPOLL_CONFIG['plugin_url'] + 'admin/view/summary/index.html',
    controller: function ($scope, Question, Summary) {
        
        $scope.reply = {
            offset: 0,
            load: false,
            items: [],
            no_more_reply: false,
        };
        
        $scope.summary = [];
        $scope.question = this.question;
        
        //Pobieramy odpowiedzi
        Summary.get_summary_question($scope.question.id, function(response){
            $scope.result = response.data;
            console.log('Pytanie: ' + $scope.question.id);
            console.log($scope.result);
        });
        
        $scope.getTemplate = function () {
            
            return MFPOLL_CONFIG['plugin_url'] + '/admin/view/summary/'+$scope.question.type+'.html';
        };
        
        $scope.getReply = function(){
            $scope.reply.load = true;
            Summary.get_question_reply($scope.question.id, $scope.reply.offset, function(response){
                $scope.reply.offset = $scope.reply.offset + 10;
                angular.forEach(response.data.items, function(value, key) {
                    $scope.reply.items.push(value);
                });
                $scope.reply.load = false;
                if(response.data.items.length === 0 || response.data.items.length < 10){
                    $scope.reply.no_more_reply = true;
                }
            });
        }
        
        $scope.getVar = function(value){
            if(value === undefined || value === ''){
                return 0;
            }
            return value;
        }

    },
    bindings: {
        question: '='
    }
});