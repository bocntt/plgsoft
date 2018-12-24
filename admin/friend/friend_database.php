<?php
class friend_database {
	var $table_name = "plgsoft_friend";
	var $array_user_id = array();
	var $array_user_friend_id = array();

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

	function get_array_user_friend_id() {
		return $this->array_user_friend_id;
	}
	function set_array_user_friend_id($array_user_friend_id) {
		$this->array_user_friend_id = $array_user_friend_id;
	}

	function get_total_plgsoft_friend($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(friend_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			$total_friend = $wpdb->get_var($sql);
			return $total_friend;
		}
	}

	function get_list_plgsoft_friend($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT friend_id, user_id, user_friend_id, date_added" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			$sql .= " ORDER BY friend_id DESC";
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
				if (!in_array($item_obj->user_friend_id, $this->array_user_friend_id)) {
					$this->array_user_friend_id[] = $item_obj->user_friend_id;
				}
				$array_result[$index]['friend_id'] = $item_obj->friend_id;
				$array_result[$index]['user_id'] = $item_obj->user_id;
				$array_result[$index]['user_friend_id'] = $item_obj->user_friend_id;
				$array_result[$index]['date_added'] = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_friend_by_friend_id($friend_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE friend_id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $friend_id), ARRAY_A);
			return $result_obj;
		}
	}

	function insert_plgsoft_friend($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$user_id        = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$user_friend_id = isset($item_obj['user_friend_id']) ? (int) trim($item_obj['user_friend_id']) : 0;
			$sql = "INSERT INTO ".$table_name."(user_id, user_friend_id, date_added) " .
				" VALUES ('%d', '%d', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$user_id,
						$user_friend_id
					)
				)
			);
		}
	}

	function update_plgsoft_friend($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$friend_id      = isset($item_obj['friend_id']) ? (int) trim($item_obj['friend_id']) : 0;
			$user_id        = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$user_friend_id = isset($item_obj['user_friend_id']) ? (int) trim($item_obj['user_friend_id']) : 0;
			$sql = "UPDATE ".$table_name." SET user_id='%d', " .
				" user_friend_id='%d' " .
			" WHERE friend_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$user_id,
						$user_friend_id,
						$friend_id
					)
				)
			);
		}
	}

	function delete_plgsoft_friend($friend_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($friend_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE friend_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$friend_id
				)
			);
		}
	}
}
?>
