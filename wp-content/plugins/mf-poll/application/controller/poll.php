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
            $question->answers = $answer_model->find_all('question_id', '=', $question->id, ' ORDER BY `_order` ASC');
            $question->options = json_decode($question->options);
            $new_questions[$question->page - 1][] = $question;
        }
        
        $result = [
            'status' => 'ok', 
            'title' => $poll->title, 
            'status' => $poll->status, 
            'date_added' => $poll->date_added, 
            'ending' => $poll->ending, 
            'type' => $poll->type, 
            'id' => $poll->id, 
            'questions' => $new_questions
        ];
        $this->sendJson($result); 
        
    }
    
    public function action_save(){
        
        $poll_id = (int) $_POST['poll_id'];
        
        $poll = MFPModel::factory('Poll');
        $poll = $poll->update([
            'title' => $_POST['title'],
            'entry' => $_POST['entry'],
            'status' => $_POST['status'],
            'ending' => $_POST['ending']
            ], ['id', '=', $poll_id]);
        
        if(isset($_POST['questions'])){
            
            $questions = $_POST['questions'];
            
            foreach ($questions as $key => $page) {
                
                foreach ($page as $key_question => $question){
                    
                    $question = (object) $question;
                    $question_model = MFPModel::factory('Question');
                    
                    if((bool) $question->remove){
                        if(isset($question->id)){
                            $question_model->delete('id', '=', $question->id);
                        }else{
                            continue;
                        }
                    }
                    
                    $options = null;
                    if(isset($question->options)){
                        $options = json_encode($question->options);

                    }
                    
                    if(isset($question->id)){
                        
                        $question_model->update([
                            'poll_id' => $poll_id,
                            'title' => $question->title,
                            'description' => $question->description,
                            'type' => $question->type,
                            'page' => $key + 1,
                            'options' => $options,
                        ], ['id', '=', $question->id]);
                        
                    }else{
                        
                        $question->id = $question_model->insert([
                            'poll_id' => $poll_id,
                            'title' => $question->title,
                            'description' => $question->description,
                            'type' => $question->type,
                            'page' => $key + 1,
                            'options' => $options,
                        ]);
                        
                    }
                    
                    if(isset($question->answers)){
                        $i = 0;
                        foreach ($question->answers as $key_answer => $answer) {
                            $answer['order'] = $i;
                            
                            $i++;
                            $answer = (object) $answer;
                            
                            //print_r($answer);
                            $answer->order = $i;
                            MFPModel::factory('Answer')->update_answer($answer, $question->id);
                            
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

    public function action_list(){
        
        $polls = MFPModel::factory('Poll')->find_all('id', '>', 0);
        
        $result = ['status' => 'ok', 'polls' => $polls];
        $this->sendJson($result); 
        
    }

}