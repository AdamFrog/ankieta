<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grid_question_single_choice
 *
 * @author Rafal
 */
class MFPValidator_Dropdown_list extends MFPValidator {

    public function valid(stdClass $question, stdClass $response){
        $question->options = json_decode($question->options);
        $this->question = $question;
        $this->response = $response;
        print_r($response);
        
        // Czy jest tablicą
        if(!$this->is_numeric()){
            
            // Czy jest wymagane
            if($this->is_required()){
                $this->set_message('reguired');
                return false;
            }
            
            
        }
        
        return true;
    }
    
    protected function message(){
        return array(
            'reguired' => __('Question is required!'),
        );
        
    }
}
