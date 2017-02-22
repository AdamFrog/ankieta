<?php

class MFPModel_Questions extends MFPModel {

    public $table_name = 'mf_poll_questions';

  	public $primary = 'poll_id';

    public function __construct(){
  		parent::__construct();
  	}

    public function find_all($key, $equation, $value, $setting = NULL){

      if($key == null){
        $key = $this->primary;
      }

      if($equation == null){
        return null;
      }

      $result = $this->db->get_results("SELECT {$this->db->prefix}{$this->table_name}.*, {$this->db->prefix}mf_poll_question_types.name as question_type FROM {$this->db->prefix}{$this->table_name} LEFT JOIN {$this->db->prefix}mf_poll_question_types on {$this->db->prefix}{$this->table_name}.question_type_id = {$this->db->prefix}mf_poll_question_types.question_type_id  WHERE {$key} {$equation} {$value} {$setting}");


      return $result;

    }

}

 ?>
