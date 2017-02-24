<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of question
 *
 * @author Rafal
 */

class MFPController_Question extends MFPController_Index{
    

    public function action_index(){
        
        $result = ['sdads' => 'dasdsa', 'html' => MFPView::render('question')];
        
        $this->sendJson($result);
        
    }

}