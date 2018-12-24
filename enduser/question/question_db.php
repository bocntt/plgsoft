<?php
class question_db {
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

	function get_total_question($array_keywords=array()) {
		global $wpdb;
		$category_id = isset($array_keywords['category_id']) ? $array_keywords['category_id'] : 0;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(question_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		$sql .= " AND category_id = '".$category_id."'";
		$total_question = $wpdb->get_var($sql);
		return $total_question;
	}

	function get_all_question($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$category_id = isset($array_keywords['category_id']) ? $array_keywords['category_id'] : 0;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT question_id, question_name, question_description, question_type, have_other_answer, order_listing, is_optional, is_active, category_id, date_added FROM " .$table_name.
				" WHERE is_active='1'";
		if ($category_id > 0) {
			$sql .= " AND category_id = '".$category_id."'";
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
			$results[$index]['question_id'] = $item_obj->question_id;
			$results[$index]['question_name'] = $item_obj->question_name;
			$results[$index]['question_description'] = $item_obj->question_description;
			$results[$index]['question_type'] = $item_obj->question_type;
			$results[$index]['have_other_answer'] = $item_obj->have_other_answer;
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['is_optional'] = $item_obj->is_optional;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['category_id'] = $item_obj->category_id;
			$results[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}
		return $results;
	}

	function get_all_plgsoft_question_by_array_question_id($array_question_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_question_id) == 0) {
			return array();
		} else {
			$string_question_id = implode("','", $array_question_id);
			$sql = "SELECT question_id, question_name, question_description, question_type, have_other_answer, order_listing, is_optional, is_active, category_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND question_id IN ('".$string_question_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->question_id]['question_id'] = $item_obj->question_id;
				$array_result[$item_obj->question_id]['question_name'] = $item_obj->question_name;
				$array_result[$item_obj->question_id]['question_description'] = $item_obj->question_description;
				$array_result[$item_obj->question_id]['question_type'] = $item_obj->question_type;
				$array_result[$item_obj->question_id]['have_other_answer'] = $item_obj->have_other_answer;
				$array_result[$item_obj->question_id]['order_listing'] = $item_obj->order_listing;
				$array_result[$item_obj->question_id]['is_optional'] = $item_obj->is_optional;
				$array_result[$item_obj->question_id]['is_active'] = $item_obj->is_active;
				$array_result[$item_obj->question_id]['category_id'] = $item_obj->category_id;
				$array_result[$item_obj->question_id]['date_added'] = $item_obj->date_added;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_question_by_array_category_id($array_category_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_category_id) == 0) {
			return array();
		} else {
			$string_category_id = implode("','", $array_category_id);
			$sql = "SELECT question_id, question_name, question_description, question_type, have_other_answer, order_listing, is_optional, is_active, category_id, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND category_id IN ('".$string_category_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->question_id]['question_id'] = $item_obj->question_id;
				$array_result[$item_obj->question_id]['question_name'] = $item_obj->question_name;
				$array_result[$item_obj->question_id]['question_description'] = $item_obj->question_description;
				$array_result[$item_obj->question_id]['question_type'] = $item_obj->question_type;
				$array_result[$item_obj->question_id]['have_other_answer'] = $item_obj->have_other_answer;
				$array_result[$item_obj->question_id]['order_listing'] = $item_obj->order_listing;
				$array_result[$item_obj->question_id]['is_optional'] = $item_obj->is_optional;
				$array_result[$item_obj->question_id]['is_active'] = $item_obj->is_active;
				$array_result[$item_obj->question_id]['category_id'] = $item_obj->category_id;
				$array_result[$item_obj->question_id]['date_added'] = $item_obj->date_added;
			}
			return $array_result;
		}
	}
}
?>
