<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of poll
 *
 * @author Rafal
 */
class MFPController_Poll extends MFPController_Index{
    
    public function action_add(){
        
        $poll = MFPModel::factory('Poll');
        
        $id = $poll->insert([
            'title' => $_POST['title'],
            'type' => $_POST['type'],
            'status' => 0,
        ]);
        
        $result = ['status' => 'ok', 'id' => $id];
        $this->sendJson($result); 
        
    }
    
    public function action_get(){
        
        $poll = MFPModel::factory('Poll');
        $question = MFPModel::factory('Question');
        
        $poll = $poll->find('id', '=', $_POST['poll_id']);
        $questions = $question->find_all('poll_id', '=', $_POST['poll_id']);
        
        $new_questions = array();
        foreach ($questions as $question){
            $answer_model = MFPModel::factory('Answer');
            $question->answers = $answer_model->find_all('question_id', '=', $question->id);
            $new_questions[] = $question;
        }
        
        $result = ['status' => 'ok', 'title' => $poll->title, 'questions' => $new_questions];
        $this->sendJson($result); 
        
    }
    
    public function action_save(){
        
        $poll_id = (int) $_POST['poll_id'];
        
        $poll = MFPModel::factory('Poll');
        $poll = $poll->update(['title' => $_POST['title']], ['id', '=', $poll_id]);
        
        if(isset($_POST['questions'])){
            
            $questions = $_POST['questions'];
            
            foreach ($questions as $key => $page) {
                
                foreach ($page as $key_question => $question){
                    
                    $question = (object) $question;
                    $question_model = MFPModel::factory('Question');
                    
                    if(isset($question->id)){
                        
                        $question_model->update([
                            'poll_id' => $poll_id,
                            'title' => $question->title,
                            'description' => $question->description,
                            'type' => $question->type,
                        ], ['id', '=', $question->id]);
                        
                    }else{
                        
                        $question->id = $question_model->insert([
                            'poll_id' => $poll_id,
                            'title' => $question->title,
                            'description' => $question->description,
                            'type' => $question->type,
                        ]);
                        
                    }
                    
                    if(isset($question->answers)){
                        foreach ($question->answers as $key_answer => $answer) {
                            
                            $answer = (object) $answer;
                            $answer_model = MFPModel::factory('Answer');
                            
                            if(isset($answer->id)){
                                $answer_model->update([
                                    'title' => $answer->title,
                                ], ['id', '=', $answer->id]);
                            }else{
                                $answer_model->insert([
                                    'title' => $answer->title,
                                    'question_id' => $question->id,
                                ]);
                            }
                            
                        }
                    }
                    
                }
            }
            
        }
        
        if($poll){
            
            $result = ['status' => 'ok'];
            $this->sendJson($result);
            
        }
        
        $result = ['status' => 'error'];
        $this->sendJson($result);
    }


}