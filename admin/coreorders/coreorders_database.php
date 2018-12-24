<?php
class coreorders_database {
	var $table_name = "core_orders";
	var $array_user_id = array();
	var $array_order_id = array();

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

	function get_array_order_id() {
		return $this->array_order_id;
	}
	function set_array_order_id($array_order_id) {
		$this->array_order_id = $array_order_id;
	}

	function get_total_plgsoft_coreorders($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(autoid) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(order_ip) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(order_date) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(order_time) LIKE '%%%s%%')";
				$total_coreorders = $wpdb->get_var($wpdb->prepare($sql, array($keyword, $keyword, $keyword)));
			} else {
				$total_coreorders = $wpdb->get_var($sql);
			}
			return $total_coreorders;
		}
	}

	function get_list_plgsoft_coreorders($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT autoid, order_ip, order_date, order_time, order_data, user_id,
				order_id, order_items, order_email, order_shipping, order_tax, order_total, order_status, user_login_name, shipping_label, payment_data" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(order_ip) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(order_date) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(order_time) LIKE '%%%s%%')";
			}
			$sql .= " ORDER BY autoid DESC";
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
				if (!in_array($item_obj->user_id, $this->array_user_id)) {
					$this->array_user_id[] = $item_obj->user_id;
				}
				if (!in_array($item_obj->order_id, $this->array_order_id)) {
					$this->array_order_id[] = $item_obj->order_id;
				}
				$array_result[$index]['autoid']          = $item_obj->autoid;
				$array_result[$index]['order_ip']        = $item_obj->order_ip;
				$array_result[$index]['order_date']      = $item_obj->order_date;
				$array_result[$index]['order_time']      = $item_obj->order_time;
				$array_result[$index]['order_data']      = $item_obj->order_data;
				$array_result[$index]['user_id']         = $item_obj->user_id;
				$array_result[$index]['order_id']        = $item_obj->order_id;
				$array_result[$index]['order_items']     = $item_obj->order_items;
				$array_result[$index]['order_email']     = $item_obj->order_email;
				$array_result[$index]['order_shipping']  = $item_obj->order_shipping;
				$array_result[$index]['order_tax']       = $item_obj->order_tax;
				$array_result[$index]['order_total']     = $item_obj->order_total;
				$array_result[$index]['order_status']    = $item_obj->order_status;
				$array_result[$index]['user_login_name'] = $item_obj->user_login_name;
				$array_result[$index]['shipping_label']  = $item_obj->shipping_label;
				$array_result[$index]['payment_data']    = $item_obj->payment_data;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_coreorders_by_id($autoid) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE autoid='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $autoid), ARRAY_A);
			return $result_obj;
		}
	}

	function insert_plgsoft_coreorders($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$order_ip        = isset($item_obj['order_ip']) ? trim($item_obj['order_ip']) : "";
			$order_date      = isset($item_obj['order_date']) ? trim($item_obj['order_date']) : "";
			$order_time      = isset($item_obj['order_time']) ? trim($item_obj['order_time']) : "";
			$order_data      = isset($item_obj['order_data']) ? trim($item_obj['order_data']) : "";
			$user_id         = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$order_id        = isset($item_obj['order_id']) ? (int) trim($item_obj['order_id']) : 0;
			$order_items     = isset($item_obj['order_items']) ? trim($item_obj['order_items']) : "";
			$order_email     = isset($item_obj['order_email']) ? trim($item_obj['order_email']) : "";
			$order_shipping  = isset($item_obj['order_shipping']) ? trim($item_obj['order_shipping']) : "";
			$order_tax       = isset($item_obj['order_tax']) ? trim($item_obj['order_tax']) : "";
			$order_total     = isset($item_obj['order_total']) ? trim($item_obj['order_total']) : "";
			$order_status    = isset($item_obj['order_status']) ? trim($item_obj['order_status']) : "";
			$user_login_name = isset($item_obj['user_login_name']) ? trim($item_obj['user_login_name']) : "";
			$shipping_label  = isset($item_obj['shipping_label']) ? trim($item_obj['shipping_label']) : "";
			$payment_data    = isset($item_obj['payment_data']) ? trim($item_obj['payment_data']) : "";
			$sql = "INSERT INTO ".$table_name."(order_ip, order_date, order_time, order_data, user_id, order_id, order_items, order_email, order_shipping, order_tax, order_total, order_status, user_login_name, shipping_label, payment_data) " .
				" VALUES ('%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$order_ip,
						$order_date,
						$order_time,
						$order_data,
						$user_id,
						$order_id,
						$order_items,
						$order_email,
						$order_shipping,
						$order_tax,
						$order_total,
						$order_status,
						$user_login_name,
						$shipping_label,
						$payment_data
					)
				)
			);
		}
	}

	function update_plgsoft_coreorders($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$autoid          = isset($item_obj['autoid']) ? (int) trim($item_obj['autoid']) : 0;
			$order_ip        = isset($item_obj['order_ip']) ? trim($item_obj['order_ip']) : "";
			$order_date      = isset($item_obj['order_date']) ? trim($item_obj['order_date']) : "";
			$order_time      = isset($item_obj['order_time']) ? trim($item_obj['order_time']) : "";
			$order_data      = isset($item_obj['order_data']) ? trim($item_obj['order_data']) : "";
			$user_id         = isset($item_obj['user_id']) ? (int) trim($item_obj['user_id']) : 0;
			$order_id        = isset($item_obj['order_id']) ? (int) trim($item_obj['order_id']) : 0;
			$order_items     = isset($item_obj['order_items']) ? trim($item_obj['order_items']) : "";
			$order_email     = isset($item_obj['order_email']) ? trim($item_obj['order_email']) : "";
			$order_shipping  = isset($item_obj['order_shipping']) ? trim($item_obj['order_shipping']) : "";
			$order_tax       = isset($item_obj['order_tax']) ? trim($item_obj['order_tax']) : "";
			$order_total     = isset($item_obj['order_total']) ? trim($item_obj['order_total']) : "";
			$order_status    = isset($item_obj['order_status']) ? trim($item_obj['order_status']) : "";
			$user_login_name = isset($item_obj['user_login_name']) ? trim($item_obj['user_login_name']) : "";
			$shipping_label  = isset($item_obj['shipping_label']) ? trim($item_obj['shipping_label']) : "";
			$payment_data    = isset($item_obj['payment_data']) ? trim($item_obj['payment_data']) : "";

			$sql = "UPDATE ".$table_name." SET order_ip='%s', " .
				" order_date='%s', " .
				" order_time='%s', " .
				" order_data='%s', " .
				" user_id='%d', " .
				" order_id='%d', " .
				" order_items='%s', " .
				" order_email='%s', " .
				" order_shipping='%s', " .
				" order_tax='%s', " .
				" order_total='%s', " .
				" order_status='%s', " .
				" user_login_name='%s', " .
				" shipping_label='%s', " .
				" payment_data='%s' " .
			" WHERE autoid='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$order_ip,
						$order_date,
						$order_time,
						$order_data,
						$user_id,
						$order_id,
						$order_items,
						$order_email,
						$order_shipping,
						$order_tax,
						$order_total,
						$order_status,
						$user_login_name,
						$shipping_label,
						$payment_data,
						$autoid
					)
				)
			);
		}
	}

	function delete_plgsoft_coreorders($autoid) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($autoid > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE autoid='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$autoid
				)
			);
		}
	}
}
?>
