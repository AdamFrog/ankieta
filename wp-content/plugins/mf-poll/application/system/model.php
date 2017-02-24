<?php

class MFPModel{

	public $db = null;

	public function __construct(){

		global $wpdb;

		$this->db = $wpdb;

	}
	
	public static function factory($name){

		$file =  MFPPATH . 'model/' . strtolower($name). '.php';

		if(file_exists($file)){
			require_once($file);
		}
		$model = MFPPATH . 'Model_'. ucfirst(strtolower($name));
		return new $model;

	}

	public function insert(array $array){

		$keys = implode(',', array_keys($array));

		$values = "'". implode("','", $array) . "'";

		$this->db->query("INSERT INTO {$this->db->prefix}{$this->table_name} ({$keys}) VALUES ({$values})");

		return $this->db->insert_id;

	}

	public function find($key, $equation, $value){

		if($key == null){
			$key = $this->primary;
		}

		if($equation == null){
			return null;
		}


		$result = $this->db->get_row("SELECT * FROM {$this->db->prefix}{$this->table_name} WHERE {$key} {$equation} {$value} LIMIT 1");

		return $result;

	}

	public function find_all($key, $equation, $value, $setting = null){

		if($key == null){
			$key = $this->primary;
		}

		if($equation == null){
			return null;
		}


		$result = $this->db->get_results("SELECT * FROM {$this->db->prefix}{$this->table_name} WHERE {$key} {$equation} {$value} {$setting}");

		return $result;

	}

	public function update(array $array, array $where){

		$keys = array_keys($array);

		$update = array();

		foreach ($keys as $key) {
			$update[] = $key . "='" . $array[$key] . "'";
		}

		$update = implode(',', $update);
		
		if($where[0] == null){
			$where[0] = $this->primary;
		}

		$result = $this->db->query("UPDATE {$this->db->prefix}{$this->table_name} SET {$update} WHERE {$where[0]} {$where[1]} {$where[2]}");

		return $result;

	}

	public function delete($key, $equation, $value){

		if($key == null){
			$key = $this->primary;
		}

		if($equation == null){
			return null;
		}


		$result = $this->db->query("DELETE FROM {$this->db->prefix}{$this->table_name} WHERE {$key} {$equation} {$value} LIMIT 1");

		return $result;

	}

	public function query($query){

		$result = $this->db->query($query);

		return $result;

	}

}