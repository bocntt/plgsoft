<?php
class categories_db {
	var $table_name = "plgsoft_categories";
	var $array_main_category_id = array();

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_array_main_category_id() {
		return $this->array_main_category_id;
	}
	function set_array_main_category_id($array_main_category_id) {
		$this->array_main_category_id = $array_main_category_id;
	}

	function get_total_categories($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(category_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1'";
		$total_category = $wpdb->get_var($sql);
		return $total_category;
	}

	function get_all_categories($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT category_id, category_name, order_listing, is_active, seo_title, seo_description FROM " .$table_name.
				" WHERE is_active='1'" .
				" ORDER BY order_listing";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->main_category_id, $this->array_main_category_id)) {
				$this->array_main_category_id[] = $item_obj->main_category_id;
			}
			$results[$index]['category_id'] = $item_obj->category_id;
			$results[$index]['category_name'] = $item_obj->category_name;
			$results[$index]['order_listing'] = $item_obj->order_listing;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['seo_title'] = $item_obj->seo_title;
			$results[$index]['seo_description'] = $item_obj->seo_description;
			$index++;
		}
		return $results;
	}

	function get_all_plgsoft_categories_by_array_category_id($array_category_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_category_id) == 0) {
			return array();
		} else {
			$string_category_id = implode("','", $array_category_id);
			$sql = "SELECT category_id, category_name " .
				" FROM " . $table_name;
			$sql .= " WHERE category_id IN ('".$string_category_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->category_id] = $item_obj->category_name;
			}
			return $array_result;
		}
	}
}
?>
