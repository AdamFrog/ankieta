mfpoll_app.controller('EditController', function($scope, $routeParams, $location) {

	$scope.config = MFPOLL_CONFIG;
	$scope.editing_elem = null;

	$scope.sortableOptions = {
    	update: function(e, ui){},
	    axis: 'y',
	    stop: function( event, ui ) {
	    },
	    placeholder: "sortable-placeholder",
	    connectWith: '.sortable-list',
	    start: function(e, ui){
	        ui.placeholder.height(ui.item.outerHeight());
	    }
  	};
	$scope.sortableOptionsPage = {
    	update: function(e, ui){},
	    axis: 'y',
	    stop: function( event, ui ) {
	    },
	    placeholder: "sortable-placeholder",
	    connectWith: '.sortable-page',
	    start: function(e, ui){
	        ui.placeholder.height(ui.item.outerHeight());
	    }
  	};
	
	$scope.name = 'EditController';
	$scope.params = $routeParams;

	$scope.questions = [[]];

	$scope.set_edit_element = function(elem){
		$scope.editing_elem = elem;
	};

	$scope.save_modal_add_question = function(type, attrs){
		
		$scope.questions[attrs.page][$scope.questions[attrs.page].length] = {
			'title': 'questions 3',
			'description': 'Opis',
			'type': type,
		};
	};

	$scope.remove = function(question, page){
		var index = $scope.questions[page].indexOf(question)
      	$scope.questions[page].splice(index,1);
	};

	$scope.copy = function(question, page){
		$scope.questions[page].push(angular.copy(question));
	};

	$scope.add_page = function(){
		$scope.questions.push([]);
	};

	$scope.save_forms = function(){
		// AJAX do zapisu

		console.log($scope.questions);
	};

	var init = function(){
		$scope.questions[0][0] = {
			'title': 'questions 1',
			'description': 'Opis',
			'type': 'text',
			'show_title': true,
		};
		$scope.questions[0][1] = {
			'title': 'questions 2',
			'description': 'Opis',
			'type': 'text',
			'show_title': false,
		};
		$scope.questions[0][2] = {
			'title': 'Single Choice',
			'description': 'Opis',
			'type': 'single_choice',
			'answers': [{},{}],
		};

	};


	init();

});

//Komponent do edycji pytania
mfpoll_app.component('questionEdit', {
	templateUrl: PLUGIN_URL + '/media/js/html/question/index.html',
	controller: function($scope){
		if($scope.element == undefined){
			$scope.element = {};
		}
		//Schowanie okienka
		$scope.visible = false;

		var ctrl = this;

		//Obserwator ktory otwiera okno
		$scope.$watch("$ctrl.question",function(newValue,oldValue) {

			if($scope.element != undefined){

				//Jezeli nowa wartosc to to wyswietlamy okienko formularza
				if(newValue){
					$scope.visible = true;

					//Uzupelnienie formularza
					if(ctrl.question != null){
						$scope.element = angular.copy(ctrl.question);
					}
				}

			}
	    });

	    $scope.getTemplate = function(){
	    	return PLUGIN_URL + '/media/js/html/question/' + $scope.element.type + '.html';
	    };

	    $scope.add_answer = function(){
	    	if($scope.element.answers == undefined){
	    		$scope.element.answers = [];
	    	}
	    	$scope.element.answers.push({});
	    };

	   	$scope.delete_answer = function(answer){
			var index = $scope.element.answers.indexOf(answer)
	      	$scope.element.answers.splice(index,1);
	    };

		//Zapisanie formularza (przypisanie wartosci do modelu)
		$scope.save = function(){

			//Usuniecie z rodzica wartosci pozwoli to na ponowne otwarcie formularza przez $watch bo zostanie przypisana nowa wartosc
			$scope.$parent.editing_elem = null;

			//Schowanie okienka
			$scope.visible = false;

			//Przypisanie wartosci do modelu
			angular.forEach($scope.element, function(value, key) {
			  	ctrl.question[key] = value;
			});

		};

		//Zamkniecie okienka
	    $scope.close = function(form){
	    	if (form) {
				form.$setPristine();
				form.$setUntouched();
		    }

			//Usuniecie z rodzica wartosci pozwoli to na ponowne otwarcie formularza przez $watch bo zostanie przypisana nowa wartosc
	    	$scope.$parent.editing_elem = null;
	    	
	    	//Przypisanie wartosci do modelu
	    	$scope.visible = false;
	    };

	},
	bindings: {
		question: '='
	}
});

//Dyrektywa do okienka modal
mfpoll_app.directive('mfModal', function() {
  	return {
	    restrict: 'E',
	    scope: {
	      	title: '@headerTitle',
	      	content: '@content',
	      	buttonText: '@buttonText',
	      	save: '=save',
	    },
	    link: function(scope,element,attrs){
	    	scope.visible = false;

	    	scope.is_url = false;

	    	scope.getTemplate = function(){

	    		var reg = /\.html$/;

		    	if(scope.content !== undefined){
		    		if(reg.test(scope.content) == true){
		    			scope.is_url = true;
		    			return PLUGIN_URL + '/media/js/html/other/modal/' + scope.content;
		    			//alert(scope.content);
		    		}
		    	}
		    	return PLUGIN_URL + '/media/js/html/other/modal/default.html';
	    	};

	    	scope.show = function(){
	    		scope.visible = true;
	    	};

	    	scope.close = function(param){
	    		scope.visible = false;

	    		if(param != undefined){
	    			scope.save(param, attrs);
	    		}

	    	};

	    },
	    templateUrl: PLUGIN_URL + '/media/js/html/other/modal/index.html'
  	};
});