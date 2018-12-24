<?php
class answer_database {
	var $table_name = "plgsoft_answer";
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

	function get_total_plgsoft_answer($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(answer_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(answer_name) LIKE '%".$keyword."%')";
			}
			$total_answer = $wpdb->get_var($sql);
			return $total_answer;
		}
	}

	function get_list_plgsoft_answer($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT answer_id, answer_name, answer_description, order_listing, is_active, category_id, question_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(answer_name) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY question_id DESC";
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
				$array_result[$index]['answer_id'] = $item_obj->answer_id;
				$array_result[$index]['answer_name'] = $item_obj->answer_name;
				$array_result[$index]['answer_description'] = $item_obj->answer_description;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['category_id'] = $item_obj->category_id;
				$array_result[$index]['question_id'] = $item_obj->question_id;
				$array_result[$index]['date_added'] = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_answer_by_array_answer_id($array_answer_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_answer_id) == 0) {
			return array();
		} else {
			$string_answer_id = implode("','", $array_answer_id);
			$sql = "answer_id, answer_name, answer_description, order_listing, is_active, category_id, question_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE answer_id IN ('".$string_answer_id."')";
			$sql .= " ORDER BY order_listing";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->answer_id] = $item_obj->answer_name;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_answer_by_array_question_id($array_question_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_question_id) == 0) {
			return array();
		} else {
			$string_question_id = implode("','", $array_question_id);
			$sql = "SELECT answer_id, answer_name, answer_description, order_listing, is_active, category_id, question_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE question_id IN ('".$string_question_id."')";
			$sql .= " ORDER BY order_listing";
			$list_results = $wpdb->get_results($sql);
			$results = array();
			foreach ($list_results as $item_obj) {
				$results[$item_obj->question_id][$item_obj->answer_id]['answer_id'] = $item_obj->answer_id;
				$results[$item_obj->question_id][$item_obj->answer_id]['answer_name'] = $item_obj->answer_name;
				$results[$item_obj->question_id][$item_obj->answer_id]['answer_description'] = $item_obj->answer_description;
				$results[$item_obj->question_id][$item_obj->answer_id]['is_active'] = $item_obj->is_active;
				$results[$item_obj->question_id][$item_obj->answer_id]['order_listing'] = $item_obj->order_listing;
				$results[$item_obj->question_id][$item_obj->answer_id]['category_id'] = $item_obj->category_id;
				$results[$item_obj->question_id][$item_obj->answer_id]['question_id'] = $item_obj->question_id;
				$results[$item_obj->question_id][$item_obj->answer_id]['date_added'] = $item_obj->date_added;
			}
			return $results;
		}
	}

	function get_plgsoft_answer_by_answer_id($answer_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE answer_id='" . $answer_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['answer_id'] = $item_obj->answer_id;
				$result_obj['answer_name'] = $item_obj->answer_name;
				$result_obj['answer_description'] = $item_obj->answer_description;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['category_id'] = $item_obj->category_id;
				$result_obj['question_id'] = $item_obj->question_id;
				$result_obj['date_added'] = $item_obj->date_added;
			}
			return $result_obj;
		}
	}

	function check_exist_answer_name($answer_name, $question_id, $category_id, $answer_id=0) {
		global $wpdb;
		$answer_name = strtolower(trim($answer_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(answer_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(answer_name)='%s' AND question_id = '%d' AND category_id = '%d' AND answer_id <> '%d'";
			$total_answer = $wpdb->get_var($wpdb->prepare($sql, array($answer_name, $question_id, $category_id, $answer_id)));
			if ($total_answer == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_answer($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$answer_name        = isset($item_obj['answer_name']) ? trim($item_obj['answer_name']) : "";
			$answer_description = isset($item_obj['answer_description']) ? trim($item_obj['answer_description']) : "";
			$order_listing      = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_active          = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$category_id        = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$question_id        = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$sql = "INSERT INTO ".$table_name."(answer_name, order_listing, is_active, answer_description, category_id, question_id, date_added) " .
				" VALUES ('%s', '%d', '%d', '%s', '%d', '%d', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$answer_name,
						$order_listing,
						$is_active,
						$answer_description,
						$category_id,
						$question_id
					)
				)
			);
		}
	}

	function update_plgsoft_answer($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$answer_id          = isset($item_obj['answer_id']) ? (int) trim($item_obj['answer_id']) : 0;
			$answer_name        = isset($item_obj['answer_name']) ? trim($item_obj['answer_name']) : "";
			$answer_description = isset($item_obj['answer_description']) ? trim($item_obj['answer_description']) : "";
			$order_listing      = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_active          = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$category_id        = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$question_id        = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$sql = "UPDATE ".$table_name." SET answer_name='%s', " .
				" answer_description='%s', " .
				" order_listing='%d', " .
				" is_active='%d', " .
				" category_id='%d', " .
				" question_id='%d' " .
			" WHERE answer_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$answer_name,
						$answer_description,
						$order_listing,
						$is_active,
						$category_id,
						$question_id,
						$answer_id
					)
				)
			);
		}
	}

	function delete_plgsoft_answer($answer_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($answer_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE answer_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$answer_id
				)
			);
		}
	}

	function delete_plgsoft_answer_by_question_id($question_id) {
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

	function active_plgsoft_answer($answer_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE answer_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$answer_id
				)
			);
		}
	}

	function deactive_plgsoft_answer($answer_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE answer_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$answer_id
				)
			);
		}
	}
}
?>
