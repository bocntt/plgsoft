<?php
class quotesmeta_db {
	var $table_name = "quotes_meta";
	var $array_from_user = array();
	var $array_to_user = array();
	
	function get_table_name() {
		return $this->table_name; 
	}	
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}
	
	function get_array_from_user() {
		return $this->array_from_user; 
	}
	function set_array_from_user($array_from_user) {
		$this->array_from_user = $array_from_user;
	}
	
	function get_array_to_user() {
		return $this->array_to_user; 
	}
	function set_array_to_user($array_to_user) {
		$this->array_to_user = $array_to_user;
	}
	
	function get_total_quotesmeta($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;		
		$sql = "SELECT COUNT(id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		$total_quotesmeta = $wpdb->get_var($sql);
		return $total_quotesmeta;
	}
	
	function get_all_quotesmeta($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();		
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT id, estimate, content, attachment, quotes_id, from_user, 
				to_user, status, time FROM " .$table_name. 
			" WHERE 1=1" .
			" ORDER BY status";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;		
		}
		$list_results = $wpdb->get_results($sql);			
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->from_user, $this->array_from_user)) {
				$this->array_from_user[] = $item_obj->from_user; 
			}
			if (!in_array($item_obj->to_user, $this->array_to_user)) {
				$this->array_to_user[] = $item_obj->to_user; 
			}		
			$results[$index]['id'] = $item_obj->id;
			$results[$index]['estimate'] = $item_obj->estimate;
			$results[$index]['content'] = $item_obj->content;
			$results[$index]['attachment'] = $item_obj->attachment;
			$results[$index]['quotes_id'] = $item_obj->quotes_id;
			$results[$index]['from_user'] = $item_obj->from_user;
			$results[$index]['to_user'] = $item_obj->to_user;				
			$results[$index]['status'] = $item_obj->status;
			$results[$index]['time'] = $item_obj->time;
			$index++;
		}			
		return $results;
	}
	
	function get_plgsoft_quotesmeta_by_id($id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE 1=1 AND id='" . $id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['id'] = $item_obj->id;
				$result_obj['estimate'] = $item_obj->estimate;
				$result_obj['content'] = $item_obj->content;
				$result_obj['attachment'] = $item_obj->attachment;
				$result_obj['quotes_id'] = $item_obj->quotes_id;
				$result_obj['from_user'] = $item_obj->from_user;
				$result_obj['to_user'] = $item_obj->to_user;				
				$result_obj['status'] = $item_obj->status;
				$result_obj['time'] = $item_obj->time;
			}
			return $result_obj;
		}			
	}	
}
?>