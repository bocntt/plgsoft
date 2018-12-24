<?php
class maincategories_database {
	var $table_name = "plgsoft_main_categories";

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_plgsoft_maincategories($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(main_category_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(main_category_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$total_maincategories = $wpdb->get_var($sql);
			return $total_maincategories;
		}
	}

	function get_list_plgsoft_maincategories($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT main_category_id, main_category_name, permalink, is_active, order_listing, seo_title, seo_description " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(main_category_name) LIKE '%".$keyword."%')";
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
				$array_result[$index]['main_category_id'] = $item_obj->main_category_id;
				$array_result[$index]['main_category_name'] = $item_obj->main_category_name;
				$array_result[$index]['permalink'] = $item_obj->permalink;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['seo_title'] = $item_obj->seo_title;
				$array_result[$index]['seo_description'] = $item_obj->seo_description;
				$index++;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_maincategories_by_array_main_category_id($array_main_category_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_main_category_id) == 0) {
			return array();
		} else {
			$string_main_category_id = implode("','", $array_main_category_id);
			$sql = "SELECT main_category_id, main_category_name " .
				" FROM " . $table_name;
			$sql .= " WHERE main_category_id IN ('".$string_main_category_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->main_category_id] = $item_obj->main_category_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_maincategories_by_main_category_id($main_category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE main_category_id='" . $main_category_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['main_category_id'] = $item_obj->main_category_id;
				$result_obj['main_category_name'] = $item_obj->main_category_name;
				$result_obj['permalink'] = $item_obj->permalink;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['seo_title'] = $item_obj->seo_title;
				$result_obj['seo_description'] = $item_obj->seo_description;
			}
			return $result_obj;
		}
	}

	function check_exist_main_category_name($main_category_name, $main_category_id=0) {
		global $wpdb;
		$main_category_name = strtolower(trim($main_category_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(main_category_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(main_category_name)='".esc_sql($main_category_name)."' AND main_category_id <> '".$main_category_id."'";
			$total_maincategories = $wpdb->get_var($sql);
			if ($total_maincategories == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_permalink($permalink, $main_category_id=0) {
		global $wpdb;
		$permalink = strtolower(trim($permalink));
		$permalink = get_plgsoft_permalink($permalink);
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(main_category_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(permalink)='".esc_sql($permalink)."' AND main_category_id <> '".$main_category_id."'";
			$total_maincategories = $wpdb->get_var($sql);
			if ($total_maincategories == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_maincategories($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$main_category_name = isset($item_obj['main_category_name']) ? trim($item_obj['main_category_name']) : "";
			$order_listing      = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_active          = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$permalink          = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $main_category_name;
			$permalink = get_plgsoft_permalink($permalink);
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "INSERT INTO ".$table_name."(main_category_name, order_listing, is_active, permalink, seo_title, seo_description) " .
				" VALUES ('%s', '%d', '%d', '%s', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$main_category_name,
						$order_listing,
						$is_active,
						$permalink,
						$seo_title,
						$seo_description
					)
				)
			);
		}
	}

	function update_plgsoft_maincategories($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$main_category_id   = isset($item_obj['main_category_id']) ? (int) trim($item_obj['main_category_id']) : 0;
			$main_category_name = isset($item_obj['main_category_name']) ? trim($item_obj['main_category_name']) : "";
			$order_listing      = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$is_active          = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$permalink          = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $main_category_name;
			$permalink = get_plgsoft_permalink($permalink);
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "UPDATE ".$table_name." SET main_category_name='%s', " .
				" order_listing='%d', " .
				" permalink='%s', " .
				" seo_title='%s', " .
				" seo_description='%s', " .
				" is_active='%d' " .
			" WHERE main_category_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$main_category_name,
						$order_listing,
						$permalink,
						$seo_title,
						$seo_description,
						$is_active,
						$main_category_id
					)
				)
			);
		}
	}

	function delete_plgsoft_maincategories($main_category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($main_category_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE main_category_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $main_category_id));
		}
	}

	function active_plgsoft_maincategories($main_category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE main_category_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $main_category_id));
		}
	}

	function deactive_plgsoft_maincategories($main_category_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE main_category_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $main_category_id));
		}
	}
}
?>
