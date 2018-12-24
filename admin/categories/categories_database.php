<?php
class categories_database {
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

	function get_total_plgsoft_categories($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(category_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(category_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$total_categories = $wpdb->get_var($sql);
			return $total_categories;
		}
	}

	function get_list_plgsoft_categories($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT category_id, category_name, is_active, order_listing, main_category_id, seo_title, seo_description " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(category_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY order_listing";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				if (!in_array($item_obj->main_category_id, $this->array_main_category_id)) {
					$this->array_main_category_id[] = $item_obj->main_category_id;
				}
				$array_result[$index]['category_id'] = $item_obj->category_id;
				$array_result[$index]['category_name'] = $item_obj->category_name;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['main_category_id'] = $item_obj->main_category_id;
				$array_result[$index]['seo_title'] = $item_obj->seo_title;
				$array_result[$index]['seo_description'] = $item_obj->seo_description;
				$index++;
			}
			return $array_result;
		}
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

	function get_plgsoft_categories_by_category_id($category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE category_id='" . $category_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['category_id'] = $item_obj->category_id;
				$result_obj['category_name'] = $item_obj->category_name;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['permalink'] = $item_obj->permalink;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['main_category_id'] = $item_obj->main_category_id;
				$result_obj['seo_title'] = $item_obj->seo_title;
				$result_obj['seo_description'] = $item_obj->seo_description;
			}
			return $result_obj;
		}
	}

	function check_exist_category_name($category_name, $category_id=0) {
		global $wpdb;
		$category_name = strtolower(trim($category_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(category_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(category_name)='".esc_sql($category_name)."' AND category_id <> '".$category_id."'";
			$total_categories = $wpdb->get_var($sql);
			if ($total_categories == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_permalink($permalink, $category_id=0) {
		global $wpdb;
		$permalink = strtolower(trim($permalink));
		$permalink = get_plgsoft_permalink($permalink);
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(category_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(permalink)='".esc_sql($permalink)."' AND category_id <> '".$category_id."'";
			$total_categories = $wpdb->get_var($sql);
			if ($total_categories == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_categories($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$category_name    = isset($item_obj['category_name']) ? trim($item_obj['category_name']) : "";
			$order_listing    = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_active        = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$main_category_id = isset($item_obj['main_category_id']) ? (int) trim($item_obj['main_category_id']) : 0;
			$permalink        = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $category_name;
			$permalink = get_plgsoft_permalink($permalink);
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "INSERT INTO ".$table_name."(category_name, order_listing, is_active, main_category_id, permalink, seo_title, seo_description) " .
				" VALUES ('%s', '%d', '%d', '%d', '%s', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$category_name,
						$order_listing,
						$is_active,
						$main_category_id,
						$permalink,
						$seo_title,
						$seo_description
					)
				)
			);
		}
	}

	function update_plgsoft_categories($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$category_id      = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$category_name    = isset($item_obj['category_name']) ? trim($item_obj['category_name']) : "";
			$order_listing    = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_active        = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$main_category_id = isset($item_obj['main_category_id']) ? (int) trim($item_obj['main_category_id']) : 0;
			$permalink        = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $category_name;
			$permalink = get_plgsoft_permalink($permalink);
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "UPDATE ".$table_name." SET category_name='%s', " .
				" order_listing='%d', " .
				" main_category_id='%d', " .
				" permalink='%s', " .
				" seo_title='%s', " .
				" seo_description='%s', " .
				" is_active='%d' " .
			" WHERE category_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$category_name,
						$order_listing,
						$main_category_id,
						$permalink,
						$seo_title,
						$seo_description,
						$is_active,
						$category_id
					)
				)
			);
		}
	}

	function delete_plgsoft_categories($category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($category_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE category_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $category_id));
		}
	}

	function active_plgsoft_categories($category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE category_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $category_id));
		}
	}

	function deactive_plgsoft_categories($category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE category_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $category_id));
		}
	}

	function get_total_plgsoft_categories_by_main_category_id($main_category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(category_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($main_category_id > 0) {
				$sql .= " AND main_category_id = '".$main_category_id."'";
			}
			$total_categories = $wpdb->get_var($sql);
			return $total_categories;
		}
	}

	function get_all_plgsoft_categories_by_main_category_id($main_category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT * FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($main_category_id > 0) {
				$sql .= " AND main_category_id = '".$main_category_id."'";
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				$array_result[$index]['category_id'] = $item_obj->category_id;
				$array_result[$index]['category_name'] = $item_obj->category_name;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['main_category_id'] = $item_obj->main_category_id;
				$array_result[$index]['seo_title'] = $item_obj->seo_title;
				$array_result[$index]['seo_description'] = $item_obj->seo_description;
				if (!in_array($item_obj->main_category_id, $this->array_main_category_id)) {
					$this->array_main_category_id[] = $item_obj->main_category_id;
				}
				$index++;
			}
			return $array_result;
		}
	}
}
?>
