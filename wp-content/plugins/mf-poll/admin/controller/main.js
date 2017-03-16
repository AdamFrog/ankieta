mfpoll_app.controller('MainController', function($scope, $route, $routeParams, $location, Poll) {
        $scope.page_load = true;
        
	$scope.$route = $route;
	$scope.$location = $location;
	$scope.$routeParams = $routeParams;

	//$scope.menu = MFPOLL_CONFIG['plugin_url'] + 'media/js/html/menu.html';
        
        $scope.polls = [];
        
        Poll.list(function(data){
            $scope.polls = data.polls;
            console.log($scope.polls);
            $scope.page_load = false;
        });
});