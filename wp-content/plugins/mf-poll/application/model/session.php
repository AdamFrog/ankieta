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
class MFPModel_Session extends MFPModel {
    
    /**
     * Nazwa tabeli w bazie danych
     * @var string 
     */
    protected $table_name = 'poll_session';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Tworzy sesje i zapisuje ją w bazie
     * @param int $poll_id
     * @return \MFPModel_Session
     */
    public function start_session($poll_id){
        
        session_name('ANKIETAMOTOFOCUSPL');
        session_id('ankietamotofocuspl');
        session_start();
        
        if(!isset($_SESSION['poll'][$poll_id])){
            
            $_SESSION['poll'][$poll_id] = [
                'id' => $poll_id,
                'date_start' => date('Y-m-d H:i:s'),
                'page' => null,
                'q' => null,
            ];
            
            $_SESSION['session_id'] = $this->insert([
                'poll_id' => $poll_id,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'start' => date('Y-m-d H:i:s'),
                'step' => 'open',
                'useragent' => $_SERVER['HTTP_USER_AGENT'],
            ]);
        }
        //session_destroy();
        return $this;
        
    }
    
    /**
     * Uzupelnia krok jeśli użytkownik przeszedł do nastepnej strony, otworzył formularz, zakończył badanie itp
     * @param string $string
     * @return \MFPModel_Session
     */
    public function update_step($string = null){
        if($string == null){
            return $this;
        }
        
        $this->update(['step' => $string], ['id', '=', $_SESSION['session_id']]);
        return $this;
        
    }
    
    
    public function get_summary_poll($poll_id){
        
        $result_query = $this->db->get_results($this->db->prepare(
            "SELECT count(id) as count, step FROM {$this->db->prefix}{$this->table_name} WHERE poll_id = %d GROUP BY step ORDER BY step", $poll_id
        ), OBJECT);
            
        $result = [
            'end' => 0,
            'open' => 0,
            'page' => [],
            'count_users' => 0,
        ];
        $count_users = 0;
        foreach ($result_query as $row){
            if(preg_match('/page/i', $row->step)){
                $_key = explode('-', $row->step);
                $result['count_users'] = $result['count_users'] + $row->count;
                $result['page'][] = ['count' => $row->count, 'page_id' => $_key[1]];
                continue;
            }
            $result[$row->step] = $row->count;
        }
        $result['count_users'] = $result['count_users'] + $result['open'] + $result['end'];
    
        return $result;
        
    }
    
    public function update_end(){
        
        $this->update(['end' => date('Y-m-d H:i:s')], ['id', '=', $_SESSION['session_id']]);
        
    }
}
