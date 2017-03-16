<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of response
 *
 * @author Rafal
 */
class MFPModel_Response extends MFPModel {
    
    protected $table_name = 'poll_session_response';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
    * Zapisuje ankietę
    * @param array $poll
    */
    public function save_poll($poll_id){
        
        if(!isset($_SESSION['poll'][$poll_id])){
            wp_redirect('/wordpress/ankieta/'. $poll_id);
        }
        
        $response = $_SESSION['poll'][$poll_id];
        
        // Jżeli jest stop to zaczy że już raz głosował
        if(!isset($response['stop'])){
            foreach ($response['q'] as $response){
                $response = (array) $response;
                $question_model = MFPModel::factory('Question')->find('id', '=', (int) $response['qid'], " AND `poll_id` = '{$poll_id}'");
                if(!isset($question_model->id)){
                    continue;
                }
                
                $method_name = 'do_'. $question_model->type;
                
                if(!method_exists($this, $method_name)){
                    die(__('Error method save not exist!', 'mfpoll'));
                }
                
                $this->{$method_name}($response);
                
            }
        }
        
    }
    
    public function do_single_choice($response){
        if($response['response'] != null){
            
            $this->insert([
                'session_id' => $_SESSION['session_id'],
                'question_id' => (int) $response['qid'],
                'answer_id' => (int) $response['response'],
            ]);
            
        }
        
    }
    
    public function do_multiple_choice($response){
        if($response['response'] != null){
            
            foreach($response['response'] as $r){
                $this->insert([
                    'session_id' => $_SESSION['session_id'],
                    'question_id' => (int) $response['qid'],
                    'answer_id' => (int) $r,
                ]);
            }
            
        }
        
    }
    
    public function do_open_question($response){

        $this->insert([
            'session_id' => $_SESSION['session_id'],
            'question_id' => (int) $response['qid'],
            'answer' => $response['response'],
        ]);
        
    }
    
    public function do_grid_question_single_choice($response){

        foreach($response['response'] as $key => $r){
            $this->insert([
                'session_id' => $_SESSION['session_id'],
                'question_id' => (int) $response['qid'],
                'answer_id' => (int) $key,
                'answer' => (int) $r,
            ]);
        }
        
    }
    
    public function do_grid_question_multiple_choice($response){

        foreach($response['response'] as $key => $r){
            
            foreach($r as $_r){
                $this->insert([
                    'session_id' => $_SESSION['session_id'],
                    'question_id' => (int) $response['qid'],
                    'answer_id' => (int) $key,
                    'answer' => (int) $_r,
                ]);
                
            }
        }
        
    }
    
    public function do_nps_question($response){

        $this->insert([
            'session_id' => $_SESSION['session_id'],
            'question_id' => (int) $response['qid'],
            'answer' => (int) $response['response'],
        ]);
        
    }
    
    public function do_slide($response){

        $this->insert([
            'session_id' => $_SESSION['session_id'],
            'question_id' => (int) $response['qid'],
            'answer' => (int) $response['response'],
        ]);
        
    }
    
    public function do_dropdown_list($response){

        $this->insert([
            'session_id' => $_SESSION['session_id'],
            'question_id' => (int) $response['qid'],
            'answer_id' => (int) $response['response'],
        ]);
        
    }
    
    public function do_ranking($response){

        foreach($response['response'] as $key => $r){
            $this->insert([
                'session_id' => $_SESSION['session_id'],
                'question_id' => (int) $response['qid'],
                'answer_id' => (int) $r,
                'answer' => (int) $key + 1,
            ]);
        }
        
    }
    
    public function do_assigning_points($response){

        foreach($response['response'] as $key => $r){
            $this->insert([
                'session_id' => $_SESSION['session_id'],
                'question_id' => (int) $response['qid'],
                'answer_id' => (int) $key,
                'answer' => $r['points'],
            ]);
        }
        
    }
    
    public function do_add_attachment($response){

    }
    
    public function do_question_for_number($response){
        
        $this->insert([
            'session_id' => $_SESSION['session_id'],
            'question_id' => (int) $response['qid'],
            'answer' => $response['response'],
        ]); 
        
    }
    
    public function do_question_of_the_date($response){
        
        $this->insert([
            'session_id' => $_SESSION['session_id'],
            'question_id' => (int) $response['qid'],
            'answer' => $response['response'],
        ]); 
        
    }
    
    public function do_question_of_email($response){
        
        $this->insert([
            'session_id' => $_SESSION['session_id'],
            'question_id' => (int) $response['qid'],
            'answer' => $response['response'],
        ]); 
        
    }
    
    public function get_summary_question($question_id){
        
        $question_model = MFPModel::factory('Question')->find('id', '=', (int) $question_id);
        if(!isset($question_model->id)){
            return [];
        }

        $method_name = 'get_summary_'. $question_model->type;

        if(!method_exists($this, $method_name)){
            die(__('Error method save not exist!', 'mfpoll'));
        }

        return $this->{$method_name}($question_model);
    }
    
    public function get_summary_single_choice($question_model){
        
        $result = $this->db->get_results($this->db->prepare("SELECT `answer_id`, COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d GROUP BY `answer_id`", $question_model->id ), OBJECT);
        
        $return = [
            'summary' => [],
            'count_reply' => 0,
        ];
        
        foreach ($result as $row){
            $return['summary'][$row->answer_id] = (int) $row->count;
            $return['count_reply'] = $return['count_reply'] + $row->count;
        }
        
        return $return;
    }
    
