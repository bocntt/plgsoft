<?php
class coupon_db {
	var $table_name = "plgsoft_coupon";
	
	function get_table_name() {
		return $this->table_name; 
	}	
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}
	
	function get_total_coupon($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;		
		$sql = "SELECT COUNT(coupon_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		$total_coupon = $wpdb->get_var($sql);
		return $total_coupon;
	}
	
	function get_all_coupon($array_keywords=array()) {
		global $wpdb;
		$results = array();		
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT coupon_id, coupon_name, coupon_code, coupon_type, coupon_discount, 
				coupon_total, uses_total, uses_customer, is_active, date_added FROM " .$table_name. 
			" WHERE is_active='1'" .
			" ORDER BY uses_total";
		$list_results = $wpdb->get_results($sql);			
		$index = 0;
		foreach ($list_results as $item_obj) {		
			$results[$index]['coupon_id'] = $item_obj->coupon_id;
			$results[$index]['coupon_name'] = $item_obj->coupon_name;
			$results[$index]['coupon_code'] = $item_obj->coupon_code;
			$results[$index]['coupon_type'] = $item_obj->coupon_type;
			$results[$index]['coupon_discount'] = $item_obj->coupon_discount;
			$results[$index]['coupon_total'] = $item_obj->coupon_total;				
			$results[$index]['uses_total'] = $item_obj->uses_total;
			$results[$index]['uses_customer'] = $item_obj->uses_customer;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['date_added'] = $item_obj->date_added;
			$index++;
		}			
		return $results;
	}
	
	function get_plgsoft_coupon_by_coupon_id($coupon_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE is_active='1' AND coupon_id='" . $coupon_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['coupon_id'] = $item_obj->coupon_id;
				$result_obj['coupon_name'] = $item_obj->coupon_name;
				$result_obj['coupon_code'] = $item_obj->coupon_code;
				$result_obj['coupon_type'] = $item_obj->coupon_type;
				$result_obj['coupon_discount'] = $item_obj->coupon_discount;
				$result_obj['coupon_total'] = $item_obj->coupon_total;				
				$result_obj['uses_total'] = $item_obj->uses_total;
				$result_obj['uses_customer'] = $item_obj->uses_customer;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['date_added'] = $item_obj->date_added;
			}
			return $result_obj;
		}			
	}
	
	function get_plgsoft_coupon_by_coupon_code($coupon_code) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE is_active='1' AND coupon_code='" . $coupon_code . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['coupon_id'] = $item_obj->coupon_id;
				$result_obj['coupon_name'] = $item_obj->coupon_name;
				$result_obj['coupon_code'] = $item_obj->coupon_code;
				$result_obj['coupon_type'] = $item_obj->coupon_type;
				$result_obj['coupon_discount'] = $item_obj->coupon_discount;
				$result_obj['coupon_total'] = $item_obj->coupon_total;				
				$result_obj['uses_total'] = $item_obj->uses_total;
				$result_obj['uses_customer'] = $item_obj->uses_customer;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['date_added'] = $item_obj->date_added;
			}
			return $result_obj;
		}			
	}
}
?>