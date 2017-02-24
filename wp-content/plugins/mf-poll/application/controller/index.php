<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MFPController_Index {
    
    /**
     * Wyswietla JSON
     * @param array $array
     */
    protected function sendJson($array){
        header('Content-Type: application/json');
        echo json_encode($array);
        die();
    }

    public function action_index(){
        
        $result = ['sdads' => 'dasdsa'];
        
        $this->sendJson($result);
        
    }

}