<?php
class question_database {
	var $table_name = "plgsoft_question";
	var $array_category_id = array();
	var $array_question_id = array();

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

	function get_total_plgsoft_question($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$category_id = isset($array_keywords['category_id']) ? $array_keywords['category_id'] : 0;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(question_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(question_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(question_description) LIKE '%".$keyword."%')";
			}
			if ($category_id > 0) {
				$sql .= " AND category_id = '".$category_id."'";
			}
			$total_question = $wpdb->get_var($sql);
			return $total_question;
		}
	}

	function get_list_plgsoft_question($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$category_id = isset($array_keywords['category_id']) ? $array_keywords['category_id'] : 0;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT question_id, question_name, question_description, question_type, have_other_answer, order_listing, is_optional, is_active, category_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(question_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(question_description) LIKE '%".$keyword."%')";
			}
			if ($category_id > 0) {
				$sql .= " AND category_id = '".$category_id."'";
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
				$array_result[$index]['question_id'] = $item_obj->question_id;
				$array_result[$index]['question_name'] = $item_obj->question_name;
				$array_result[$index]['question_description'] = $item_obj->question_description;
				$array_result[$index]['question_type'] = $item_obj->question_type;
				$array_result[$index]['have_other_answer'] = $item_obj->have_other_answer;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['is_optional'] = $item_obj->is_optional;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['category_id'] = $item_obj->category_id;
				$array_result[$index]['date_added'] = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
	}

	function get_list_plgsoft_question_by_category_id($category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT question_id, question_name, question_description, question_type, have_other_answer, order_listing, is_optional, is_active, category_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			$sql .= " AND category_id = '%d'";
			$sql .= " ORDER BY order_listing";
			$array_result = $wpdb->get_results($wpdb->prepare($sql, $category_id), ARRAY_A);
			return $array_result;
		}
	}

	function get_all_plgsoft_question_by_array_question_id($array_question_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_question_id) == 0) {
			return array();
		} else {
			$string_question_id = implode("','", $array_question_id);
			$sql = "SELECT question_id, question_name " .
				" FROM " . $table_name;
			$sql .= " WHERE question_id IN ('".$string_question_id."')";
			$sql .= " ORDER BY order_listing";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->question_id] = $item_obj->question_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_question_by_question_id($question_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE question_id='" . $question_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['question_id'] = $item_obj->question_id;
				$result_obj['question_name'] = $item_obj->question_name;
				$result_obj['question_description'] = $item_obj->question_description;
				$result_obj['question_type'] = $item_obj->question_type;
				$result_obj['have_other_answer'] = $item_obj->have_other_answer;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_optional'] = $item_obj->is_optional;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['category_id'] = $item_obj->category_id;
				$result_obj['date_added'] = $item_obj->date_added;
			}
			return $result_obj;
		}
	}

	function check_exist_question_name($question_name, $category_id, $question_id=0) {
		global $wpdb;
		$question_name = strtolower(trim($question_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(question_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(question_name)='%s' AND category_id = '%d' AND question_id <> '%d'";
			$total_question = $wpdb->get_var($wpdb->prepare($sql, array($question_name, $category_id, $question_id)));
			if ($total_question == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_question($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$question_name        = isset($item_obj['question_name']) ? trim($item_obj['question_name']) : "";
			$question_description = isset($item_obj['question_description']) ? trim($item_obj['question_description']) : "";
			$question_type        = isset($item_obj['question_type']) ? trim($item_obj['question_type']) : "";
			$have_other_answer    = isset($item_obj['have_other_answer']) ? (int) trim($item_obj['have_other_answer']) : 0;
			$order_listing        = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_optional          = isset($item_obj['is_optional']) ? (int) trim($item_obj['is_optional']) : 0;
			$is_active            = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$category_id          = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$sql = "INSERT INTO ".$table_name."(question_name, question_description, question_type, have_other_answer, order_listing, is_optional, is_active, category_id, date_added) " .
				" VALUES ('%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$question_name,
						$question_description,
						$question_type,
						$have_other_answer,
						$order_listing,
						$is_optional,
						$is_active,
						$category_id
					)
				)
			);
		}
	}

	function update_plgsoft_question($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$question_id          = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$question_name        = isset($item_obj['question_name']) ? trim($item_obj['question_name']) : "";
			$question_description = isset($item_obj['question_description']) ? trim($item_obj['question_description']) : "";
			$question_type        = isset($item_obj['question_type']) ? trim($item_obj['question_type']) : "";
			$have_other_answer    = isset($item_obj['have_other_answer']) ? (int) trim($item_obj['have_other_answer']) : 0;
			$order_listing        = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_optional          = isset($item_obj['is_optional']) ? (int) trim($item_obj['is_optional']) : 0;
			$is_active            = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$category_id          = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$sql = "UPDATE ".$table_name." SET question_name='%s', " .
				" question_description='%s', " .
				" question_type='%s', " .
				" have_other_answer='%d', " .
				" order_listing='%d', " .
				" is_optional='%d', " .
				" is_active='%d', " .
				" category_id='%d' " .
			" WHERE question_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$question_name,
						$question_description,
						$question_type,
						$have_other_answer,
						$order_listing,
						$is_optional,
						$is_active,
						$category_id,
						$question_id
					)
				)
			);
		}
	}

	function delete_plgsoft_question($question_id) {
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

	function active_plgsoft_question($question_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE question_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$question_id
				)
			);
		}
	}

	function deactive_plgsoft_question($question_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE question_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$question_id
				)
			);
		}
	}
}
?>
