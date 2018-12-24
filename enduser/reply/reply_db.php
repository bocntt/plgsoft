<?php
class reply_db {
	var $table_name = "plgsoft_reply";
	var $array_category_id = array();
	var $array_question_id = array();
	var $array_user_id = array();

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_array_category_id() {
		return $this->array_category_id;
	}
	function set_array_category_id($array_category_id) {
		$this->array_category_id = $array_category_id;
	}

	function get_array_question_id() {
		return $this->array_question_id;
	}
	function set_array_question_id($array_question_id) {
		$this->array_question_id = $array_question_id;
	}

	function get_array_user_id() {
		return $this->array_user_id;
	}
	function set_array_user_id($array_user_id) {
		$this->array_user_id = $array_user_id;
	}

	function get_total_reply($array_keywords=array()) {
		global $wpdb;
		$category_id = isset($array_keywords['category_id']) ? $array_keywords['category_id'] : 0;
		$question_id = isset($array_keywords['question_id']) ? $array_keywords['question_id'] : 0;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(reply_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		if ($category_id > 0) {
			$sql .= " AND category_id = '".$category_id."'";
		}
		if ($question_id > 0) {
			$sql .= " AND question_id = '".$question_id."'";
		}
		$total_reply = $wpdb->get_var($sql);
		return $total_reply;
	}

	function get_all_reply($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$category_id = isset($array_keywords['category_id']) ? $array_keywords['category_id'] : 0;
		$question_id = isset($array_keywords['question_id']) ? $array_keywords['question_id'] : 0;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT reply_id, reply_name, reply_description, order_listing, is_active, category_id, question_id, user_id, date_added FROM " .$table_name.
				" WHERE is_active='1'";
		if ($category_id > 0) {
			$sql .= " AND category_id = '".$category_id."'";
		}
		if ($question_id > 0) {
			$sql .= " AND question_id = '".$question_id."'";
		}
		$sql .= " ORDER BY order_listing";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->category_id, $this->array_category_id)) {
				$this->array_category_id[] = $item_obj->category_id;
			}
			if (!in_array($item_obj->question_id, $this->array_question_id)) {
				$this->array_question_id[] = $item_obj->question_id;
			}
			if (!in_array($item_obj->user_id, $this->array_user_id)) {
				$this->array_user_id[] = $item_obj->user_id;
			}
			$results[$index]['reply_id'] = $item_obj->reply_id;
			$results[$index]['reply_name'] = $item_obj->reply_name;
			$results[$index]['reply_description'] = $item_obj->reply_description;
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['category_id'] = $item_obj->category_id;
			$results[$index]['question_id'] = $item_obj->question_id;
			$results[$index]['user_id'] = $item_obj->user_id;
			$results[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}
		return $results;
	}

	function get_all_plgsoft_reply_by_array_reply_id($array_reply_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_reply_id) == 0) {
			return array();
		} else {
			$string_reply_id = implode("','", $array_reply_id);
			$sql = "SELECT reply_id, reply_name, reply_description, order_listing, is_active, category_id, question_id, user_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND reply_id IN ('".$string_reply_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->reply_id]['reply_id'] = $item_obj->reply_id;
				$array_result[$item_obj->reply_id]['reply_name'] = $item_obj->reply_name;
				$array_result[$item_obj->reply_id]['reply_description'] = $item_obj->reply_description;
				$array_result[$item_obj->reply_id]['order_listing'] = $item_obj->order_listing;
				$array_result[$item_obj->reply_id]['is_active'] = $item_obj->is_active;
				$array_result[$item_obj->reply_id]['category_id'] = $item_obj->category_id;
				$array_result[$item_obj->reply_id]['question_id'] = $item_obj->question_id;
				$array_result[$item_obj->reply_id]['user_id'] = $item_obj->user_id;
				$array_result[$item_obj->reply_id]['date_added'] = $item_obj->date_added;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_reply_by_array_category_id($array_category_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_category_id) == 0) {
			return array();
		} else {
			$string_category_id = implode("','", $array_category_id);
			$sql = "SELECT reply_id, reply_name, reply_description, order_listing, is_active, category_id, question_id, user_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND category_id IN ('".$string_category_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->reply_id]['reply_id'] = $item_obj->reply_id;
				$array_result[$item_obj->reply_id]['reply_name'] = $item_obj->reply_name;
				$array_result[$item_obj->reply_id]['reply_description'] = $item_obj->reply_description;
				$array_result[$item_obj->reply_id]['order_listing'] = $item_obj->order_listing;
				$array_result[$item_obj->reply_id]['is_active'] = $item_obj->is_active;
				$array_result[$item_obj->reply_id]['category_id'] = $item_obj->category_id;
				$array_result[$item_obj->reply_id]['question_id'] = $item_obj->question_id;
				$array_result[$item_obj->reply_id]['user_id'] = $item_obj->user_id;
				$array_result[$item_obj->reply_id]['date_added'] = $item_obj->date_added;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_reply_by_array_question_id($array_question_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_question_id) == 0) {
			return array();
		} else {
			$string_question_id = implode("','", $array_question_id);
			$sql = "SELECT reply_id, reply_name, reply_description, order_listing, is_active, category_id, question_id, user_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND question_id IN ('".$string_question_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->reply_id]['reply_id'] = $item_obj->reply_id;
				$array_result[$item_obj->reply_id]['reply_name'] = $item_obj->reply_name;
				$array_result[$item_obj->reply_id]['reply_description'] = $item_obj->reply_description;
				$array_result[$item_obj->reply_id]['order_listing'] = $item_obj->order_listing;
				$array_result[$item_obj->reply_id]['is_active'] = $item_obj->is_active;
				$array_result[$item_obj->reply_id]['category_id'] = $item_obj->category_id;
				$array_result[$item_obj->reply_id]['question_id'] = $item_obj->question_id;
				$array_result[$item_obj->reply_id]['user_id'] = $item_obj->user_id;
				$array_result[$item_obj->reply_id]['date_added'] = $item_obj->date_added;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_reply_by_array_user_id($array_user_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_user_id) == 0) {
			return array();
		} else {
			$string_user_id = implode("','", $array_user_id);
			$sql = "SELECT reply_id, reply_name, reply_description, order_listing, is_active, category_id, question_id, user_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND user_id IN ('".$string_user_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->reply_id]['reply_id'] = $item_obj->reply_id;
				$array_result[$item_obj->reply_id]['reply_name'] = $item_obj->reply_name;
				$array_result[$item_obj->reply_id]['reply_description'] = $item_obj->reply_description;
				$array_result[$item_obj->reply_id]['order_listing'] = $item_obj->order_listing;
				$array_result[$item_obj->reply_id]['is_active'] = $item_obj->is_active;
				$array_result[$item_obj->reply_id]['category_id'] = $item_obj->category_id;
				$array_result[$item_obj->reply_id]['question_id'] = $item_obj->question_id;
				$array_result[$item_obj->reply_id]['user_id'] = $item_obj->user_id;
				$array_result[$item_obj->reply_id]['date_added'] = $item_obj->date_added;
			}
			return $array_result;
		}
	}

	function get_just_reply_id_by_params($params) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$reply_name = isset($params['reply_name']) ? $params['reply_name'] : "";
		$reply_description = isset($params['reply_description']) ? $params['reply_description'] : "";
		$order_listing = isset($params['order_listing']) ? $params['order_listing'] : 0;
		$is_active = isset($params['is_active']) ? $params['is_active'] : 0;
		$category_id = isset($params['category_id']) ? $params['category_id'] : 0;
		$question_id = isset($params['question_id']) ? $params['question_id'] : 0;
		$user_id = isset($params['user_id']) ? $params['user_id'] : 0;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT MAX(reply_id) " .
				" FROM " . $table_name . " WHERE 1=1 AND reply_name='" .$reply_name. "' AND reply_description='" .$reply_description.
				"' AND order_listing='" .$order_listing. "' AND is_active='" .$is_active. "' AND category_id='" .$category_id.
				"' AND question_id='" .$question_id. "' AND user_id='" .$user_id. "'";
			$reply_id = $wpdb->get_var($sql);
			if (strlen($reply_id) == 0) $reply_id = 0;
			return $reply_id;
		}
	}

	function insert_plgsoft_reply($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$reply_name        = isset($item_obj['reply_name']) ? trim($item_obj['reply_name']) : "";
			$reply_description = isset($item_obj['reply_description']) ? trim($item_obj['reply_description']) : "";
			$order_listing     = isset($item_obj['order_listing']) ? trim($item_obj['order_listing']) : "";
			$is_active         = isset($item_obj['is_active']) ? trim($item_obj['is_active']) : '';
			$category_id       = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$question_id       = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$user_id           = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$sql = "INSERT INTO ".$table_name."(reply_name, reply_description, order_listing, is_active, category_id, question_id, user_id, date_added) " .
				" VALUES ('%s', '%s', '%s', '%s', '%d', '%d', '%d', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$reply_name,
						$reply_description,
						$order_listing,
						$is_active,
						$category_id,
						$question_id,
						$user_id
					)
				)
			);
		}
	}

	function update_plgsoft_reply($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$reply_id          = isset($item_obj['reply_id']) ? (int) trim($item_obj['reply_id']) : 0;
			$reply_name        = isset($item_obj['reply_name']) ? trim($item_obj['reply_name']) : "";
			$reply_description = isset($item_obj['reply_description']) ? trim($item_obj['reply_description']) : "";
			$order_listing     = isset($item_obj['order_listing']) ? trim($item_obj['order_listing']) : "";
			$is_active         = isset($item_obj['is_active']) ? trim($item_obj['is_active']) : '';
			$category_id       = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$question_id       = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$user_id           = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$sql = "UPDATE ".$table_name." SET reply_name='%s', " .
				" reply_description='%s', " .
				" order_listing='%s', " .
				" is_active='%s', " .
				" category_id='%d', " .
				" question_id='%d', " .
				" user_id='%d' " .
			" WHERE reply_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$reply_name,
						$reply_description,
						$order_listing,
						$is_active,
						$category_id,
						$question_id,
						$user_id,
						$reply_id
					)
				)
			);
		}
	}

	function delete_plgsoft_reply($reply_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($reply_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE reply_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $reply_id));
		}
	}

	function delete_plgsoft_reply_by_question_id($question_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($question_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE question_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $question_id));
		}
	}
}
?>
