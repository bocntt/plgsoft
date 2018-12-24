<?php
class friend_db {
	var $table_name = "plgsoft_friend";
	var $array_user_id = array();
	var $array_user_friend_id = array();
	
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
	
	function get_array_user_friend_id() {
		return $this->array_user_friend_id; 
	}
	function set_array_user_friend_id($array_user_friend_id) {
		$this->array_user_friend_id = $array_user_friend_id;
	}
	
	function get_total_friend($array_keywords=array()) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;		
		$sql = "SELECT COUNT(friend_id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$total_friend = $wpdb->get_var($sql);
		return $total_friend;
	}
	
	function get_all_friend($array_keywords=array(), $limit=0, $offset=0) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$results = array();		
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT friend_id, user_id, user_friend_id, date_added FROM " .$table_name. 
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
			if (!in_array($item_obj->user_friend_id, $this->array_user_friend_id)) {
				$this->array_user_friend_id[] = $item_obj->user_friend_id; 
			}		
			$results[$index]['friend_id'] = $item_obj->friend_id;
			$results[$index]['user_id'] = $item_obj->user_id;
			$results[$index]['user_friend_id'] = $item_obj->user_friend_id;
			$results[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}			
		return $results;
	}
}
?>