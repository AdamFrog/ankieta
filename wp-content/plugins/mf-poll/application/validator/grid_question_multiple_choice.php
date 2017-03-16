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
class MFPValidator_Grid_question_multiple_choice extends MFPValidator {

    public function valid(stdClass $question, stdClass $response){
        $question->options = json_decode($question->options);
        $this->question = $question;
        $this->response = $response;
        
        // Czy jest tablicą
        if(!$this->is_array()){
            
            // Czy jest wymagane
            if($this->is_required()){
                $this->set_message('reguired');
                return false;
            }
            return true;
            
        }
        
        if(!$this->__is_between_min_and_max()){
            $this->set_message('is_between_min_and_max');
            return false;
        }
        
        return true;
    }
    
    protected function message(){
        return array(
            'reguired' => __('Question is required!'),
            'is_between_min_and_max' => __('Selected answers not between min and max!'),
        );
        
    }
    
    
    private function __is_between_min_and_max(){
        $count = 0;
        foreach ($this->response->response as $response){
            $count = $count + count($response);
        }
        
        if(isset($this->question->options->min) && $this->question->options->min != null){
            if($count < $this->question->options->min){
               return false;
            }
        }
        if(isset($this->question->options->max) && $this->question->options->max != null){
            if($count > $this->question->options->max){
               return false;
            }
        }
        return true;
    }
}
