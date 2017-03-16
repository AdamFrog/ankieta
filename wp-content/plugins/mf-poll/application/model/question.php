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
class MFPModel_Question extends MFPModel {
    
    protected $table_name = 'poll_question';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_count_page($poll_id){
        $result = $this->db->query("SELECT count(*) FROM {$this->db->prefix}{$this->table_name} WHERE `poll_id` = {$poll_id} GROUP BY `page`");

        return $result;
    }
}
