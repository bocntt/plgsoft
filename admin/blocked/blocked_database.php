<?php
class blocked_database {
	var $table_name = "plgsoft_blocked";
	var $array_user_id = array();
	var $array_user_blocked_id = array();

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

	function get_array_user_blocked_id() {
		return $this->array_user_blocked_id;
	}
	function set_array_user_blocked_id($array_user_blocked_id) {
		$this->array_user_blocked_id = $array_user_blocked_id;
	}

	function get_total_plgsoft_blocked($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(blocked_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			$total_blocked = $wpdb->get_var($sql);
			return $total_blocked;
		}
	}

	function get_list_plgsoft_blocked($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT blocked_id, user_id, user_blocked_id, date_added" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			$sql .= " ORDER BY blocked_id DESC";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				if (!in_array($item_obj->user_id, $this->array_user_id)) {
					$this->array_user_id[] = $item_obj->user_id;
				}
				if (!in_array($item_obj->user_blocked_id, $this->array_user_blocked_id)) {
					$this->array_user_blocked_id[] = $item_obj->user_blocked_id;
				}
				$array_result[$index]['blocked_id'] = $item_obj->blocked_id;
				$array_result[$index]['user_id'] = $item_obj->user_id;
				$array_result[$index]['user_blocked_id'] = $item_obj->user_blocked_id;
				$array_result[$index]['date_added'] = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_blocked_by_blocked_id($blocked_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE blocked_id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $blocked_id), ARRAY_A);
			return $result_obj;
		}
	}

	function insert_plgsoft_blocked($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$user_id         = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$user_blocked_id = isset($item_obj['user_blocked_id']) ? (int) trim($item_obj['user_blocked_id']) : 0;
			$sql = "INSERT INTO ".$table_name."(user_id, user_blocked_id, date_added) " .
				" VALUES ('%d', '%d', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$user_id,
						$user_blocked_id
					)
				)
			);
		}
	}

	function update_plgsoft_blocked($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$blocked_id      = isset($item_obj['blocked_id']) ? (int) trim($item_obj['blocked_id']) : 0;
			$user_id         = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$user_blocked_id = isset($item_obj['user_blocked_id']) ? (int) trim($item_obj['user_blocked_id']) : 0;
			$sql = "UPDATE ".$table_name." SET user_id='%d', " .
				" user_blocked_id='%d' " .
			" WHERE blocked_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$user_id,
						$user_blocked_id,
						$blocked_id
					)
				)
			);
		}
	}

	function delete_plgsoft_blocked($blocked_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($blocked_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE blocked_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$blocked_id
				)
			);
		}
	}
}
?>
