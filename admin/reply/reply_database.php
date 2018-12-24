<?php
class reply_database {
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

	function get_total_plgsoft_reply($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(reply_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(reply_name) LIKE '%".$keyword."%')";
			}
			$total_reply = $wpdb->get_var($sql);
			return $total_reply;
		}
	}

	function get_list_plgsoft_reply($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT reply_id, reply_name, reply_description, order_listing, is_active, category_id, question_id, user_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(reply_name) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY order_listing";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
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
				$array_result[$index]['reply_id'] = $item_obj->reply_id;
				$array_result[$index]['reply_name'] = $item_obj->reply_name;
				$array_result[$index]['reply_description'] = $item_obj->reply_description;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['category_id'] = $item_obj->category_id;
				$array_result[$index]['question_id'] = $item_obj->question_id;
				$array_result[$index]['user_id'] = $item_obj->user_id;
				$array_result[$index]['date_added'] = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
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
			$sql .= " WHERE reply_id IN ('".$string_reply_id."')";
			$sql .= " ORDER BY order_listing";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->reply_id] = $item_obj->reply_name;
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
			$sql .= " WHERE question_id IN ('".$string_question_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->question_id]['reply_id'] = $item_obj->reply_id;
				$array_result[$item_obj->question_id]['reply_name'] = $item_obj->reply_name;
				$array_result[$item_obj->question_id]['reply_description'] = $item_obj->reply_description;
				$array_result[$item_obj->question_id]['order_listing'] = $item_obj->order_listing;
				$array_result[$item_obj->question_id]['is_active'] = $item_obj->is_active;
				$array_result[$item_obj->question_id]['category_id'] = $item_obj->category_id;
				$array_result[$item_obj->question_id]['question_id'] = $item_obj->question_id;
				$array_result[$item_obj->question_id]['user_id'] = $item_obj->user_id;
				$array_result[$item_obj->question_id]['date_added'] = $item_obj->date_added;
			}
			return $array_result;
		}
	}

	function get_plgsoft_reply_by_reply_id($reply_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE reply_id='" . $reply_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['reply_id'] = $item_obj->reply_id;
				$result_obj['reply_name'] = $item_obj->reply_name;
				$result_obj['reply_description'] = $item_obj->reply_description;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['category_id'] = $item_obj->category_id;
				$result_obj['question_id'] = $item_obj->question_id;
				$result_obj['user_id'] = $item_obj->user_id;
				$result_obj['date_added'] = $item_obj->date_added;
			}
			return $result_obj;
		}
	}

	function check_exist_reply_name($reply_name, $question_id, $category_id, $reply_id=0) {
		global $wpdb;
		$reply_name = strtolower(trim($reply_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(reply_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(reply_name)='".esc_sql($reply_name)."' AND question_id = '".$question_id."' AND category_id = '".$category_id."' AND reply_id <> '".$reply_id."'";
			$total_reply = $wpdb->get_var($sql);
			if ($total_reply == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_reply($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$reply_name        = isset($item_obj['reply_name']) ? trim($item_obj['reply_name']) : "";
			$reply_description = isset($item_obj['reply_description']) ? trim($item_obj['reply_description']) : "";
			$order_listing     = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_active         = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$category_id       = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$question_id       = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$user_id           = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$sql = "INSERT INTO ".$table_name."(reply_name, reply_description, order_listing, is_active, category_id, question_id, user_id, date_added) " .
				" VALUES ('%s', '%s', '%d', '%d', '%d', '%d', '%d', NOW())";
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
			$order_listing     = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_active         = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$category_id       = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$question_id       = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$user_id           = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$sql = "UPDATE ".$table_name." SET reply_name='%s', " .
				" reply_description='%s', " .
				" order_listing='%d', " .
				" is_active='%d', " .
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
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$reply_id
				)
			);
		}
	}

	function delete_plgsoft_reply_by_question_id($question_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($question_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE question_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$question_id
				)
			);
		}
	}

	function active_plgsoft_reply($reply_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE reply_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$reply_id
				)
			);
		}
	}

	function deactive_plgsoft_reply($reply_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE reply_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$reply_id
				)
			);
		}
	}
}
?>
