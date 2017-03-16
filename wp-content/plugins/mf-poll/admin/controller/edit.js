mfpoll_app.controller('EditController', function ($scope, $routeParams, $location, $sce, Question, Poll) {
    $scope.page_load = true;
    $scope.config = MFPOLL_CONFIG;    

    $scope.sortableOptions = {
        axis: 'y',
        placeholder: "sortable-placeholder",
        connectWith: '.sortable-list',
        handle: ".handle-question",
        start: function (e, ui) {
            ui.placeholder.height(ui.item.outerHeight());
        }
    };
    $scope.sortableOptionsPage = {
        axis: 'y',
        placeholder: "sortable-placeholder",
        connectWith: '.sortable-page',
        handle: ".handle-page",
        start: function (e, ui) {
            ui.placeholder.height(ui.item.outerHeight());
        }
    };
    
    $scope.name = 'EditController';
    $scope.params = $routeParams;
    $scope.editing_elem = null;
    $scope.questions = [[]];
    $scope.loading_width = 0;
    
    
    Poll.get($scope.params.id, function(data){
        $scope.title = data.title;
        $scope.status = parseInt(data.status);
        $scope.type = data.type;
        $scope.ending = data.ending;
        //Rzucenie do array
        angular.forEach(data.questions, function(value, key) {
            $scope.questions[key] = value;
         });
        console.log($scope);
        $scope.get_html(0,0);
        $scope.page_load = false;
    });
    
    /**
     * Ustawia element edytowany dzieki czemu w oknie z edycja pytanie wyswietli mi 
     * sie odpowiednie pytanie
     * 
     * @param model elem
     */
    $scope.set_edit_element = function (elem) {
        
        $scope.editing_elem = elem;
    };

    $scope.save_modal_add_question = function (type, attrs) {

        $scope.questions[attrs.page][$scope.questions[attrs.page].length] = {
            'title': null,
            'description': null,
            'type': type,
        };
    };
    
    /**
     * Usuwanie pytania z głownej tablicy @questions
     * 
     * @param model question
     * @param int page Wskazuje na ktorej stronie sie znajduje czyli numer pod tablicy
     */
    $scope.remove = function (question, page) {
        var index = $scope.questions[page].indexOf(question);
        $scope.questions[page][index].remove = 1;
    };
   
    $scope.remove_page = function (page) {
        var index = $scope.questions.indexOf(page);
        $scope.questions.splice(index, 1);
    };
    /**
     * To proste, kopiowanie pytań
     * 
     * @param model question
     * @param int page
     */
    $scope.copy = function (question, page) {
        $scope.questions[page].push(angular.copy(question));
    };
    
    /**
     * Tworzymy dodatkowa strone
     */
    $scope.add_page = function () {
        console.log($scope.questions.length);
        $scope.questions.push([]);
    };
    
    /**
     * Pobiera html pytania
     */
    $scope.get_html = function (page, index) {
        if($scope.questions[page][index] !== undefined){
            var question = $scope.questions[page][index];
        }else{
            if($scope.questions[page + 1] !== undefined){
                $scope.get_html(page + 1, 0);
                page = page + 1;
            }
            return false;
        }
        
        Question.get_html(question, function($response){
            var index = $scope.questions[page].indexOf(question);
            $scope.questions[page][index].html = $response.data.html;
            $scope.get_html(page, index + 1);
            $scope.loading_width = index * 10;
        });
    };
    
    /**
     * Tu bedzie zapisywanie jakis ajax do api
     * @returns {undefined}
     */
    $scope.save_forms = function () {
        // AJAX do zapisu
        var model = {
            title: $scope.title,
            entry: $scope.entry,
            ending: $scope.ending,
            status: $scope.status,
            poll_id: $scope.params.id,
            questions: $scope.questions,
        };
        Poll.save(model, function($response){
            console.log($response);
            alert('zmiany zostaly zapisane');
            
        });
        //console.log($scope.questions);
    };
    
    $scope.to_trusted = function(html_code) {
        return $sce.trustAsHtml(html_code);	
    }
    
});

/**
 * Component do edycji pytania
 * @param model question Model pytania 
 */
