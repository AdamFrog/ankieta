<?php

class MFPConfig {

    private static $instance;
    private $config = array(
        'path' => null,
        'plugin_url' => null,
        'template' => 'motofocuspl',
        'password' => 'NFiB-YS24-3s',
    );

    private function __construct() {}

    private function __clone() {}

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new MFPConfig();
        }
        return self::$instance;
    }

    public function get($name) {
        return $this->config[$name];
    }

    public function set($name, $value) {
        $this->config[$name] = $value;
    }

}
