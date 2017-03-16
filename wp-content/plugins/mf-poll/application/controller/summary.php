<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Summary
 *
 * @author Rafal
 */
class MFPController_Summary extends MFPController_Index{
    
            
    public function action_get_summary_poll(){
        
        $sessions_model = MFPModel::factory('Session');
        
        $summary_poll_step = $sessions_model->get_summary_poll($_POST['poll_id']);
        
        $this->sendJson(['steps' => $summary_poll_step]);
        
    }
    
    public function action_get_summary_question(){
        
        $summary = MFPModel::factory('Response');
        
        $summary = $summary->get_summary_question($_POST['question_id']);
 
        $this->sendJson($summary);
        
    }
    
    public function action_get_question_reply(){
        
        $summary = MFPModel::factory('Answer')->get_reply($_POST['question_id'], $_POST['offset']);
        
        $this->sendJson(['items' => $summary]);
        
    }

}