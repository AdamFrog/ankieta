<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of single_choice
 *
 * @author Rafal
 */
class MFPValidator_Single_choice extends MFPValidator {
    
    public function valid(stdClass $question,  stdClass $response){
        $question->options = json_decode($question->options);
        $this->question = $question;
        $this->response = $response;
        
        if($this->is_required()){
            $this->set_message('reguired');
            return false;
        }
        
        if(!$this->is_not_array()){
            $this->set_message();
            return false;
        }
        
        if(!$this->is_numeric()){
            $this->set_message();
            return false;
        }
        
        if(!$this->check_answer_exists()){
            $this->set_message('check_answer_exists');
            return false;
        }
        
        $this->check_actions();
        //print_r($object);
        
        return true;
    }
    
    protected function message(){
        return array(
            'reguired' => __('Question is required!'),
            'check_answer_exists' => __('Answer from question not exists!'),
        );
        
    }
    
    private function check_actions(){
        
        //Sparawdzamy czy są akcje
                        
        if(isset($this->question->options->actions)){
            //Przejdziemy po akcjach
            foreach($this->question->options->actions as $actions){
                
                //Sprobujemy pobrać model odpowiedzie po tytule, wiem głupie ale nie ma czasu :/
                if($answer = $this->get_answer_by_title($actions->answer_title)){
                    
                    //Jeśli objekt odpowiedzi się zgadza to zdefiniujemy akcje
                    if($this->response->response == $answer->id){
                        switch ($actions->type) {
                            case 'go_to':
                                $_SESSION['redirect_to_page'] = $actions->do;
                                break;
                        }
                        
                    }
                    
                }
                
            }
            
        }
        return true;
        
    }
    
}
