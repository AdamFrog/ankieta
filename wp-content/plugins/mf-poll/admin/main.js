// TODO Trzeba usunąć
var PLUGIN_URL = 'http://localhost/wordpress/wp-content/plugins/mf-poll';

var mfpoll_app = angular.module('mfpoll', ['ngRoute', 'pascalprecht.translate', 'ngAnimate', 'ui.sortable']);

/**
 * Bootstrap
 */
mfpoll_app.config(function ($routeProvider, $locationProvider, $translateProvider) {
    $routeProvider
    .when('/', {
        templateUrl: MFPOLL_CONFIG['plugin_url'] + 'admin/view/index.html',
        controller: 'MainController',
    })
    .when('/add', {
        templateUrl: MFPOLL_CONFIG['plugin_url'] + 'admin/view/add.html',
        controller: 'AddController',
        resolve: {
            // I will cause a 1 second delay
            /*delay: function($q, $timeout) {
             var delay = $q.defer();
             $timeout(delay.resolve, 1000);
             return delay.promise;
             }*/
        }
    })
    .when('/edit/:id', {
        templateUrl: MFPOLL_CONFIG['plugin_url'] + 'admin/view/edit.html',
        controller: 'EditController'
    });

    $translateProvider.translations('en', mf_i18n);
    $translateProvider.preferredLanguage('en');

});

/**
 * Filtr ktory odpowiada za generowanie adresy url ze stringa
 * @param string input
 * return string 
 */
mfpoll_app.filter('sanitize_title', function () {
    return function (input) {
        if (input == null) {
            return null;
        }
        str = angular.lowercase(input);

        // remove accents, swap Ăą for n, etc
        var from = "śãàáäâẽèéëêìíïîõòóöôùúüûñçłżźęą·/_,:;-";
        var to = "saaaaeeeeeiiiiooooouuuuncllzeea       ";
        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }
        str = str.replace(/[^a-z0-9 -]/g, ' ') // remove invalid chars
                .replace(/\s+/g, ' ') // collapse whitespace and replace by -
                .replace(/-+/g, ' ').trim().replace(/ /g, '-'); // collapse dashes

        return str;
    };
});

/**
 * Filtr generujacy url
 * @param string inout
 * return string
 */
mfpoll_app.filter('route', function() {
    return function(input) {
    	if(input == null){
            return null;
    	}
    	return MFPOLL_CONFIG['admin_url'] + input;
    };
});



jQuery(window).scroll(function() {
    var navbar = jQuery('body').find('#questions-list-navbar');
    var window_scroll = jQuery(window).scrollTop();

    if(navbar.offset().top - 32 < window_scroll){
        navbar.addClass('fly');
        navbar.find('#navbar').css({position: 'fixed', top: '32px', left: 'auto', width: navbar.width()});
    }else{
        navbar.addClass('fly');
        navbar.find('#navbar').css({position: 'absolute', top: '0px'});
    }
});