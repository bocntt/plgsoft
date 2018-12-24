<?php
class package_db {
	var $table_name = "plgsoft_package";

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_package($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(package_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1' AND is_front_page='1'";
		$total_package = $wpdb->get_var($sql);
		return $total_package;
	}

	function get_all_package($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT * FROM " .$table_name.
				" WHERE is_active='1' AND is_front_page='1'" .
				" ORDER BY package_order";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		foreach ($list_results as $item_obj) {
			$index = $item_obj->package_id;
			$results[$index]['ID'] = $item_obj->package_id;
			$results[$index]['order'] = $item_obj->package_order;
			$results[$index]['price'] = $item_obj->package_price;
			$results[$index]['name'] = $item_obj->package_name;
			$results[$index]['subtext'] = $item_obj->package_subtext;
			$results[$index]['description'] = $item_obj->package_description;
			$results[$index]['multiple_cats'] = $item_obj->package_multiple_cats;
			$results[$index]['multiple_images'] = $item_obj->package_multiple_images;
			$results[$index]['image'] = $item_obj->package_image;
			$results[$index]['expires'] = $item_obj->package_expires;
			$results[$index]['hidden'] = $item_obj->package_hidden;
			$results[$index]['multiple_cats_amount'] = $item_obj->package_multiple_cats_amount;
			$results[$index]['max_uploads'] = $item_obj->package_max_uploads;
			$results[$index]['action'] = $item_obj->package_action;
			$results[$index]['access_fields'] = $item_obj->package_access_fields;
			$results[$index]['position'] = $item_obj->package_position;
			$results[$index]['button'] = $item_obj->package_button;
			$results[$index]['is_front_page'] = $item_obj->is_front_page;
			$results[$index]['is_active'] = $item_obj->is_active;
		}
		return $results;
	}

	function get_all_plgsoft_package_by_array_package_id($array_package_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_package_id) == 0) {
			return array();
		} else {
			$string_package_id = implode("','", $array_package_id);
			$sql = "SELECT package_id, package_name " .
				" FROM " . $table_name;
			$sql .= " WHERE package_id IN ('".$string_package_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->package_id] = $item_obj->package_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_package_by_package_id($package_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * FROM " . $table_name . " WHERE is_active='1' AND is_front_page='1' AND package_id='" . $package_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['package_id'] = $item_obj->package_id;
				$result_obj['package_order'] = $item_obj->package_order;
				$result_obj['package_price'] = $item_obj->package_price;
				$result_obj['package_name'] = $item_obj->package_name;
				$result_obj['package_subtext'] = $item_obj->package_subtext;
				$result_obj['package_description'] = $item_obj->package_description;
				$result_obj['package_multiple_cats'] = $item_obj->package_multiple_cats;
				$result_obj['package_multiple_images'] = $item_obj->package_multiple_images;
				$result_obj['package_image'] = $item_obj->package_image;
				$result_obj['package_expires'] = $item_obj->package_expires;
				$result_obj['package_hidden'] = $item_obj->package_hidden;
				$result_obj['package_multiple_cats_amount'] = $item_obj->package_multiple_cats_amount;
				$result_obj['package_max_uploads'] = $item_obj->package_max_uploads;
				$result_obj['package_action'] = $item_obj->package_action;
				$result_obj['package_access_fields'] = $item_obj->package_access_fields;
				$result_obj['package_position'] = $item_obj->package_position;
				$result_obj['package_button'] = $item_obj->package_button;
				$result_obj['is_front_page'] = $item_obj->is_front_page;
				$result_obj['is_active'] = $item_obj->is_active;
			}
			return $result_obj;
		}
	}
}
?>
