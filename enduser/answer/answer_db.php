<?php
class answer_db {
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

	function get_total_answer($array_keywords=array()) {
		global $wpdb;
		$category_id = isset($array_keywords['category_id']) ? $array_keywords['category_id'] : 0;
		$question_id = isset($array_keywords['question_id']) ? $array_keywords['question_id'] : 0;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(answer_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		if ($category_id > 0) {
			$sql .= " AND category_id = '".$category_id."'";
		}
		if ($question_id > 0) {
			$sql .= " AND question_id = '".$question_id."'";
		}
		$total_answer = $wpdb->get_var($sql);
		return $total_answer;
	}

	function get_all_answer($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$category_id = isset($array_keywords['category_id']) ? $array_keywords['category_id'] : 0;
		$question_id = isset($array_keywords['question_id']) ? $array_keywords['question_id'] : 0;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT answer_id, answer_name, answer_description, order_listing, is_active, category_id, question_id, date_added FROM " .$table_name.
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
			$results[$index]['answer_id'] = $item_obj->answer_id;
			$results[$index]['answer_name'] = $item_obj->answer_name;
			$results[$index]['answer_description'] = $item_obj->answer_description;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['category_id'] = $item_obj->category_id;
			$results[$index]['question_id'] = $item_obj->question_id;
			$results[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}
		return $results;
	}

	function get_all_plgsoft_answer_by_array_answer_id($array_answer_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_answer_id) == 0) {
			return array();
		} else {
			$string_answer_id = implode("','", $array_answer_id);
			$sql = "SELECT answer_id, answer_name, answer_description, order_listing, is_active, category_id, question_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND answer_id IN ('".$string_answer_id."')";
			$list_results = $wpdb->get_results($sql);
			$results = array();
			foreach ($list_results as $item_obj) {
				$results[$item_obj->answer_id]['answer_id'] = $item_obj->answer_id;
				$results[$item_obj->answer_id]['answer_name'] = $item_obj->answer_name;
				$results[$item_obj->answer_id]['answer_description'] = $item_obj->answer_description;
				$results[$item_obj->answer_id]['is_active'] = $item_obj->is_active;
				$results[$item_obj->answer_id]['order_listing'] = $item_obj->order_listing;
				$results[$item_obj->answer_id]['category_id'] = $item_obj->category_id;
				$results[$item_obj->answer_id]['question_id'] = $item_obj->question_id;
				$results[$item_obj->answer_id]['date_added'] = $item_obj->date_added;
			}
			return $results;
		}
	}

	function get_all_plgsoft_answer_by_array_category_id($array_category_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_category_id) == 0) {
			return array();
		} else {
			$string_category_id = implode("','", $array_category_id);
			$sql = "SELECT answer_id, answer_name, answer_description, order_listing, is_active, category_id, question_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND category_id IN ('".$string_category_id."')";
			$list_results = $wpdb->get_results($sql);
			$results = array();
			foreach ($list_results as $item_obj) {
				$results[$item_obj->category_id][$item_obj->answer_id]['answer_id'] = $item_obj->answer_id;
				$results[$item_obj->category_id][$item_obj->answer_id]['answer_name'] = $item_obj->answer_name;
				$results[$item_obj->category_id][$item_obj->answer_id]['answer_description'] = $item_obj->answer_description;
				$results[$item_obj->category_id][$item_obj->answer_id]['is_active'] = $item_obj->is_active;
				$results[$item_obj->category_id][$item_obj->answer_id]['order_listing'] = $item_obj->order_listing;
				$results[$item_obj->category_id][$item_obj->answer_id]['category_id'] = $item_obj->category_id;
				$results[$item_obj->category_id][$item_obj->answer_id]['question_id'] = $item_obj->question_id;
				$results[$item_obj->category_id][$item_obj->answer_id]['date_added'] = $item_obj->date_added;
			}
			return $results;
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
			$sql .= " WHERE is_active='1' AND question_id IN ('".$string_question_id."')";
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
}
?>
