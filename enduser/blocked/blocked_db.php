<?php
class blocked_db {
	var $table_name = "plgsoft_blocked";
	var $array_user_id = array();
	var $array_user_blocked_id = array();
	
	function get_table_name() {
		return $this->table_name; 
	}	
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}
	
	function get_array_user_id() {
		return $this->array_user_id; 
	}
	function set_array_user_id($array_user_id) {
		$this->array_user_id = $array_user_id;
	}
	
	function get_array_user_blocked_id() {
		return $this->array_user_blocked_id; 
	}
	function set_array_user_blocked_id($array_user_blocked_id) {
		$this->array_user_blocked_id = $array_user_blocked_id;
	}
	
	function get_total_blocked($array_keywords=array()) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;		
		$sql = "SELECT COUNT(blocked_id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$total_blocked = $wpdb->get_var($sql);
		return $total_blocked;
	}
	
	function get_all_blocked($array_keywords=array(), $limit=0, $offset=0) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$results = array();		
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT blocked_id, user_id, user_blocked_id, date_added FROM " .$table_name. 
			" WHERE 1=1";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$sql .= " ORDER BY user_id";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;		
		}
		$list_results = $wpdb->get_results($sql);			
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->user_id, $this->array_user_id)) {
				$this->array_user_id[] = $item_obj->user_id; 
			}
			if (!in_array($item_obj->user_blocked_id, $this->array_user_blocked_id)) {
				$this->array_user_blocked_id[] = $item_obj->user_blocked_id; 
			}		
			$results[$index]['blocked_id'] = $item_obj->blocked_id;
			$results[$index]['user_id'] = $item_obj->user_id;
			$results[$index]['user_blocked_id'] = $item_obj->user_blocked_id;
			$results[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}			
		return $results;
	}
}
?>