mfpoll_app.component('questionEdit', {
    templateUrl: MFPOLL_CONFIG['plugin_url'] + 'admin/view/question/index.html',
    controller: function ($scope, Question) {
        if ($scope.element == undefined) {
            $scope.element = {};
        }
        //Schowanie okienka
        $scope.visible = false;    
        var ctrl = this;
        
        ctrl.sortableAnswer = {axis: 'y', handle: ".counter"};

        //Obserwator ktory otwiera okno
        $scope.$watch("$ctrl.question", function (newValue, oldValue) {
            
            if ($scope.element != undefined) {

                //Jezeli nowa wartosc to to wyswietlamy okienko formularza
                if (newValue) {
                    $scope.visible = true;
                    //$scope.hide = undefined;

                    //Uzupelnienie formularza
                    if (ctrl.question != null) {
                        
                        //Hack na checkboxy bo jesli liczba wystepuje jako string to checkboxy nie sa zaznaczone
                        angular.forEach(ctrl.question.options, function(value, key) {
                            if(value == '1'){
                                ctrl.question.options[key] = 1;
                            }else if(value == '0'){
                                ctrl.question.options[key] = 0;
                            }
                            if(typeof value === 'object'){
                                angular.forEach(value, function(_value, _key) {
                                    alert(_value);
                                    if(_value == '1'){
                                        ctrl.question.options[key][_key] = 1;
                                    }else if(_value == '0'){
                                        ctrl.question.options[key][_key] = 0;
                                    }
                                });
                            }
                        });
                        $scope.element = angular.copy(ctrl.question);
                    }
                }

            }
        });

        $scope.getTemplate = function () {
            return MFPOLL_CONFIG['plugin_url'] + '/admin/view/question/' + $scope.element.type + '.html';
        };

        $scope.add_answer = function(type) {
            type = (typeof type !== 'undefined') ?  type : null;
            if ($scope.element.answers == undefined) {
                $scope.element.answers = [];
            }
            if(type != null){
                $scope.element.answers.push({type:type});
            }else{
                $scope.element.answers.push({type:'answer'});
            }
            console.log($scope.element.answers);
        };

        $scope.delete_answer = function (answer) {
            var index = $scope.element.answers.indexOf(answer)
            $scope.element.answers.splice(index, 1);
        };
        
        $scope.add_scale = function () {
            if ($scope.element.answers == undefined) {
                $scope.element.answers = [];
            }
            $scope.element.answers.push({type:'scale'});
        };
        
        $scope.add_actions = function () {
            if ($scope.element.options.actions == undefined) {
                $scope.element.options.actions = [];
            }
            $scope.element.options.actions.push({});
        };
        
        $scope.getPagesCount = function () {
            return $scope.$parent.questions.length;
        };

        //Zapisanie formularza (przypisanie wartosci do modelu)
        $scope.save = function () {
            
            Question.get_html($scope.element, function(response){
                
                $scope.element.html = response.data.html;
                //Usuniecie z rodzica wartosci pozwoli to na ponowne otwarcie formularza przez $watch bo zostanie przypisana nowa wartosc
                $scope.$parent.editing_elem = null;

                //Schowanie okienka
                $scope.visible = false;

                //Przypisanie wartosci do modelu
                //ctrl.question[key] = angular.copy($scope.element)
                angular.forEach($scope.element, function (value, key) {
                    ctrl.question[key] = value;
                });
                
                console.log(ctrl.question);
            });
            
        };

        //Zamkniecie okienka
        $scope.close = function (form) {
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

/**
 * Dyrektywa okna modal
 * @param string @headerTitle
 * @param string @content
 * @param string @buttonText
 * @param function @save Dependecy do zobienia czegos po kliknieciu w button
 */
mfpoll_app.directive('mfModal', function () {
    return {
        restrict: 'E',
        scope: {
            title: '@headerTitle',
            content: '@content',
            buttonText: '@buttonText',
            save: '=save',
        },
        link: function (scope, element, attrs) {
            scope.visible = false;

            scope.is_url = false;

            scope.getTemplate = function () {

                var reg = /\.html$/;

                if (scope.content !== undefined) {
                    if (reg.test(scope.content) == true) {
                        scope.is_url = true;
                        return MFPOLL_CONFIG['plugin_url'] + 'admin/view/other/modal/' + scope.content;
                    }
                }
                return MFPOLL_CONFIG['plugin_url'] + 'admin/view/other/modal/default.html';
            };

            scope.show = function () {
                scope.visible = true;
            };

            scope.close = function (param) {
                scope.visible = false;

                if (param != undefined) {
                    scope.save(param, attrs);
                }

            };

        },
        templateUrl: MFPOLL_CONFIG['plugin_url'] + 'admin/view/other/modal/index.html'
    };
});