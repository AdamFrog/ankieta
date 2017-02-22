mfpoll_app.controller('AddController', function($scope, $routeParams, $location) {

	$scope.config = MFPOLL_CONFIG;

	$scope.name = 'AddController';
	$scope.params = $routeParams;
	$scope.selectedType = '';
	$scope.poll_add_options = '';
	$scope.title = null;
	$scope.show_title = false;
	$scope.select_copy_show = false;

	$scope.check_poll_add_options = function(){
		if($scope.poll_add_options === true){
			return true;
		}
		return false;
	};

	$scope.set_title = function(title){
		$scope.title = title;
		$scope.show_title = true;
	};

	$scope.$watch('poll_add_options', function(newValue, oldValue) {

	  	if(newValue == 'new'){
	  		$scope.show_title = true;
	  		$scope.title = null;
	  		$scope.select_copy_show = false;
	  	}else if(newValue !== ''){
	  		$scope.show_title = false;
	  		$scope.select_copy_show = true;
	  	}

	});

	$scope.$watch('selectedType', function(newValue, oldValue) {

	    $scope.poll_add_options = '';
	    $scope.title = null;
	    $scope.show_title = false;
	    $scope.select_copy_show = false;

	});

	$scope.submit_form = function() {
	//wysyłamy ajaxx z dodaniem
	$location.path('/edit/1');
	};

	});
