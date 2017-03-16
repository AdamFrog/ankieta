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
class MFPValidator_Add_attachment extends MFPValidator {
    /**
     * Akceptowane mime-type
     * @var array
     */
    public $formats = array(
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'pdf' => array(
                'application/pdf',
                'application/x-pdf',
                'application/x-bzpdf',
                'application/x-gzpdf'
            ),
        'doc' => array(
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ),
        'csv' => 'text/csv',
        'ppt' => array(
            'application/vnd.ms-powerpointtd>',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ),
        'mp3' => 'audio/mpeg'
    );
    /**
     * Akceptowane rozszerzenia plików (problem z plikami rar i zip maja taki sam mime-type)
     * @var array
     */
    public $extension_accept = array('zip','rar');

    public function valid(stdClass $question, stdClass $response){
        $question->options = json_decode($question->options);
        $this->question = $question;
        $this->response = $response;
        $this->response->files = $_FILES['files'. $this->question->id];
       
        
        if(!$this->__check_formats()){
            $this->set_message('extension');
            return false;
        }
        
        // Sprawdzamy czy coś zostało wysłane
        if(count($this->response->files['name']) == 1 && $this->response->files['name'][0] == null){
            
            // Czy jest wymagane
            if($this->is_required()){
                $this->set_message('reguired');
                return false;
            }
            
        }
        
        if(!$this->__check_count_file()){
            $this->set_message('count_file');
            return false;
        }
        
        if(!$this->__check_file_sizes()){
            $this->set_message('weight_file');
            return false;
        }
        
        // Tutaj zrobimy upload i dodamy do sesji zauplodowane pliki pewnie zrobimy to w modelu Answer
        $this->uploads();
        
        unset($this->response->files);
        return $this->response;
    }
    
    protected function message(){
        return array(
            'reguired' => __('Question is required!'),
            'count_file' => __('Files is too much!'),
            'weight_file' => __('Files weigh too much!'),
            'extension' => __('File extension is valid!'),
        );
        
    }
    
    /**
     * Sprawdza czy ilość plików się zgadza
     * @return boolean
     */
    private function __check_count_file(){
        
        if(count($this->response->files['name']) > $this->question->options->max_count){
            return false;
        }
        return true;
    }
    
    /**
     * Sprawdza czy pliki maja odpowiednią wielkość
     * @return boolean
     */
    private function __check_file_sizes(){
        $size = 100000;
        
        if(isset($this->question->options->max_size) && $this->question->options->max_size != null){
            $size = $this->question->options->max_size * 1000000;
        }
        
        foreach ($this->response->files['size'] as $value) {
            if($value > $size){
                return false;
            }
        }
        return true;
    }
    
    /**
     * Sprawdza czy są odpowiednie formaty
     * @return boolean
     */
    private function __check_formats(){
        
        foreach ($this->response->files['name'] as $key => $value) {
           
            if(!$this->__find_in_formats($this->response->files['type'][$key], pathinfo($value, PATHINFO_EXTENSION))){
                return false;
            }
        }
        return true;
    }
    
    /**
     * 
     * @param string $value - Mime-type pliku
     * @param string $ext - Rozszerzenie pliku
     * @return boolean
     */
    private function __find_in_formats($value, $ext){

        foreach ($this->formats as $key => $format) {
            if(!$this->is_accepted($key)) continue;
            if(is_array($format)){
                if(in_array($value, $format)) return true;
            }
            if($format == $value) return true;
        }
        
        if(in_array($ext, $this->extension_accept)){
            if(!$this->is_accepted($ext))return true;
        }
        
        return false;
    }
    
    /**
     * Sprawdza czy w ustawieniach pytania jest możliwość uploadu danego formatu
     * @param string $key - Format pliku
     * @return boolean
     */
    private function is_accepted($key){
        if(isset($this->question->options->formats->{$key}) && $this->question->options->formats->{$key} == 1){
            echo ' accept ';
            return true;
        }
        echo ' no ';
        return false;
    }
    
    private function uploads(){
        
        $uploaded = [];
        
        foreach($this->response->files['name'] as $key => $name){
            $filename = rand(100000, 999999) .'-' . $name;
            move_uploaded_file($this->response->files['tmp_name'][$key], str_replace('application', '', MFPPATH) . 'media/upload/' . $filename);
            $uploaded[] = $filename;
        }
        $this->response->response = $uploaded;
    }
}
