<?php
class favorite_database {
	var $table_name = "plgsoft_favorite";
	var $array_user_id = array();
	var $array_post_id = array();

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

	function get_array_post_id() {
		return $this->array_post_id;
	}
	function set_array_post_id($array_post_id) {
		$this->array_post_id = $array_post_id;
	}

	function get_total_plgsoft_favorite($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(favorite_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			$total_favorite = $wpdb->get_var($sql);
			return $total_favorite;
		}
	}

	function get_list_plgsoft_favorite($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT favorite_id, user_id, post_id, date_added" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			$sql .= " ORDER BY favorite_id DESC";
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
				if (!in_array($item_obj->post_id, $this->array_post_id)) {
					$this->array_post_id[] = $item_obj->post_id;
				}
				$array_result[$index]['favorite_id'] = $item_obj->favorite_id;
				$array_result[$index]['user_id'] = $item_obj->user_id;
				$array_result[$index]['post_id'] = $item_obj->post_id;
				$array_result[$index]['date_added'] = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_favorite_by_favorite_id($favorite_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE favorite_id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $favorite_id), ARRAY_A);
			return $result_obj;
		}
	}

	function insert_plgsoft_favorite($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$user_id = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$post_id = isset($item_obj['post_id']) ? (int) trim($item_obj['post_id']) : 0;
			$sql = "INSERT INTO ".$table_name."(user_id, post_id, date_added) " .
				" VALUES ('%d', '%d', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$user_id,
						$post_id
					)
				)
			);
		}
	}

	function update_plgsoft_favorite($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$favorite_id = isset($item_obj['favorite_id']) ? (int) trim($item_obj['favorite_id']) : 0;
			$user_id     = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$post_id     = isset($item_obj['post_id']) ? (int) trim($item_obj['post_id']) : 0;
			$sql = "UPDATE ".$table_name." SET user_id='%d', " .
				" post_id='%d' " .
			" WHERE favorite_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$user_id,
						$post_id,
						$favorite_id
					)
				)
			);
		}
	}

	function delete_plgsoft_favorite($favorite_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($favorite_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE favorite_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $favorite_id));
		}
	}
}
?>
