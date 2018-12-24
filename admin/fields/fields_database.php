<?php
class fields_database {
	var $table_name;

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_plgsoft_fields($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(field_key) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(field_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(field_description) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(field_placeholder) LIKE '%".$keyword."%')";
			}
			$total_fields = $wpdb->get_var($sql);
			return $total_fields;
		}
	}

	function get_list_plgsoft_fields($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT field_key, field_name, is_active, order_listing, field_description, field_placeholder, field_type, field_business_type, field_option_type, field_option_value " .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(field_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(field_description) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(field_placeholder) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY order_listing";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				$array_result[$index]['field_key'] = strtolower($item_obj->field_key);
				$array_result[$index]['field_name'] = $item_obj->field_name;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['order_listing'] = $item_obj->order_listing;
				$array_result[$index]['field_description'] = $item_obj->field_description;
				$array_result[$index]['field_placeholder'] = $item_obj->field_placeholder;
				$array_result[$index]['field_type'] = $item_obj->field_type;
				$array_result[$index]['field_business_type'] = $item_obj->field_business_type;
				$array_result[$index]['field_option_type'] = $item_obj->field_option_type;
				$array_result[$index]['field_option_value'] = $item_obj->field_option_value;
				$index++;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_fields_by_array_field_key($array_field_key=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_field_key) == 0) {
			return array();
		} else {
			$string_field_key = implode("','", $array_field_key);
			$sql = "SELECT field_key, field_name " .
				" FROM " . $table_name;
			$sql .= " WHERE field_key IN ('".$string_field_key."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->field_key] = $item_obj->field_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_fields_by_field_key($field_key) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE field_key='" . $field_key . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['field_key'] = strtolower($item_obj->field_key);
				$result_obj['field_name'] = $item_obj->field_name;
				$result_obj['order_listing'] = $item_obj->order_listing;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['field_description'] = $item_obj->field_description;
				$result_obj['field_placeholder'] = $item_obj->field_placeholder;
				$result_obj['field_type'] = $item_obj->field_type;
				$result_obj['field_business_type'] = $item_obj->field_business_type;
				$result_obj['field_option_type'] = $item_obj->field_option_type;
				$result_obj['field_option_value'] = $item_obj->field_option_value;
				$result_obj['string_category_id'] = $item_obj->string_category_id;
			}
			return $result_obj;
		}
	}

	function check_exist_field_name($field_name, $field_key="", $field_business_type="") {
		global $wpdb;
		$field_name = strtolower(trim($field_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(field_key) " .
				" FROM " . $table_name .
				" WHERE LOWER(field_name)='".esc_sql($field_name)."' AND field_key <> '".$field_key."' AND field_business_type <> '".$field_business_type."'";
			$total_fields = $wpdb->get_var($sql);
			if ($total_fields == 0)
				return false;
			else
				return true;
		}
	}

	function check_exist_field_key($field_key) {
		global $wpdb;
		$field_key = strtolower(trim($field_key));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(field_key) " .
				" FROM " . $table_name .
				" WHERE LOWER(field_key)='".esc_sql($field_key)."'";
			$total_fields = $wpdb->get_var($sql);
			if ($total_fields == 0) {
				return false;
			} else {
				return true;
			}
		}
	}

	function insert_plgsoft_fields($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$field_key           = isset($item_obj['field_key']) ? trim($item_obj['field_key']) : "";
			$order_listing       = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$field_name          = isset($item_obj['field_name']) ? trim($item_obj['field_name']) : "";
			$is_active           = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$field_type          = isset($item_obj['field_type']) ? trim($item_obj['field_type']) : "";
			$field_business_type = isset($item_obj['field_business_type']) ? trim($item_obj['field_business_type']) : "";
			$field_option_type   = isset($item_obj['field_option_type']) ? trim($item_obj['field_option_type']) : "";
			$field_option_value  = isset($item_obj['field_option_value']) ? trim($item_obj['field_option_value']) : "";
			$field_description   = isset($item_obj['field_description']) ? trim($item_obj['field_description']) : "";
			$field_placeholder   = isset($item_obj['field_placeholder']) ? trim($item_obj['field_placeholder']) : "";
			$string_category_id  = isset($item_obj['string_category_id']) ? trim($item_obj['string_category_id']) : "";
			$sql = "INSERT INTO ".$table_name."(field_key, field_name, order_listing, is_active, field_type, field_business_type, field_option_type, field_option_value, field_description, field_placeholder, string_category_id) " .
				" VALUES ('%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$field_key,
						$field_name,
						$order_listing,
						$is_active,
						$field_type,
						$field_business_type,
						$field_option_type,
						$field_option_value,
						$field_description,
						$field_placeholder,
						$string_category_id
					)
				)
			);
		}
	}

	function update_plgsoft_fields($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$field_key           = isset($item_obj['field_key']) ? trim($item_obj['field_key']) : "";
			$order_listing       = isset($item_obj['order_listing']) ? (int) trim($item_obj['order_listing']) : 0;
			$field_name          = isset($item_obj['field_name']) ? trim($item_obj['field_name']) : "";
			$is_active           = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$field_type          = isset($item_obj['field_type']) ? trim($item_obj['field_type']) : "";
			$field_business_type = isset($item_obj['field_business_type']) ? trim($item_obj['field_business_type']) : "";
			$field_option_type   = isset($item_obj['field_option_type']) ? trim($item_obj['field_option_type']) : "";
			$field_option_value  = isset($item_obj['field_option_value']) ? trim($item_obj['field_option_value']) : "";
			$field_description   = isset($item_obj['field_description']) ? trim($item_obj['field_description']) : "";
			$field_placeholder   = isset($item_obj['field_placeholder']) ? trim($item_obj['field_placeholder']) : "";
			$string_category_id  = isset($item_obj['string_category_id']) ? trim($item_obj['string_category_id']) : "";
			$sql = "UPDATE ".$table_name." SET field_name='%s', " .
				" order_listing='%d', " .
				" field_type='%s', " .
				" field_business_type='%s', " .
				" field_option_type='%s', " .
				" field_option_value='%s', " .
				" field_description='%s', " .
				" field_placeholder='%s', " .
				" string_category_id='%s', " .
				" is_active='%d' " .
			" WHERE field_key='%s'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$field_name,
						$order_listing,
						$field_type,
						$field_business_type,
						$field_option_type,
						$field_option_value,
						$field_description,
						$field_placeholder,
						$string_category_id,
						$is_active,
						$field_key
					)
				)
			);
		}
	}

	function delete_plgsoft_fields($field_key) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if ((strlen($field_key) > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE field_key='%s'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$field_key
				)
			);
		}
	}

	function active_plgsoft_fields($field_key) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE field_key='%s'";
			$wpdb->query($wpdb->prepare($sql, $field_key));
		}
	}

	function deactive_plgsoft_fields($field_key) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE field_key='%s'";
			$wpdb->query($wpdb->prepare($sql, $field_key));
		}
	}
}
?>
