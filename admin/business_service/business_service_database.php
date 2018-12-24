<?php
class business_service_database {
	var $table_name = "plgsoft_business_service";
	var $array_business_service_id = array();

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_array_business_service_id() {
		return $this->array_business_service_id;
	}
	function set_array_business_service_id($array_business_service_id) {
		$this->array_business_service_id = $array_business_service_id;
	}

	function get_total_plgsoft_business_service($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(business_service_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(business_service_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$total_business_service = $wpdb->get_var($sql);
			return $total_business_service;
		}
	}

	function get_list_plgsoft_business_service($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT * FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(business_service_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_title) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(seo_description) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY business_service_id DESC";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				foreach ($item_obj as $key => $value) {
					$array_result[$index][$key] = $value;
				}
				if (!in_array($item_obj->business_service_id, $this->array_business_service_id)) {
					$this->array_business_service_id[] = $item_obj->business_service_id;
				}
				$index++;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_business_service_by_array_business_service_id($array_business_service_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_business_service_id) == 0) {
			return array();
		} else {
			$string_business_service_id = implode("','", $array_business_service_id);
			$sql = "SELECT business_service_id, business_service_name " .
				" FROM " . $table_name;
			$sql .= " WHERE business_service_id IN ('".$string_business_service_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->business_service_id] = $item_obj->business_service_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_business_service_by_business_service_id($business_service_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE business_service_id='" . $business_service_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				foreach ($item_obj as $key => $value) {
					$result_obj[$key] = $value;
				}
			}
			return $result_obj;
		}
	}

	function check_exist_business_service_name($business_service_name, $business_service_id=0) {
		global $wpdb;
		$business_service_name = strtolower(trim($business_service_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(business_service_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(business_service_name)='".esc_sql($business_service_name)."' AND business_service_id <> '".$business_service_id."'";
			$total_business_service = $wpdb->get_var($sql);
			if ($total_business_service == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_permalink($permalink, $business_service_id=0) {
		global $wpdb;
		$permalink = strtolower(trim($permalink));
		$permalink = get_plgsoft_permalink($permalink);
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(business_service_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(permalink)='".esc_sql($permalink)."' AND business_service_id <> '".$business_service_id."'";
			$total_business_service = $wpdb->get_var($sql);
			if ($total_business_service == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_business_service($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$business_service_name = isset($item_obj['business_service_name']) ? trim($item_obj['business_service_name']) : "";
			$description           = isset($item_obj['description']) ? trim($item_obj['description']) : "";
			$keywords              = isset($item_obj['keywords']) ? trim($item_obj['keywords']) : "";
			$is_active             = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : "";
			$permalink             = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $business_service_name;
			$permalink       = get_plgsoft_permalink($permalink);
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "INSERT INTO ".$table_name."(business_service_name, description, keywords, permalink, is_active, seo_title, seo_description) " .
				" VALUES ('%s', '%s', '%s', '%s', '%d', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$business_service_name,
						$description,
						$keywords,
						$permalink,
						$is_active,
						$seo_title,
						$seo_description
					)
				)
			);
		}
	}

	function update_plgsoft_business_service($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$business_service_id   = isset($item_obj['business_service_id']) ? (int) trim($item_obj['business_service_id']) : 0;
			$business_service_name = isset($item_obj['business_service_name']) ? trim($item_obj['business_service_name']) : "";
			$description           = isset($item_obj['description']) ? trim($item_obj['description']) : "";
			$keywords              = isset($item_obj['keywords']) ? trim($item_obj['keywords']) : "";
			$is_active             = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : "";
			$permalink             = isset($item_obj['permalink']) ? trim($item_obj['permalink']) : "";
			if (strlen($permalink) == 0) $permalink = $business_service_name;
			$permalink = get_plgsoft_permalink($permalink);
			$seo_title       = isset($item_obj['seo_title']) ? trim($item_obj['seo_title']) : "";
			$seo_description = isset($item_obj['seo_description']) ? trim($item_obj['seo_description']) : "";
			$sql = "UPDATE ".$table_name." SET business_service_name='%s', " .
				" description='%s', " .
				" keywords='%s', " .
				" permalink='%s', " .
				" seo_title='%s', " .
				" seo_description='%s', " .
				" is_active='%d' " .
			" WHERE business_service_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$business_service_name,
						$description,
						$keywords,
						$permalink,
						$seo_title,
						$seo_description,
						$is_active,
						$business_service_id
					)
				)
			);
		}
	}

	function delete_plgsoft_business_service($business_service_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($business_service_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE business_service_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$business_service_id
				)
			);
		}
	}

	function active_plgsoft_business_service($business_service_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE business_service_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $business_service_id));
		}
	}

	function deactive_plgsoft_business_service($business_service_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE business_service_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $business_service_id));
		}
	}

	function get_total_plgsoft_business_service_by_business_service_id($business_service_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(business_service_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($business_service_id > 0) {
				$sql .= " AND business_service_id = '".$business_service_id."'";
			}
			$total_business_service = $wpdb->get_var($sql);
			return $total_business_service;
		}
	}

	function get_all_plgsoft_business_service_by_business_service_id($business_service_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT * FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if ($business_service_id > 0) {
				$sql .= " AND business_service_id = '".$business_service_id."'";
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				foreach ($item_obj as $key => $value) {
					$array_result[$index][$key] = $value;
				}
				$index++;
			}
			return $array_result;
		}
	}
}
?>
