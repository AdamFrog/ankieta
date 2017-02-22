mfpoll_app.controller('MainController', function($scope, $route, $routeParams, $location, getQ) {
	$scope.$route = $route;
	$scope.$location = $location;
	$scope.$routeParams = $routeParams;

	$scope.polls = [];
	/*getQ.getPolls(function (getQ) {
            $scope.polls = getQ.data;
            console.log(getQ.data);
	});*/


	$scope.menu = PLUGIN_URL + '/media/js/html/menu.html';

});
