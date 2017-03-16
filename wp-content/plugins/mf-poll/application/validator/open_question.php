<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of open_question
 *
 * @author Rafal
 */
class MFPValidator_Open_question extends MFPValidator {

    public function valid(stdClass $question, stdClass $response){
        $question->options = json_decode($question->options);
        $this->question = $question;
        $this->response = $response;
        
        // Czy jest wymagane
        if($this->is_required()){
            $this->set_message('reguired');
            return false;
        }
        //Czyszczenie textu z html itp.
        $this->response->response = $this->clear_text($this->response->response);
        
        //Czy długość odpowiedzi się zgadza
        if(!$this->is_text_length()){
            $this->set_message('is_text_length');
            return false;
        }
        
        return true;
    }
    
    protected function message(){
        return array(
            'reguired' => __('Question is required!'),
            'check_answer_exists' => __('Answer from question not exists!'),
            'is_between_min_and_max' => __('Selected answers not between min and max'),
            'is_text_length' => __('Text is valid!'),
        );
        
    }
}
