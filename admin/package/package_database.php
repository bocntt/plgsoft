<?php
class package_database {
	var $table_name;

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_plgsoft_package($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(package_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(package_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(package_subtext) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(package_description) LIKE '%".$keyword."%')";
			}
			$total_package = $wpdb->get_var($sql);
			return $total_package;
		}
	}

	function get_list_plgsoft_package($array_keywords=array(), $limit=0, $offset=0) {
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
				$sql .= " AND (LOWER(package_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(package_subtext) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(package_description) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY package_order";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				$array_result[$index]['package_id'] = $item_obj->package_id;
				$array_result[$index]['package_order'] = $item_obj->package_order;
				$array_result[$index]['package_price'] = $item_obj->package_price;
				$array_result[$index]['package_name'] = $item_obj->package_name;
				$array_result[$index]['package_subtext'] = $item_obj->package_subtext;
				$array_result[$index]['package_description'] = $item_obj->package_description;
				$array_result[$index]['package_multiple_cats'] = $item_obj->package_multiple_cats;
				$array_result[$index]['package_multiple_images'] = $item_obj->package_multiple_images;
				$array_result[$index]['package_image'] = $item_obj->package_image;
				$array_result[$index]['package_expires'] = $item_obj->package_expires;
				$array_result[$index]['package_hidden'] = $item_obj->package_hidden;
				$array_result[$index]['package_multiple_cats_amount'] = $item_obj->package_multiple_cats_amount;
				$array_result[$index]['package_max_uploads'] = $item_obj->package_max_uploads;
				$array_result[$index]['package_action'] = $item_obj->package_action;
				$array_result[$index]['package_access_fields'] = $item_obj->package_access_fields;
				$array_result[$index]['package_position'] = $item_obj->package_position;
				$array_result[$index]['package_button'] = $item_obj->package_button;
				$array_result[$index]['is_front_page'] = $item_obj->is_front_page;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$index++;
			}
			return $array_result;
		}
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
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE package_id='" . $package_id . "'";
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

	function check_exist_package_name($package_name, $package_id="") {
		global $wpdb;
		$package_name = strtolower(trim($package_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(package_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(package_name)='".esc_sql($package_name)."' AND package_id <> '".$package_id."'";
			$total_package = $wpdb->get_var($sql);
			if ($total_package == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_package($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$package_order                = isset($item_obj['package_order']) ? (int) trim($item_obj['package_order']) : 0;
			$package_price                = isset($item_obj['package_price']) ? (double) trim($item_obj['package_price']) : 0;
			$package_name                 = isset($item_obj['package_name']) ? trim($item_obj['package_name']) : "";
			$package_subtext              = isset($item_obj['package_subtext']) ? trim($item_obj['package_subtext']) : "";
			$package_description          = isset($item_obj['package_description']) ? trim($item_obj['package_description']) : "";
			$package_multiple_cats        = isset($item_obj['package_multiple_cats']) ? trim($item_obj['package_multiple_cats']) : "";
			$package_multiple_images      = isset($item_obj['package_multiple_images']) ? trim($item_obj['package_multiple_images']) : "";
			$package_image                = isset($item_obj['package_image']) ? trim($item_obj['package_image']) : "";
			$package_expires              = isset($item_obj['package_expires']) ? (int) trim($item_obj['package_expires']) : 0;
			$package_hidden               = isset($item_obj['package_hidden']) ? trim($item_obj['package_hidden']) : "";
			$package_multiple_cats_amount = isset($item_obj['package_multiple_cats_amount']) ? trim($item_obj['package_multiple_cats_amount']) : "";
			$package_max_uploads          = isset($item_obj['package_max_uploads']) ? trim($item_obj['package_max_uploads']) : "";
			$package_action               = isset($item_obj['package_action']) ? trim($item_obj['package_action']) : "";
			$package_access_fields        = isset($item_obj['package_access_fields']) ? trim($item_obj['package_access_fields']) : "";
			$package_position             = isset($item_obj['package_position']) ? trim($item_obj['package_position']) : "";
			$package_button               = isset($item_obj['package_button']) ? trim($item_obj['package_button']) : "";
			$is_front_page                = isset($item_obj['is_front_page']) ? (int) trim($item_obj['is_front_page']) : 0;
			$is_active                    = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$sql = "INSERT INTO ".$table_name."(package_order, package_price, package_name, package_subtext,
					package_description, package_multiple_cats, package_multiple_images, package_image, package_expires,
					package_hidden, package_multiple_cats_amount, package_max_uploads, package_action, package_access_fields, package_position, package_button, is_front_page, is_active) " .
				" VALUES ('%d', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$package_order,
						$package_price,
						$package_name,
						$package_subtext,
						$package_description,
						$package_multiple_cats,
						$package_multiple_images,
						$package_image,
						$package_expires,
						$package_hidden,
						$package_multiple_cats_amount,
						$package_max_uploads,
						$package_action,
						$package_access_fields,
						$package_position,
						$package_button,
						$is_front_page,
						$is_active
					)
				)
			);
		}
	}

	function update_plgsoft_package($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$package_id                   = isset($item_obj['package_id']) ? (int) trim($item_obj['package_id']) : 0;
			$package_order                = isset($item_obj['package_order']) ? (int) trim($item_obj['package_order']) : 0;
			$package_price                = isset($item_obj['package_price']) ? (double) trim($item_obj['package_price']) : 0;
			$package_name                 = isset($item_obj['package_name']) ? trim($item_obj['package_name']) : "";
			$package_subtext              = isset($item_obj['package_subtext']) ? trim($item_obj['package_subtext']) : "";
			$package_description          = isset($item_obj['package_description']) ? trim($item_obj['package_description']) : "";
			$package_multiple_cats        = isset($item_obj['package_multiple_cats']) ? trim($item_obj['package_multiple_cats']) : "";
			$package_multiple_images      = isset($item_obj['package_multiple_images']) ? trim($item_obj['package_multiple_images']) : "";
			$package_image                = isset($item_obj['package_image']) ? trim($item_obj['package_image']) : "";
			$package_expires              = isset($item_obj['package_expires']) ? (int) trim($item_obj['package_expires']) : 0;
			$package_hidden               = isset($item_obj['package_hidden']) ? trim($item_obj['package_hidden']) : "";
			$package_multiple_cats_amount = isset($item_obj['package_multiple_cats_amount']) ? trim($item_obj['package_multiple_cats_amount']) : "";
			$package_max_uploads          = isset($item_obj['package_max_uploads']) ? trim($item_obj['package_max_uploads']) : "";
			$package_action               = isset($item_obj['package_action']) ? trim($item_obj['package_action']) : "";
			$package_access_fields        = isset($item_obj['package_access_fields']) ? trim($item_obj['package_access_fields']) : "";
			$package_position             = isset($item_obj['package_position']) ? trim($item_obj['package_position']) : "";
			$package_button               = isset($item_obj['package_button']) ? trim($item_obj['package_button']) : "";
			$is_front_page                = isset($item_obj['is_front_page']) ? (int) trim($item_obj['is_front_page']) : 0;
			$is_active                    = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$sql = "UPDATE ".$table_name." SET package_order='%d', " .
				" package_price='%f', " .
				" package_name='%s', " .
				" package_subtext='%s', " .
				" package_description='%s', " .
				" package_multiple_cats='%s', " .
				" package_multiple_images='%s', " .
				" package_image='%s', " .
				" package_expires='%s', " .
				" package_hidden='%s', " .
				" package_multiple_cats_amount='%s', " .
				" package_max_uploads='%s', " .
				" package_action='%s', " .
				" package_access_fields='%s', " .
				" package_position='%s', " .
				" package_button='%s', " .
				" is_front_page='%d', " .
				" is_active='%d' " .
			" WHERE package_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$package_order,
						$package_price,
						$package_name,
						$package_subtext,
						$package_description,
						$package_multiple_cats,
						$package_multiple_images,
						$package_image,
						$package_expires,
						$package_hidden,
						$package_multiple_cats_amount,
						$package_max_uploads,
						$package_action,
						$package_access_fields,
						$package_position,
						$package_button,
						$is_front_page,
						$is_active,
						$package_id
					)
				)
			);
		}
	}

	function delete_plgsoft_package($package_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($package_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE package_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $package_id));
		}
	}

	function active_plgsoft_package($package_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE package_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $package_id));
		}
	}

	function deactive_plgsoft_package($package_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE package_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $package_id));
		}
	}
}
?>
