<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('MFPPATH', realpath(dirname(__FILE__)));
define('MFPPREFIX', 'MFP');

// Załadowanie woprdressa
require_once str_replace('wp-content\plugins\mf-poll\application', '', MFPPATH) . 'wp-load.php';
require_once MFPPATH . '/system/view.php';
require_once MFPPATH . '/system/model.php';
require_once MFPPATH . '/system/arr.php';
require_once MFPPATH . '/system/validator.php';

// Autoloader controllerów i modeli
spl_autoload_register(function ($class) {
    $aExlode = explode('_', $class);
    $type = $aExlode[0];
    switch ($type) {
        case MFPPREFIX . 'Controller':
            require_once MFPPATH . '/controller/' . strtolower(end($aExlode)) . '.php';
            break;
    }
});