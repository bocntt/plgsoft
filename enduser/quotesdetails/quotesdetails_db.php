<?php
class quotesdetails_db {
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

	function get_total_quotesdetails($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(quotesdetails_id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		$total_quotesdetails = $wpdb->get_var($sql);
		return $total_quotesdetails;
	}

	function get_all_quotesdetails($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT quotesdetails_id, quotes_id, question_id, answer_id, reply_id, message, date_added FROM " .$table_name.
			" WHERE 1=1" .
			" ORDER BY quotesdetails_id DESC";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
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
			$results[$index]['quotesdetails_id'] = $item_obj->quotesdetails_id;
			$results[$index]['quotes_id'] = $item_obj->quotes_id;
			$results[$index]['question_id'] = $item_obj->question_id;
			$results[$index]['answer_id'] = $item_obj->answer_id;
			$results[$index]['reply_id'] = $item_obj->reply_id;
			$results[$index]['message'] = $item_obj->message;
			$results[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}
		return $results;
	}

	function get_plgsoft_quotesdetails_by_quotesdetails_id($quotesdetails_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE 1=1 AND quotesdetails_id='" . $quotesdetails_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['quotesdetails_id'] = $item_obj->quotesdetails_id;
				$result_obj['quotes_id'] = $item_obj->quotes_id;
				$result_obj['question_id'] = $item_obj->question_id;
				$result_obj['answer_id'] = $item_obj->answer_id;
				$result_obj['reply_id'] = $item_obj->reply_id;
				$result_obj['message'] = $item_obj->message;
				$result_obj['date_added'] = $item_obj->date_added;
			}
			return $result_obj;
		}
	}

	function get_all_plgsoft_quotesdetails_by_array_quotes_id($array_quotes_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_quotes_id) == 0) {
			return array();
		} else {
			$string_quotes_id = implode("','", $array_quotes_id);
			$sql = "SELECT quotesdetails_id, quotes_id, question_id, answer_id, reply_id, message, date_added " .
				" FROM " . $table_name;
			$sql .= " WHERE is_active='1' AND quotes_id IN ('".$string_quotes_id."')";
			$list_results = $wpdb->get_results($sql);
			$results = array();
			foreach ($list_results as $item_obj) {
				$results[$item_obj->quotes_id][$item_obj->quotesdetails_id]['quotesdetails_id'] = $item_obj->quotesdetails_id;
				$results[$item_obj->quotes_id][$item_obj->quotesdetails_id]['quotes_id'] = $item_obj->quotes_id;
				$results[$item_obj->quotes_id][$item_obj->quotesdetails_id]['question_id'] = $item_obj->question_id;
				$results[$item_obj->quotes_id][$item_obj->quotesdetails_id]['answer_id'] = $item_obj->answer_id;
				$results[$item_obj->quotes_id][$item_obj->quotesdetails_id]['reply_id'] = $item_obj->reply_id;
				$results[$item_obj->quotes_id][$item_obj->quotesdetails_id]['message'] = $item_obj->message;
				$results[$item_obj->quotes_id][$item_obj->quotesdetails_id]['date_added'] = $item_obj->date_added;
			}
			return $results;
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
			$wpdb->query($wpdb->prepare($sql, $quotesdetails_id));
		}
	}
}
?>
