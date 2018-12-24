<?php
class quotesmeta_database {
	var $table_name = "quotes_meta";
	var $array_from_user = array();
	var $array_to_user = array();

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_array_from_user() {
		return $this->array_from_user;
	}
	function set_array_from_user($array_from_user) {
		$this->array_from_user = $array_from_user;
	}

	function get_array_to_user() {
		return $this->array_to_user;
	}
	function set_array_to_user($array_to_user) {
		$this->array_to_user = $array_to_user;
	}

	function get_total_plgsoft_quotesmeta($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(estimate) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(content) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(attachment) LIKE '%%%s%%')";
				$total_quotesmeta = $wpdb->get_var($wpdb->prepare($sql, array($keyword, $keyword, $keyword)));
			} else {
				$total_quotesmeta = $wpdb->get_var($sql);
			}
			return $total_quotesmeta;
		}
	}

	function get_list_plgsoft_quotesmeta($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT id, estimate, content, attachment, quotes_id, from_user,
				to_user, status, time" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(estimate) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(content) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(attachment) LIKE '%%%s%%')";
			}
			$sql .= " ORDER BY id DESC";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			if (strlen($keyword) > 0) {
				$list_results = $wpdb->get_results($wpdb->prepare($sql, array($keyword, $keyword, $keyword)));
			} else {
				$list_results = $wpdb->get_results($sql);
			}
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				if (!in_array($item_obj->from_user, $this->array_from_user)) {
					$this->array_from_user[] = $item_obj->from_user;
				}
				if (!in_array($item_obj->to_user, $this->array_to_user)) {
					$this->array_to_user[] = $item_obj->to_user;
				}
				$array_result[$index]['id'] = $item_obj->id;
				$array_result[$index]['estimate'] = $item_obj->estimate;
				$array_result[$index]['content'] = $item_obj->content;
				$array_result[$index]['attachment'] = $item_obj->attachment;
				$array_result[$index]['quotes_id'] = $item_obj->quotes_id;
				$array_result[$index]['from_user'] = $item_obj->from_user;
				$array_result[$index]['to_user'] = $item_obj->to_user;
				$array_result[$index]['status'] = $item_obj->status;
				$array_result[$index]['time'] = $item_obj->time;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_quotesmeta_by_id($id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $id), ARRAY_A);
			return $result_obj;
		}
	}

	function insert_plgsoft_quotesmeta($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$estimate   = isset($item_obj['estimate']) ? (int) trim($item_obj['estimate']) : 0;
			$content    = isset($item_obj['content']) ? trim($item_obj['content']) : "";
			$attachment = isset($item_obj['attachment']) ? trim($item_obj['attachment']) : "";
			$quotes_id  = isset($item_obj['quotes_id']) ? (int) trim($item_obj['quotes_id']) : 0;
			$from_user  = isset($item_obj['from_user']) ? (int) trim($item_obj['from_user']) : 0;
			$to_user    = isset($item_obj['to_user']) ? (int) trim($item_obj['to_user']) : 0;
			$status     = isset($item_obj['status']) ? trim($item_obj['status']) : "";
			$time       = isset($item_obj['time']) ? trim($item_obj['time']) : "";
			$sql = "INSERT INTO ".$table_name."(estimate, content, attachment, quotes_id, from_user, to_user, status, time) " .
				" VALUES ('%d', '%s', '%s', '%d', '%d', '%d', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$estimate,
						$content,
						$attachment,
						$quotes_id,
						$from_user,
						$to_user,
						$status,
						$time
					)
				)
			);
		}
	}

	function update_plgsoft_quotesmeta($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$id         = isset($item_obj['id']) ? (int) trim($item_obj['id']) : 0;
			$estimate   = isset($item_obj['estimate']) ? (int) trim($item_obj['estimate']) : 0;
			$content    = isset($item_obj['content']) ? trim($item_obj['content']) : "";
			$attachment = isset($item_obj['attachment']) ? trim($item_obj['attachment']) : "";
			$quotes_id  = isset($item_obj['quotes_id']) ? (int) trim($item_obj['quotes_id']) : 0;
			$from_user  = isset($item_obj['from_user']) ? (int) trim($item_obj['from_user']) : 0;
			$to_user    = isset($item_obj['to_user']) ? (int) trim($item_obj['to_user']) : 0;
			$status     = isset($item_obj['status']) ? trim($item_obj['status']) : "";
			$time       = isset($item_obj['time']) ? trim($item_obj['time']) : "";

			$sql = "UPDATE ".$table_name." SET estimate='%d', " .
				" content='%s', " .
				" attachment='%s', " .
				" quotes_id='%d', " .
				" from_user='%d', " .
				" to_user='%d', " .
				" status='%s', " .
				" time='%s' " .
			" WHERE id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$estimate,
						$content,
						$attachment,
						$quotes_id,
						$from_user,
						$to_user,
						$status,
						$time,
						$id
					)
				)
			);
		}
	}

	function delete_plgsoft_quotesmeta($id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE id='%d'";
			$wpdb->query($wpdb->prepare($sql, $id));
		}
	}
}
?>
