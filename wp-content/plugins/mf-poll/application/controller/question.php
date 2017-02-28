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
        //print_r($_POST);
        
        $result = ['sdads' => 'dasdsa', 'html' => MFPView::render('question/'. $_POST['type'], $_POST)];
        
        $this->sendJson($result);
        
    }
    
    public function action_save(){
        print_r($_POST);
        die();
        //$result = ['sdads' => 'dasdsa', 'html' => MFPView::render('question/'. $_POST['type'], $_POST)];
        
        //$this->sendJson($result);
        
    }

}