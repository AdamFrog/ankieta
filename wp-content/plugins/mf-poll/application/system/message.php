<?php

class MFPMessage {

    private static $instance;

    public $messages = array();
 
    private function __construct() {}
    private function __clone() {}
 
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new MFPMessage();
        }
        return self::$instance;
    }

    public function get(){
        if(!empty($this->messages)){
            echo '<ul id="grmessage" title="' . __('Messages', 'grnewsletter') . '">';
            foreach($this->messages as $key => $message){
                echo '<li class="'.$message['type'].'">'.$message['message'].'</li>';
            }
            echo '</ul>';
        }

    }

    public function set($message, $type = 'error'){

        array_push($this->messages, array('message' => $message, 'type' => $type));

    }

}