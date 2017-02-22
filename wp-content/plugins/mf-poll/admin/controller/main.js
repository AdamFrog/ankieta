mfpoll_app.controller('MainController', function($scope, $route, $routeParams, $location) {
	$scope.$route = $route;
	$scope.$location = $location;
	$scope.$routeParams = $routeParams;

	$scope.menu = MFPOLL_CONFIG['plugin_url'] + 'media/js/html/menu.html';

});