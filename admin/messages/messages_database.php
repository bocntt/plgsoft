<?php
class messages_database {
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

	function get_total_plgsoft_messages($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(messages_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(messages_title) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(messages_name) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(email) LIKE '%%%s%%')";
				$total_messages = $wpdb->get_var($wpdb->prepare($sql, array($keyword, $keyword, $keyword)));
			} else {
				$total_messages = $wpdb->get_var($sql);
			}
			return $total_messages;
		}
	}

	function get_list_plgsoft_messages($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT messages_id, messages_title, messages_name, username, email, phone,
				message, status, user_id, to_user_id, post_id, ref, date_added" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(messages_title) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(messages_name) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(email) LIKE '%%%s%%')";
			}
			$sql .= " ORDER BY messages_id DESC";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			if (strlen($keyword) > 0) {
				$list_results = $wpdb->get_results($wpdb->prepare($sql, array($keyword, $keyword, $keyword)));
			} else {
				$list_results = $wpdb->get_results($sql);
			}
			$array_result = array();
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
				$array_result[$index]['messages_id']    = $item_obj->messages_id;
				$array_result[$index]['messages_title'] = $item_obj->messages_title;
				$array_result[$index]['messages_name']  = $item_obj->messages_name;
				$array_result[$index]['username']       = $item_obj->username;
				$array_result[$index]['email']          = $item_obj->email;
				$array_result[$index]['phone']          = $item_obj->phone;
				$array_result[$index]['message']        = $item_obj->message;
				$array_result[$index]['status']         = $item_obj->status;
				$array_result[$index]['user_id']        = $item_obj->user_id;
				$array_result[$index]['to_user_id']     = $item_obj->to_user_id;
				$array_result[$index]['post_id']        = $item_obj->post_id;
				$array_result[$index]['ref']            = $item_obj->ref;
				$array_result[$index]['date_added']     = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_messages_by_messages_id($messages_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE messages_id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $messages_id), ARRAY_A);
			return $result_obj;
		}
	}

	function insert_plgsoft_messages($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$messages_title = isset($item_obj['messages_title']) ? trim($item_obj['messages_title']) : "";
			$messages_name  = isset($item_obj['messages_name']) ? trim($item_obj['messages_name']) : "";
			$username       = isset($item_obj['username']) ? trim($item_obj['username']) : "";
			$email          = isset($item_obj['email']) ? trim($item_obj['email']) : "";
			$phone          = isset($item_obj['phone']) ? trim($item_obj['phone']) : "";
			$message        = isset($item_obj['message']) ? trim($item_obj['message']) : "";
			$status         = isset($item_obj['status']) ? trim($item_obj['status']) : "";
			$user_id        = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$to_user_id     = isset($item_obj['to_user_id']) ? (int) trim($item_obj['to_user_id']) : 0;
			$post_id        = isset($item_obj['post_id']) ? (int) trim($item_obj['post_id']) : 0;
			$ref            = isset($item_obj['ref']) ? trim($item_obj['ref']) : "";
			$sql = "INSERT INTO ".$table_name."(messages_title, messages_name, username, email, phone, message, status, user_id, to_user_id, post_id, ref, date_added) " .
				" VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$messages_title,
						$messages_name,
						$username,
						$email,
						$phone,
						$message,
						$status,
						$user_id,
						$to_user_id,
						$post_id,
						$ref
					)
				)
			);
		}
	}

	function update_plgsoft_messages($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$messages_id    = isset($item_obj['messages_id']) ? (int) trim($item_obj['messages_id']) : 0;
			$messages_title = isset($item_obj['messages_title']) ? trim($item_obj['messages_title']) : "";
			$messages_name  = isset($item_obj['messages_name']) ? trim($item_obj['messages_name']) : "";
			$username       = isset($item_obj['username']) ? trim($item_obj['username']) : "";
			$email          = isset($item_obj['email']) ? trim($item_obj['email']) : "";
			$phone          = isset($item_obj['phone']) ? trim($item_obj['phone']) : "";
			$message        = isset($item_obj['message']) ? trim($item_obj['message']) : "";
			$status         = isset($item_obj['status']) ? trim($item_obj['status']) : "";
			$user_id        = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$to_user_id     = isset($item_obj['to_user_id']) ? (int) trim($item_obj['to_user_id']) : 0;
			$post_id        = isset($item_obj['post_id']) ? (int) trim($item_obj['post_id']) : 0;
			$ref            = isset($item_obj['ref']) ? trim($item_obj['ref']) : "";

			$sql = "UPDATE ".$table_name." SET messages_title='%s', " .
				" messages_name='%s', " .
				" username='%s', " .
				" email='%s', " .
				" phone='%s', " .
				" message='%s', " .
				" status='%s', " .
				" user_id='%d', " .
				" to_user_id='%d', " .
				" ref='%s', " .
				" post_id='%d' " .
			" WHERE messages_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$messages_title,
						$messages_name,
						$username,
						$email,
						$phone,
						$message,
						$status,
						$user_id,
						$to_user_id,
						$ref,
						$post_id,
						$messages_id
					)
				)
			);
		}
	}

	function delete_plgsoft_messages($messages_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($messages_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE messages_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$messages_id
				)
			);
		}
	}
}
?>
