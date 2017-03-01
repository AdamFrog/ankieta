mfpoll_app.controller('AddController', function ($scope, $routeParams, $location, Poll) {

    $scope.config = MFPOLL_CONFIG;

    $scope.name = 'AddController';
    $scope.params = $routeParams;
    $scope.selectedType = '';
    $scope.poll_add_options = '';
    $scope.title = null;
    $scope.show_title = false;
    $scope.select_copy_show = false;

    $scope.check_poll_add_options = function () {
        if ($scope.poll_add_options == true) {
            return true;
        }
        return false;
    };

    $scope.set_title = function (title) {
        $scope.title = title;
        $scope.show_title = true;
    };

    $scope.$watch('poll_add_options', function (newValue, oldValue) {

        if (newValue == 'new') {
            $scope.show_title = true;
            $scope.title = null;
            $scope.select_copy_show = false;
        } else if (newValue != '') {
            $scope.show_title = false;
            $scope.select_copy_show = true;
        }

    });

    $scope.$watch('selectedType', function (newValue, oldValue) {

        $scope.poll_add_options = '';
        $scope.title = null;
        $scope.show_title = false;
        $scope.select_copy_show = false;

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

});
