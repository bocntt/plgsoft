<?php
class coreorders_db {
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

	function get_total_coreorders($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		$total_coreorders = $wpdb->get_var($sql);
		return $total_coreorders;
	}

	function get_all_coreorders($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT id, order_ip, order_date, order_time, order_data, user_id,
				order_id, order_items, order_email, order_shipping, order_tax, order_total, order_status, user_login_name, shipping_label, payment_data FROM " .$table_name.
			" WHERE 1=1" .
			" ORDER BY order_items";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->user_id, $this->array_user_id)) {
				$this->array_user_id[] = $item_obj->user_id;
			}
			if (!in_array($item_obj->order_id, $this->array_order_id)) {
				$this->array_order_id[] = $item_obj->order_id;
			}
			$results[$index]['id'] = $item_obj->id;
			$results[$index]['order_ip'] = $item_obj->order_ip;
			$results[$index]['order_date'] = $item_obj->order_date;
			$results[$index]['order_time'] = $item_obj->order_time;
			$results[$index]['order_data'] = $item_obj->order_data;
			$results[$index]['user_id'] = $item_obj->user_id;
			$results[$index]['order_id'] = $item_obj->order_id;
			$results[$index]['order_items'] = $item_obj->order_items;
			$results[$index]['order_email'] = $item_obj->order_email;
			$results[$index]['order_shipping'] = $item_obj->order_shipping;
			$results[$index]['order_tax'] = $item_obj->order_tax;
			$results[$index]['order_total'] = $item_obj->order_total;
			$results[$index]['order_status'] = $item_obj->order_status;
			$results[$index]['user_login_name'] = $item_obj->user_login_name;
			$results[$index]['shipping_label'] = $item_obj->shipping_label;
			$results[$index]['payment_data'] = $item_obj->payment_data;
			$index++;
		}
		return $results;
	}

	function get_plgsoft_coreorders_by_id($id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE 1=1 AND id='" . $id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['id'] = $item_obj->id;
				$result_obj['order_ip'] = $item_obj->order_ip;
				$result_obj['order_date'] = $item_obj->order_date;
				$result_obj['order_time'] = $item_obj->order_time;
				$result_obj['order_data'] = $item_obj->order_data;
				$result_obj['user_id'] = $item_obj->user_id;
				$result_obj['order_id'] = $item_obj->order_id;
				$result_obj['order_items'] = $item_obj->order_items;
				$result_obj['order_email'] = $item_obj->order_email;
				$result_obj['order_shipping'] = $item_obj->order_shipping;
				$result_obj['order_tax'] = $item_obj->order_tax;
				$result_obj['order_total'] = $item_obj->order_total;
				$result_obj['order_status'] = $item_obj->order_status;
				$result_obj['user_login_name'] = $item_obj->user_login_name;
				$result_obj['shipping_label'] = $item_obj->shipping_label;
				$result_obj['payment_data'] = $item_obj->payment_data;
			}
			return $result_obj;
		}
	}
}
?>