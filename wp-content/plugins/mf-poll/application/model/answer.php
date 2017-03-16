<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of answer
 *
 * @author Rafal
 */
class MFPModel_Answer extends MFPModel {
    
    protected $table_name = 'poll_question_answer';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function update_answer($answer, $question_id){
        if(isset($answer->id)){
            $this->update([
                'title' => $answer->title,
                '_order' => $answer->order,
            ], ['id', '=', $answer->id]);
     
        }else{
            $this->insert([
                'title' => $answer->title,
                'type' => $answer->type,
                '_order' => $answer->order,
                'question_id' => $question_id,
            ]);
        }
        
    }
    
    public function count_answer($question_id){
        
        $result = $this->db->get_results($this->db->prepare("SELECT COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_id));
        
        return $result[0]->count;
    }
    
    public function get_reply($question_id, $offset = 0){
        
        $response_model = MFPModel::factory('Response')->find_all('question_id', '=', (int) $question_id, " LIMIT 10 OFFSET {$offset}");
        
        return $response_model;
    }
    
}