    public function get_summary_multiple_choice($question_model){
        $result = $this->db->get_results($this->db->prepare("SELECT `answer_id`, COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d GROUP BY `answer_id`", $question_model->id ), OBJECT);
        
        $return = [
            'summary' => [],
            'count_reply' => 0,
        ];
        
        foreach ($result as $row){
            $return['summary'][$row->answer_id] = (int) $row->count;
            $return['count_reply'] = $return['count_reply'] + $row->count;
        }
        
        return $return;
    }
    
    public function get_summary_open_question($question_model){
        
        $result = $this->db->get_results($this->db->prepare("SELECT COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_model->id ), OBJECT);

        return $result[0];
    }
    
    public function get_summary_grid_question_single_choice($question_model){
        
        $summary = [
            'items' => [],
            'count' => 0
            ];
        
        $results = $this->db->get_results($this->db->prepare("SELECT `answer_id`, `answer` FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_model->id ), OBJECT);
        
        foreach ($results as $key => $row) {
            if(!isset($summary['items'][$row->answer_id][$row->answer])){
                $summary['items'][$row->answer_id][$row->answer] = 1;
            }else{
                $summary['items'][$row->answer_id][$row->answer]++;
            }
        }
        $summary['count'] = count($results);
        
        return $summary;
    }
    
    public function get_summary_grid_question_multiple_choice($question_model){
        
        $summary = [
            'items' => [],
            'count' => 0
            ];
        
        $results = $this->db->get_results($this->db->prepare("SELECT `answer_id`, `answer` FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_model->id ), OBJECT);
        
        foreach ($results as $key => $row) {
            if(!isset($summary['items'][$row->answer_id][$row->answer])){
                $summary['items'][$row->answer_id][$row->answer] = 1;
            }else{
                $summary['items'][$row->answer_id][$row->answer]++;
            }
        }
        $summary['count'] = count($results);
        
        return $summary;

    }
    
    public function get_summary_nps_question($question_model){
        
        $summary = [
            'items' => array_fill(1, 10, 0),
            'count' => 0
            ];
        
        $results = $this->db->get_results($this->db->prepare("SELECT `answer_id`, `answer` FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_model->id ), OBJECT);
        
        foreach ($results as $key => $row) {
            $summary['items'][$row->answer]++;
        }
        $summary['count'] = count($results);
         
        return $summary;
    }
    
    public function get_summary_slide($question_model){
        
        $results = $this->db->get_results($this->db->prepare("SELECT AVG(`answer`) as avg, COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_model->id ), OBJECT);
        
        return $results[0];
    }
    
    public function get_summary_dropdown_list($question_model){
        
        $result = $this->db->get_results($this->db->prepare("SELECT `answer_id`, COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d GROUP BY `answer_id`", $question_model->id ), OBJECT);
        
        $return = [
            'items' => [],
            'count' => 0,
        ];
        
        foreach ($result as $row){
            $return['items'][$row->answer_id] = (int) $row->count;
            $return['count'] = $return['count'] + $row->count;
        }
        
        return $return;
    }
    
    public function get_summary_ranking($question_model){
        
        $result = $this->db->get_results($this->db->prepare("SELECT `answer_id`, AVG(`answer`) as avg FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d GROUP BY `answer_id`", $question_model->id ), OBJECT);
        $count = $this->db->get_var($this->db->prepare("SELECT COUNT(`answer_id`) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d GROUP BY `answer_id` LIMIT 1", $question_model->id ));
        
        $return = [
            'items' => [],
            'count' => 0,
        ];
        
        foreach ($result as $row){
            $return['items'][$row->answer_id] = (float)$row->avg;
        }
        $return['count'] = $count;
        
        return $return;
    }
    
    public function get_summary_assigning_points($question_model){
        $result = $this->db->get_results($this->db->prepare("SELECT `answer_id`, AVG(`answer`) as avg FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d GROUP BY `answer_id`", $question_model->id ), OBJECT);
        $count = $this->db->get_var($this->db->prepare("SELECT COUNT(`answer_id`) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d GROUP BY `answer_id` LIMIT 1", $question_model->id ));
        
        $return = [
            'items' => [],
            'count' => 0,
        ];
        
        foreach ($result as $row){
            $return['items'][$row->answer_id] = (float)$row->avg;
        }
        $return['count'] = $count;
        
        return $return;
    }
    
    public function get_summary_add_attachment($question_model){
        return [];

    }
    
    public function get_summary_question_for_number($question_model){
        
        $results = $this->db->get_results($this->db->prepare("SELECT AVG(`answer`) as avg, COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_model->id ), OBJECT);
        
        return $results[0];

    }
    
    public function get_summary_question_of_the_date($question_model){
        
        $results = $this->db->get_var($this->db->prepare("SELECT COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_model->id ));
        
        return $results;

    }
    
    public function get_summary_question_of_email($question_model){
        
        $results = $this->db->get_var($this->db->prepare("SELECT COUNT(*) as count FROM `{$this->db->prefix}{$this->table_name}` WHERE `question_id` = %d", $question_model->id ));
        
        return $results;

    }
    
}