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
class MFPValidator_Assigning_points extends MFPValidator {

    public function valid(stdClass $question, stdClass $response){
        $question->options = json_decode($question->options);
        $this->question = $question;
        $this->response = $response;
        //print_r($response);
        
        
        // Czy jest tablicą
        if($this->is_not_array()){
            // Czy jest wymagane
            if($this->is_required()){
                $this->set_message('reguired');
                return false;
            }
            
        }
        
        if(!$this->__check_count_answer()){
            $this->set_message();
            return false;
        }
        
        if(!$this->__check_summary_points()){
            $this->set_message('points');
            return false;
        }
        
        return true;
    }
    
    protected function message(){
        return array(
            'reguired' => __('Question is required!'),
            'points' => __('Distribute all points!'),
        );
        
    }
    
    private function __check_count_answer() {
        
        $count = MFPModel::factory('Answer')->count_answer($this->question->id);

        if(count($this->response->response) != $count){
            return false;
        }
        return true;
        
    }
    
    private function __check_summary_points() {
        
        $points = 0;
        
        foreach ($this->response->response as $answer){
          
            $points = $points + (int) $answer['points'];
            
        }
        echo $points;
        if($points != $this->question->options->points){
            return false;
        }
        
        return true;
    }
}
