<?php
class messages_db {
	var $table_name = "plgsoft_messages";
	var $array_user_id = array();
	var $array_to_user_id = array();
	var $array_post_id = array();
	
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
	
	function get_array_to_user_id() {
		return $this->array_to_user_id; 
	}
	function set_array_to_user_id($array_to_user_id) {
		$this->array_to_user_id = $array_to_user_id;
	}
	
	function get_array_post_id() {
		return $this->array_post_id; 
	}
	function set_array_post_id($array_post_id) {
		$this->array_post_id = $array_post_id;
	}
	
	function get_total_new_messages($array_keywords=array()) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;		
		$sql = "SELECT COUNT(messages_id) AS cnt FROM " .$table_name.
				" WHERE 1=1 AND status='unread'";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$total_new_messages = $wpdb->get_var($sql);
		return $total_new_messages;
	}
	
	function get_total_messages($array_keywords=array()) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;		
		$sql = "SELECT COUNT(messages_id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$total_messages = $wpdb->get_var($sql);
		return $total_messages;
	}
	
	function get_all_messages($array_keywords=array(), $limit=0, $offset=0) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$array_result = array();		
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT messages_id, messages_title, messages_name, username, email, phone, 
				message, status, user_id, to_user_id, post_id, ref, date_added FROM " .$table_name. 
			" WHERE 1=1";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$sql .= " ORDER BY messages_id DESC";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;		
		}
		$list_results = $wpdb->get_results($sql);			
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->user_id, $this->array_user_id)) {
				$this->array_user_id[] = $item_obj->user_id; 
			}
			if (!in_array($item_obj->to_user_id, $this->array_to_user_id)) {
				$this->array_to_user_id[] = $item_obj->to_user_id; 
			}
			if (!in_array($item_obj->post_id, $this->array_post_id)) {
				$this->array_post_id[] = $item_obj->post_id; 
			}		
			$array_result[$index]['messages_id'] = $item_obj->messages_id;
			$array_result[$index]['messages_title'] = $item_obj->messages_title;
			$array_result[$index]['messages_name'] = $item_obj->messages_name;
			$array_result[$index]['username'] = $item_obj->username;
			$array_result[$index]['email'] = $item_obj->email;
			$array_result[$index]['phone'] = $item_obj->phone;
			$array_result[$index]['message'] = $item_obj->message;				
			$array_result[$index]['status'] = $item_obj->status;
			$array_result[$index]['user_id'] = $item_obj->user_id;
			$array_result[$index]['to_user_id'] = $item_obj->to_user_id;
			$array_result[$index]['post_id'] = $item_obj->post_id;
			$array_result[$index]['ref'] = $item_obj->ref;
			$array_result[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}			
		return $array_result;
	}
	
	function get_total_messages_sent($array_keywords=array()) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;		
		$sql = "SELECT COUNT(messages_id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$sql .= " AND date_added LIKE '" .date("Y-m-d"). "%'";
		$total_messages_sent = $wpdb->get_var($sql);
		return $total_messages_sent;
	}
		
	function get_plgsoft_messages_by_messages_id($messages_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE 1=1 AND messages_id='" . $messages_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['messages_id'] = $item_obj->messages_id;
				$result_obj['messages_title'] = $item_obj->messages_title;
				$result_obj['messages_name'] = $item_obj->messages_name;
				$result_obj['username'] = $item_obj->username;
				$result_obj['email'] = $item_obj->email;
				$result_obj['phone'] = $item_obj->phone;
				$result_obj['message'] = $item_obj->message;				
				$result_obj['status'] = $item_obj->status;
				$result_obj['user_id'] = $item_obj->user_id;
				$result_obj['to_user_id'] = $item_obj->to_user_id;
				$result_obj['post_id'] = $item_obj->post_id;
				$result_obj['ref'] = $item_obj->ref;
				$result_obj['date_added'] = $item_obj->date_added;
			}
			return $result_obj;
		}			
	}

	function insert_plgsoft_messages($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$messages_title = $wpdb->escape(trim($item_obj['messages_title']));
			$messages_name = $wpdb->escape(trim($item_obj['messages_name']));
			$username = $wpdb->escape(trim($item_obj['username']));
			$email = $wpdb->escape(trim($item_obj['email']));
			$phone = $wpdb->escape(trim($item_obj['phone']));
			$message = $wpdb->escape(trim($item_obj['message']));
			$status = $wpdb->escape(trim($item_obj['status']));
			$user_id = $wpdb->escape(trim($item_obj['user_id']));
			$to_user_id = $wpdb->escape(trim($item_obj['to_user_id']));
			$post_id = $wpdb->escape(trim($item_obj['post_id']));
			$ref = $wpdb->escape(trim($item_obj['ref']));
			$sql = "INSERT INTO ".$table_name."(messages_title, messages_name, username, email, phone, message, status, user_id, to_user_id, post_id, ref, date_added) " .
				" VALUES ('".$messages_title."', '".$messages_name."', '".$username."', '".$email."', '".$phone."', '".$message."', '".$status."', '" .$user_id. "', '" .$to_user_id. "', '".$post_id."', '".$ref."', NOW())";
			$wpdb->prepare($sql, array());
			$wpdb->query($sql);
		}
	}
	
	function update_plgsoft_messages($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$messages_id = $wpdb->escape(trim($item_obj['messages_id']));
			$messages_title = $wpdb->escape(trim($item_obj['messages_title']));
			$messages_name = $wpdb->escape(trim($item_obj['messages_name']));
			$username = $wpdb->escape(trim($item_obj['username']));
			$email = $wpdb->escape(trim($item_obj['email']));
			$phone = $wpdb->escape(trim($item_obj['phone']));
			$message = $wpdb->escape(trim($item_obj['message']));
			$status = $wpdb->escape(trim($item_obj['status']));
			$user_id = $wpdb->escape(trim($item_obj['user_id']));
			$to_user_id = $wpdb->escape(trim($item_obj['to_user_id']));
			$post_id = $wpdb->escape(trim($item_obj['post_id']));
			$ref = $wpdb->escape(trim($item_obj['ref']));
				
			$sql = "UPDATE ".$table_name." SET messages_title='" .$messages_title. "', " .
				" messages_name='" .$messages_name. "', " .
				" username='" .$username. "', " .
				" email='" .$email. "', " .			
				" phone='" .$phone. "', " .
				" message='" .$message. "', " .			
				" status='" .$status. "', " .
				" ref='" .$ref. "', " .
				" post_id='" .$post_id. "' " .
			" WHERE messages_id='" .$messages_id. "' AND user_id='" .$user_id. "'";
			$wpdb->prepare($sql, array());
			$wpdb->query($sql);
		}
	}
	
	function delete_plgsoft_messages($messages_id, $user_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($messages_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;			
			$sql = "DELETE FROM ".$table_name." WHERE messages_id='" .$wpdb->escape($messages_id). "' AND user_id='" .$user_id. "'";
			$wpdb->prepare($sql, array());
			$wpdb->query($sql);
		}	
	}
	
	function change_status_plgsoft_messages($status, $messages_id, $user_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {						
			$sql = "UPDATE ".$table_name." SET status='".$status."' WHERE messages_id='" .$messages_id. "' AND user_id='" .$user_id. "'";	
			$wpdb->prepare($sql, array());
			$wpdb->query($sql);
		}
	}
}
?>