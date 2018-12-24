<?php
class coupon_database {
	var $table_name = "plgsoft_coupon";

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_plgsoft_coupon($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(coupon_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(coupon_name) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(coupon_code) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(coupon_type) LIKE '%%%s%%')";
				$total_coupon = $wpdb->get_var(
					$wpdb->prepare(
						$sql,
						array(
							$keyword,
							$keyword,
							$keyword
						)
					)
				);
			} else {
				$total_coupon = $wpdb->get_var($sql);
			}
			return $total_coupon;
		}
	}

	function get_list_plgsoft_coupon($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT coupon_id, coupon_name, coupon_code, coupon_type, coupon_discount,
				coupon_total, uses_total, uses_customer, is_active, date_added" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(coupon_name) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(coupon_code) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(coupon_type) LIKE '%%%s%%')";
			}
			$sql .= " ORDER BY coupon_id DESC";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			if (strlen($keyword) > 0) {
				$list_results = $wpdb->get_results(
					$wpdb->prepare(
						$sql,
						array(
							$keyword,
							$keyword,
							$keyword
						)
					)
				);
			} else {
				$list_results = $wpdb->get_results($sql);
			}
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				$array_result[$index]['coupon_id'] = $item_obj->coupon_id;
				$array_result[$index]['coupon_name'] = $item_obj->coupon_name;
				$array_result[$index]['coupon_code'] = $item_obj->coupon_code;
				$array_result[$index]['coupon_type'] = $item_obj->coupon_type;
				$array_result[$index]['coupon_discount'] = $item_obj->coupon_discount;
				$array_result[$index]['coupon_total'] = $item_obj->coupon_total;
				$array_result[$index]['uses_total'] = $item_obj->uses_total;
				$array_result[$index]['uses_customer'] = $item_obj->uses_customer;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['date_added'] = $item_obj->date_added;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_coupon_by_coupon_id($coupon_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE coupon_id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $coupon_id), ARRAY_A);
			return $result_obj;
		}
	}

	function check_exist_coupon_name($coupon_name, $coupon_id=0) {
		global $wpdb;
		$coupon_name = strtolower(trim($coupon_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(coupon_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(coupon_name)='%s' AND coupon_id <> '%d'";
			$total_coupon = $wpdb->get_var($wpdb->prepare($sql, array($coupon_name, $coupon_id)));
			if ($total_coupon == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_coupon_code($coupon_code, $coupon_id=0) {
		global $wpdb;
		$coupon_code = strtolower(trim($coupon_code));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(coupon_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(coupon_code)='%s' AND coupon_id <> '%d'";
			$total_coupon = $wpdb->get_var($wpdb->prepare($sql, array($coupon_code, $coupon_id)));
			if ($total_coupon == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_coupon($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$coupon_name     = isset($item_obj['coupon_name']) ? trim($item_obj['coupon_name']) : "";
			$coupon_code     = isset($item_obj['coupon_code']) ? trim($item_obj['coupon_code']) : "";
			$coupon_type     = isset($item_obj['coupon_type']) ? trim($item_obj['coupon_type']) : "";
			$coupon_discount = isset($item_obj['coupon_discount']) ? (double) trim($item_obj['coupon_discount']) : "";
			$coupon_total    = isset($item_obj['coupon_total']) ? (double) trim($item_obj['coupon_total']) : "";
			$uses_total      = isset($item_obj['uses_total']) ? (int) trim($item_obj['uses_total']) : "";
			$uses_customer   = isset($item_obj['uses_customer']) ? trim($item_obj['uses_customer']) : "";
			$is_active       = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$sql = "INSERT INTO ".$table_name."(coupon_name, coupon_code, coupon_type, coupon_discount, coupon_total, uses_total, uses_customer, is_active, date_added) " .
				" VALUES ('%s', '%s', '%s', '%f', '%f', '%d', '%s', '%d', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$coupon_name,
						$coupon_code,
						$coupon_type,
						$coupon_discount,
						$coupon_total,
						$uses_total,
						$uses_customer,
						$is_active
					)
				)
			);
		}
	}

	function update_plgsoft_coupon($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$coupon_id       = isset($item_obj['coupon_id']) ? (int) trim($item_obj['coupon_id']) : 0;
			$coupon_name     = isset($item_obj['coupon_name']) ? trim($item_obj['coupon_name']) : "";
			$coupon_code     = isset($item_obj['coupon_code']) ? trim($item_obj['coupon_code']) : "";
			$coupon_type     = isset($item_obj['coupon_type']) ? trim($item_obj['coupon_type']) : "";
			$coupon_discount = isset($item_obj['coupon_discount']) ? (double) trim($item_obj['coupon_discount']) : "";
			$coupon_total    = isset($item_obj['coupon_total']) ? (double) trim($item_obj['coupon_total']) : "";
			$uses_total      = isset($item_obj['uses_total']) ? (int) trim($item_obj['uses_total']) : "";
			$uses_customer   = isset($item_obj['uses_customer']) ? trim($item_obj['uses_customer']) : "";
			$is_active       = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;

			$sql = "UPDATE ".$table_name." SET coupon_name='%s', " .
				" coupon_code='%s', " .
				" coupon_type='%s', " .
				" coupon_discount='%f', " .
				" coupon_total='%f', " .
				" uses_total='%d', " .
				" uses_customer='%s', " .
				" is_active='%d' " .
			" WHERE coupon_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$coupon_name,
						$coupon_code,
						$coupon_type,
						$coupon_discount,
						$coupon_total,
						$uses_total,
						$uses_customer,
						$is_active,
						$coupon_id
					)
				)
			);
		}
	}

	function delete_plgsoft_coupon($coupon_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($coupon_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE coupon_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$coupon_id
				)
			);
		}
	}

	function active_plgsoft_coupon($coupon_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE coupon_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$coupon_id
				)
			);
		}
	}

	function deactive_plgsoft_coupon($coupon_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE coupon_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$coupon_id
				)
			);
		}
	}
}
?>
