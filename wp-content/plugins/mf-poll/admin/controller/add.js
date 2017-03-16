mfpoll_app.controller('AddController', function ($scope, $routeParams, $location, $timeout, Poll) {
    $scope.page_load = true;
    $scope.config = MFPOLL_CONFIG;
    
    $scope.name = 'AddController';
    $scope.params = $routeParams;
    $scope.selectedType = null;
    $scope.title = null;
    $scope.show_title = false;


    $scope.set_title = function (title) {
        $scope.title = title;
        $scope.show_title = true;
    };


    $scope.$watch('selectedType', function (newValue, oldValue) {
        //$scope.title = null;
        if(newValue !== null){
            $scope.show_title = true;
        }

    });

    $scope.submit_form = function () {
        var params = {
            title: $scope.title,
            type: $scope.selectedType
        };
        Poll.add(params, function(data){
            if(typeof data.id !== undefined){
                $location.path('/edit/' + data.id);
            }else{
                alert(mf_i18n.SOMTHINGS_IS_WRONG);
            }
        });
        //wysyłamy ajaxx z dodaniem 
        //$location.path('/edit/1');
    };
     $timeout(function(){$scope.page_load = false; }, 300);
});
