<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of validator
 *
 * @author Rafal
 */
class MFPValidator {
    
    protected $question = null;
    protected $response = null;

    public function __construct() {}

    public static function factory($name) {

        $file = MFPPATH . '/validator/' . strtolower($name) . '.php';

        if (file_exists($file)) {
            require_once($file);
        }
        $validator = 'MFPValidator_' . ucfirst(strtolower($name));
        return new $validator;
    }
    
    /**
     * Sprawdza czy wartosc jest liczna
     * @param string $value
     * @return boolean
     */
    protected function is_numeric(){
        //Jezeli odpowiedz jest pojedyncza
        if(!is_array($this->response->response)){
            
            if(is_numeric($this->response->response)){
                return true;
            }
            
        }else{
        //Jezeli odpowiedz jest mnoga
            foreach ($this->response->response as $value) {
                if(!is_numeric($value)){
                    return false;
                }
            }
            return true;
        }
        return false;
        
    }
    /**
     * Sprawdza czy odpowiedź nie jest tablicą
     * @param string $value
     * @return boolean
     */
    protected function is_not_array(){
        if(!is_array($this->response->response)){
            return true;
        }
        return false;
    }
    /**
     * Sprawdza czy odpowiedź jest tablicą
     * @param string $value
     * @return boolean
     */
    protected function is_array(){
        if(is_array($this->response->response)){
            return true;
        }
        return false;
    }
    /**
     * Sprawdza czy odpowiedź jest w bazie i czy należy do tego pytania
     * @param int $value
     * @param int $question_id
     * @return boolean
     */
    protected function check_answer_exists(){
        $model = MFPModel::factory('Answer');
        
        $model = $model->find('id', '=', (int) $this->response->response, ' AND `question_id` = ' . (int) $this->question->id);
        
        if(isset($model->id)){
            return true;
        }
        return false;
        
    }
    /**
     * Sprawdza czy pytanie jest wymagane
     * @return boolean
     */
    protected function is_required(){
        if(!isset($this->response->response) || $this->response->response == ''){
            if((bool)$this->question->options->require){
                return true;
            }else{
                return false;
            }
        }
        return false;

    }
    /**
     * Czy ilość odpowiedzi zgadza się z ustawieniami min i max 
     * @return boolean
     */
    protected function is_between_min_and_max(){
        if(isset($this->question->options->min) && $this->question->options->min != null){
            if(count($this->response->response) < $this->question->options->min){
               return false;
            }
        }
        if(isset($this->question->options->max) && $this->question->options->max != null){
            if(count($this->response->response) > $this->question->options->max){
               return false;
            }
        }
        return true;
    }
    
    protected function is_text_length(){
        if(isset($this->question->options->text_min) && $this->question->options->text_min != null){
            if(strlen($this->response->response) < $this->question->options->text_min){
               return false;
            }
        }
        if(isset($this->question->options->text_max) && $this->question->options->text_max != null){
            if(strlen($this->response->response) > $this->question->options->text_max){
               return false;
            }
        }
        return true;
    }

        /**
     * Ustawia wiadomości o nie udanej odpowiedzi
     * @param string $type
     */
    protected function set_message($type = 'default'){
        $message = $this->message();
        if(isset($message[$type])){
            $_SESSION['mfpmessage'][$this->question->id] = $message[$type];
        }else{
            $_SESSION['mfpmessage'][$this->question->id] = __('Something is wrong!');
        }
    }
    
    protected function get_answer_by_title($title){
        
        $model = MFPModel::factory('Answer');
        
        $model = $model->find('title', '=', $title, ' AND `question_id` = ' . (int) $this->question->id);

        if(isset($model->id)){
            return $model;
        }
        return false;
        
    }
    
    protected function clear_text($string){
        $string = strip_tags($string);
        return $string;
    }
}
