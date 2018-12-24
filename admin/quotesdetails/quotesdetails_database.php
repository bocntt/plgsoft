<?php
class quotesdetails_database {
	var $table_name = "plgsoft_quotesdetails";
	var $array_quotes_id = array();
	var $array_question_id = array();
	var $array_answer_id = array();
	var $array_reply_id = array();

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_array_quotes_id() {
		return $this->array_quotes_id;
	}
	function set_array_quotes_id($array_quotes_id) {
		$this->array_quotes_id = $array_quotes_id;
	}

	function get_array_question_id() {
		return $this->array_question_id;
	}
	function set_array_question_id($array_question_id) {
		$this->array_question_id = $array_question_id;
	}

	function get_array_answer_id() {
		return $this->array_answer_id;
	}
	function set_array_answer_id($array_answer_id) {
		$this->array_answer_id = $array_answer_id;
	}

	function get_array_reply_id() {
		return $this->array_reply_id;
	}
	function set_array_reply_id($array_reply_id) {
		$this->array_reply_id = $array_reply_id;
	}

	function get_total_plgsoft_quotesdetails($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$quotes_id = isset($array_keywords['quotes_id']) ? $array_keywords['quotes_id'] : 0;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(quotesdetails_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($quotes_id > 0) {
				$sql .= " AND (quotes_id = '%d')";
				$total_quotesdetails = $wpdb->get_var($wpdb->prepare($sql, $quotes_id));
			} else {
				$total_quotesdetails = $wpdb->get_var($sql);
			}
			return $total_quotesdetails;
		}
	}

	function get_list_plgsoft_quotesdetails($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$quotes_id = isset($array_keywords['quotes_id']) ? $array_keywords['quotes_id'] : 0;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT quotesdetails_id, quotes_id, question_id, answer_id, reply_id, message, date_added" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($quotes_id > 0) {
				$sql .= " AND (quotes_id = '%d')";
			}
			$sql .= " ORDER BY quotesdetails_id DESC";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			if ($quotes_id > 0) {
				$list_results = $wpdb->get_results($wpdb->prepare($sql, $quotes_id));
			} else {
				$list_results = $wpdb->get_results($sql);
			}
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				if (!in_array($item_obj->quotes_id, $this->array_quotes_id)) {
					$this->array_quotes_id[] = $item_obj->quotes_id;
				}
				if (!in_array($item_obj->question_id, $this->array_question_id)) {
					$this->array_question_id[] = $item_obj->question_id;
				}
				if (!in_array($item_obj->answer_id, $this->array_answer_id)) {
					$this->array_answer_id[] = $item_obj->answer_id;
				}
				if (!in_array($item_obj->reply_id, $this->array_reply_id)) {
					$this->array_reply_id[] = $item_obj->reply_id;
				}
				$array_result[$index]['quotesdetails_id'] = $item_obj->quotesdetails_id;
				$array_result[$index]['quotes_id']        = $item_obj->quotes_id;
				$array_result[$index]['question_id']      = $item_obj->question_id;
				$array_result[$index]['answer_id']        = $item_obj->answer_id;
				$array_result[$index]['reply_id']         = $item_obj->reply_id;
				$array_result[$index]['message']          = $item_obj->message;
				$array_result[$index]['date_added']       = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_quotesdetails_by_quotesdetails_id($quotesdetails_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE quotesdetails_id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $quotesdetails_id), ARRAY_A);
			return $result_obj;
		}
	}

	function insert_plgsoft_quotesdetails($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$quotes_id   = isset($item_obj['quotes_id']) ? (int) trim($item_obj['quotes_id']) : 0;
			$question_id = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$answer_id   = isset($item_obj['answer_id']) ? (int) trim($item_obj['answer_id']) : 0;
			$reply_id    = isset($item_obj['reply_id']) ? (int) trim($item_obj['reply_id']) : 0;
			$message     = isset($item_obj['message']) ? trim($item_obj['message']) : "";
			$sql = "INSERT INTO ".$table_name."(quotes_id, question_id, answer_id, reply_id, message, date_added) " .
				" VALUES ('%d', '%d', '%d', '%d', '%s', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$quotes_id,
						$question_id,
						$answer_id,
						$reply_id,
						$message
					)
				)
			);
		}
	}

	function update_plgsoft_quotesdetails($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$quotesdetails_id = isset($item_obj['quotesdetails_id']) ? (int) trim($item_obj['quotesdetails_id']) : 0;
			$quotes_id        = isset($item_obj['quotes_id']) ? (int) trim($item_obj['quotes_id']) : 0;
			$question_id      = isset($item_obj['question_id']) ? (int) trim($item_obj['question_id']) : 0;
			$answer_id        = isset($item_obj['answer_id']) ? (int) trim($item_obj['answer_id']) : 0;
			$reply_id         = isset($item_obj['reply_id']) ? (int) trim($item_obj['reply_id']) : 0;
			$message          = isset($item_obj['message']) ? trim($item_obj['message']) : "";

			$sql = "UPDATE ".$table_name." SET quotes_id='%d', " .
				" question_id='%d', " .
				" answer_id='%d', " .
				" reply_id='%d', " .
				" message='%s' " .
			" WHERE quotesdetails_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$quotes_id,
						$question_id,
						$answer_id,
						$reply_id,
						$message,
						$quotesdetails_id
					)
				)
			);
		}
	}

	function delete_plgsoft_quotesdetails($quotesdetails_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($quotesdetails_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE quotesdetails_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$quotesdetails_id
				)
			);
		}
	}

	function delete_plgsoft_quotesdetails_by_quotes_id($quotes_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($quotes_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE quotes_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$quotes_id
				)
			);
		}
	}
}
?>
