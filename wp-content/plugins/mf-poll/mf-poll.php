<?php
/*
	Plugin Name: MotoFocus.pl - Web ankiety
	Text Domain: mfpoll
	Plugin URI: http://motofocus.pl/
	Description: Plugin odpowiedzialny tworzenie ankiet
	Version: 1.0
	Author: Adam Bojarczuk
	Author URI: http://motofocus.pl/
	License: GPLv2 or later
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
/**
 * Rejestracja strony do menu
 */
function mf_register_poll(){
    add_menu_page( 
        __( 'Poll', 'mfpoll' ),
        __( 'Poll', 'mfpoll' ),
        'edit_posts',
        'mfpoll',
        'mf_init_poll',
        'dashicons-email-alt',
        6
    ); 
}
add_action( 'admin_menu', 'mf_register_poll' );

/**
 * Tlumaczenie oraz configuracja ale jeszcze do przemyslenia
 */
function mf_admin_head_poll() {?>
    <script>
    var mf_i18n = {
        'POLL_LIST': '<?= __('Poll list', 'mfpoll') ?>',
        'NEW': '<?= __('New', 'mfpoll') ?>',
        'ADD_NEW_POLL': '<?= __('Add new poll', 'mfpoll') ?>',
        'RETURN': '<?= __('Return', 'mfpoll') ?>',
        'WHAT_KIND_OF_FORM_YOU_WANT_TO_CREATE': '<?= __('What kind of form you want to create', 'mfpoll') ?>',
        'POLL': '<?= __('Poll', 'mfpoll') ?>',
        'KNOWLEDGE_TEST': '<?= __('Knowledge test', 'mfpoll') ?>',
        'SURVEY': '<?= __('Survey', 'mfpoll') ?>',
        'COPY_POLL': '<?= __('Copy poll', 'mfpoll') ?>',
        'ADD_NEW': '<?= __('Add new', 'mfpoll') ?>',
        'COPY_SURVEY': '<?= __('Copy survey', 'mfpoll') ?>',
        'COPY_KNOWLEDGE_TEST': '<?= __('Copy knowledge test', 'mfpoll') ?>',
        'SELECT_OPTIONS': '<?= __('Select options', 'mfpoll') ?>',
        'WHICH_FORM_YOU_WANT_TO_COPY': '<?= __('Which form you want to copy:', 'mfpoll') ?>',
        'FORM_URL': '<?= __('Form URL', 'mfpoll') ?>',
        'ADD': '<?= __('Add', 'mfpoll') ?>',
        'ENTER_TITLE': '<?= __('Enter title', 'mfpoll') ?>',
        'TEXT': '<?= __('Text', 'mfpoll') ?>',
        'SINGLE_CHOICE': '<?= __('Single choice', 'mfpoll') ?>',
        'MULTIPLE_CHOICE': '<?= __('Multiple choice', 'mfpoll') ?>',
        'OPEN_QUESTION': '<?= __('Open question', 'mfpoll') ?>',
        'GRID_QUESTION_SINGLE_CHOICE': '<?= __('Grid question - single choice', 'mfpoll') ?>',
        'GRID_QUESTION_MULTIPLE_CHOICE': '<?= __('Grid question - multiple choice', 'mfpoll') ?>',
        'GRID_QUESTION_OPEN': '<?= __('Grid question - open', 'mfpoll') ?>',
        'NPS_QUESTION': '<?= __('NPS Question', 'mfpoll') ?>',
        'SCALE': '<?= __('Scale', 'mfpoll') ?>',
        'DROPDOWN_LIST': '<?= __('Dropdown list', 'mfpoll') ?>',
        'RANKING': '<?= __('Ranking', 'mfpoll') ?>',
        'ASSIGNING_POINTS': '<?= __('Assigning points', 'mfpoll') ?>',
        'ADD_ATTACHMENT': '<?= __('Add attachment', 'mfpoll') ?>',
        'QUESTION_FOR_NUMBER': '<?= __('Question for number', 'mfpoll') ?>',
        'QUESTION_OF_THE_DATE': '<?= __('Question of the date', 'mfpoll') ?>',
        'QUESTION_OF_EMAIL': '<?= __('Question of email', 'mfpoll') ?>',
    };
    var MFPOLL_CONFIG = {
        'url': '<?= get_site_url() ?>',
        'admin_url': '<?= get_site_url(). '/wp-admin/admin.php?page=mfpoll' ?>',
        'plugin_url': '<?= plugin_dir_url(__FILE__) ?>',
    };

    </script>
    <style>
    .color{
        color:#0065B3;
    }
    .bg-color{
        background-color: #0065B3;
        color: white;
    }
    .hover-color:hover{
        color: #0065B3;
    }
    </style>
    <?php
}
add_action( 'admin_head', 'mf_admin_head_poll' );

/**
 * Deregistered angular motofocus.pl
 */
function mf_demedia_poll() {
    wp_dequeue_script('admin-angular');
}
add_action( 'wp_print_scripts', 'mf_demedia_poll', 100 );

/**
 * Register style and script 
 */
function mf_media_poll() {
    wp_enqueue_style( 'admin_css_font_awesome_mfpoll', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css', false, '1.0.0' );
    wp_enqueue_style( 'admin_css_mfpoll', plugin_dir_url( __FILE__ ) . 'media/css/style.css', false, '1.0.0' );
    wp_enqueue_script( 'admin_js_jqueryui_mfpoll', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', false, '1.0.0', false);
    wp_enqueue_script( 'admin_js_angular_mfpoll', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js', false, '1.0.0', false);
    wp_enqueue_script( 'admin_js_route_mfpoll', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular-route.js', false, '1.0.0', true);
    wp_enqueue_script( 'admin_js_translate_mfpoll', plugin_dir_url( __FILE__ ) . 'media/js/library/angular-translate.min.js', false, '1.0.0', true);
    wp_enqueue_script( 'admin_js_animate_mfpoll', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular-animate.js', false, '1.0.0', true);
    wp_enqueue_script( 'admin_js_sortable_mfpoll', 'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.16.1/sortable.min.js', false, '1.0.0', true);
    wp_enqueue_script( 'admin_js_mfpoll', plugin_dir_url( __FILE__ ) . 'admin/main.js', false, '1.0.0', true);
    wp_enqueue_script( 'admin_js_main_mfpoll', plugin_dir_url( __FILE__ ) . 'admin/controller/main.js', false, '1.0.0', true);
    wp_enqueue_script( 'admin_js_services_mfpoll', plugin_dir_url( __FILE__ ) . 'admin/services.js', false, '1.0.0', true);
    wp_enqueue_script( 'admin_js_add_mfpoll', plugin_dir_url( __FILE__ ) . 'admin/controller/add.js', false, '1.0.0', true);
    wp_enqueue_script( 'admin_js_edit_mfpoll', plugin_dir_url( __FILE__ ) . 'admin/controller/edit.js', false, '1.0.0', true);
}

/**
 * Jezeli istnieje page i rowna sie mfpoll dodamy style i css zeby nie ładowac za kazdym wejsciem
 */
if(isset($_GET['page']) && $_GET['page'] == 'mfpoll'){

    add_action( 'admin_enqueue_scripts', 'mf_media_poll' );

}
/**
 * Page polls start 
 */
function mf_init_poll(){?>
    <div ng-app="mfpoll">
        <div class="wrap" ng-view></div>
    </div>
    <?php
}
add_action( 'wp_ajax_poll', 'mf_init_poll' );
