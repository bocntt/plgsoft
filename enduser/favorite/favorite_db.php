<?php
class favorite_db {
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

	function get_total_favorite($array_keywords=array()) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(favorite_id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$total_favorite = $wpdb->get_var($sql);
		return $total_favorite;
	}

	function get_all_favorite($array_keywords=array(), $limit=0, $offset=0) {
		$user_id = isset($array_keywords['user_id']) ? $array_keywords['user_id'] : 0;
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT favorite_id, user_id, post_id, date_added FROM " .$table_name.
			" WHERE 1=1";
		if ($user_id > 0) {
			$sql .= " AND user_id='".$user_id."'";
		}
		$sql .= " ORDER BY user_id";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->user_id, $this->array_user_id)) {
				$this->array_user_id[] = $item_obj->user_id;
			}
			if (!in_array($item_obj->post_id, $this->array_post_id)) {
				$this->array_post_id[] = $item_obj->post_id;
			}
			$results[$index]['favorite_id'] = $item_obj->favorite_id;
			$results[$index]['user_id'] = $item_obj->user_id;
			$results[$index]['post_id'] = $item_obj->post_id;
			$results[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}
		return $results;
	}

	function check_exist_favorite($user_id, $post_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT favorite_id " .
				" FROM " . $table_name .
				" WHERE user_id = '".$user_id."' AND post_id = '".$post_id."'";
			$favorite_id = $wpdb->get_var($sql);
			return $favorite_id;
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
			$wpdb->query($wpdb->prepare($sql, array($user_id, $post_id)));
		}
	}

	function delete_plgsoft_favorite($post_id, $user_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($post_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE post_id='%d' AND user_id='%d'";
			$wpdb->query($wpdb->prepare($sql, array($post_id, $user_id)));
		}
	}
}
?>
