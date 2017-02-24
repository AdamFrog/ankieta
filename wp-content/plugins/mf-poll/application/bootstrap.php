<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once realpath(dirname(__FILE__)) . '/index.php';

if (isset($_GET['controller'])) {
    $name = ucfirst(strtolower($_GET['controller']));
    $controller = 'MFPController_' . ucfirst($name);
    $object = new $controller;
}

if (isset($_GET['action'])) {
    $action = 'action_' . strtolower($_GET['action']);
    if(method_exists($object,'before')){$object->before();}
    $object->{$action}();
    if(method_exists($object,'after')){$object->after();}
}
