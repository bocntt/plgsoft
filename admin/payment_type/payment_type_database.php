<?php
class payment_type_database {
	var $table_name;

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_plgsoft_payment_type($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(payment_type_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(payment_type_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(payment_type_subtext) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(payment_type_description) LIKE '%".$keyword."%')";
			}
			$total_payment_type = $wpdb->get_var($sql);
			return $total_payment_type;
		}
	}

	function get_list_plgsoft_payment_type($array_keywords=array(), $limit=0, $offset=0) {
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
				$sql .= " AND (LOWER(payment_type_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(payment_type_subtext) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(payment_type_description) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY payment_type_order";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				$array_result[$index]['payment_type_id'] = $item_obj->payment_type_id;
				$array_result[$index]['payment_type_order'] = $item_obj->payment_type_order;
				$array_result[$index]['payment_type_price'] = $item_obj->payment_type_price;
				$array_result[$index]['payment_type_name'] = $item_obj->payment_type_name;
				$array_result[$index]['payment_type_subtext'] = $item_obj->payment_type_subtext;
				$array_result[$index]['payment_type_description'] = $item_obj->payment_type_description;
				$array_result[$index]['payment_type_multiple_cats'] = $item_obj->payment_type_multiple_cats;
				$array_result[$index]['payment_type_multiple_images'] = $item_obj->payment_type_multiple_images;
				$array_result[$index]['payment_type_image'] = $item_obj->payment_type_image;
				$array_result[$index]['payment_type_expires'] = $item_obj->payment_type_expires;
				$array_result[$index]['payment_type_hidden'] = $item_obj->payment_type_hidden;
				$array_result[$index]['payment_type_multiple_cats_amount'] = $item_obj->payment_type_multiple_cats_amount;
				$array_result[$index]['payment_type_max_uploads'] = $item_obj->payment_type_max_uploads;
				$array_result[$index]['payment_type_action'] = $item_obj->payment_type_action;
				$array_result[$index]['payment_type_access_fields'] = $item_obj->payment_type_access_fields;
				$array_result[$index]['payment_type_position'] = $item_obj->payment_type_position;
				$array_result[$index]['payment_type_button'] = $item_obj->payment_type_button;
				$array_result[$index]['is_front_page'] = $item_obj->is_front_page;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$index++;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_payment_type_by_array_payment_type_id($array_payment_type_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_payment_type_id) == 0) {
			return array();
		} else {
			$string_payment_type_id = implode("','", $array_payment_type_id);
			$sql = "SELECT payment_type_id, payment_type_name " .
				" FROM " . $table_name;
			$sql .= " WHERE payment_type_id IN ('".$string_payment_type_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->payment_type_id] = $item_obj->payment_type_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_payment_type_by_payment_type_id($payment_type_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE payment_type_id='" . $payment_type_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['payment_type_id'] = $item_obj->payment_type_id;
				$result_obj['payment_type_order'] = $item_obj->payment_type_order;
				$result_obj['payment_type_price'] = $item_obj->payment_type_price;
				$result_obj['payment_type_name'] = $item_obj->payment_type_name;
				$result_obj['payment_type_subtext'] = $item_obj->payment_type_subtext;
				$result_obj['payment_type_description'] = $item_obj->payment_type_description;
				$result_obj['payment_type_multiple_cats'] = $item_obj->payment_type_multiple_cats;
				$result_obj['payment_type_multiple_images'] = $item_obj->payment_type_multiple_images;
				$result_obj['payment_type_image'] = $item_obj->payment_type_image;
				$result_obj['payment_type_expires'] = $item_obj->payment_type_expires;
				$result_obj['payment_type_hidden'] = $item_obj->payment_type_hidden;
				$result_obj['payment_type_multiple_cats_amount'] = $item_obj->payment_type_multiple_cats_amount;
				$result_obj['payment_type_max_uploads'] = $item_obj->payment_type_max_uploads;
				$result_obj['payment_type_action'] = $item_obj->payment_type_action;
				$result_obj['payment_type_access_fields'] = $item_obj->payment_type_access_fields;
				$result_obj['payment_type_position'] = $item_obj->payment_type_position;
				$result_obj['payment_type_button'] = $item_obj->payment_type_button;
				$result_obj['is_front_page'] = $item_obj->is_front_page;
				$result_obj['is_active'] = $item_obj->is_active;
			}
			return $result_obj;
		}
	}

	function check_exist_payment_type_name($payment_type_name, $payment_type_id="") {
		global $wpdb;
		$payment_type_name = strtolower(trim($payment_type_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(payment_type_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(payment_type_name)='".esc_sql($payment_type_name)."' AND payment_type_id <> '".$payment_type_id."'";
			$total_payment_type = $wpdb->get_var($sql);
			if ($total_payment_type == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_payment_type($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$payment_type_order                = isset($item_obj['payment_type_order']) ? (int) trim($item_obj['payment_type_order']) : 0;
			$payment_type_price                = isset($item_obj['payment_type_price']) ? (double) trim($item_obj['payment_type_price']) : 0;
			$payment_type_name                 = isset($item_obj['payment_type_name']) ? trim($item_obj['payment_type_name']) : "";
			$payment_type_subtext              = isset($item_obj['payment_type_subtext']) ? trim($item_obj['payment_type_subtext']) : "";
			$payment_type_description          = isset($item_obj['payment_type_description']) ? trim($item_obj['payment_type_description']) : "";
			$payment_type_multiple_cats        = isset($item_obj['payment_type_multiple_cats']) ? trim($item_obj['payment_type_multiple_cats']) : "";
			$payment_type_multiple_images      = isset($item_obj['payment_type_multiple_images']) ? trim($item_obj['payment_type_multiple_images']) : "";
			$payment_type_image                = isset($item_obj['payment_type_image']) ? trim($item_obj['payment_type_image']) : "";
			$payment_type_expires              = isset($item_obj['payment_type_expires']) ? (int) trim($item_obj['payment_type_expires']) : 0;
			$payment_type_hidden               = isset($item_obj['payment_type_hidden']) ? trim($item_obj['payment_type_hidden']) : "";
			$payment_type_multiple_cats_amount = isset($item_obj['payment_type_multiple_cats_amount']) ? trim($item_obj['payment_type_multiple_cats_amount']) : "";
			$payment_type_max_uploads          = isset($item_obj['payment_type_max_uploads']) ? trim($item_obj['payment_type_max_uploads']) : "";
			$payment_type_action               = isset($item_obj['payment_type_action']) ? trim($item_obj['payment_type_action']) : "";
			$payment_type_access_fields        = isset($item_obj['payment_type_access_fields']) ? trim($item_obj['payment_type_access_fields']) : "";
			$payment_type_position             = isset($item_obj['payment_type_position']) ? trim($item_obj['payment_type_position']) : "";
			$payment_type_button               = isset($item_obj['payment_type_button']) ? trim($item_obj['payment_type_button']) : "";
			$is_front_page                     = isset($item_obj['is_front_page']) ? (int) trim($item_obj['is_front_page']) : 0;
			$is_active                         = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$sql = "INSERT INTO ".$table_name."(payment_type_order, payment_type_price, payment_type_name, payment_type_subtext,
					payment_type_description, payment_type_multiple_cats, payment_type_multiple_images, payment_type_image, payment_type_expires,
					payment_type_hidden, payment_type_multiple_cats_amount, payment_type_max_uploads, payment_type_action, payment_type_access_fields, payment_type_position, payment_type_button, is_front_page, is_active) " .
				" VALUES ('%d', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$payment_type_order,
						$payment_type_price,
						$payment_type_name,
						$payment_type_subtext,
						$payment_type_description,
						$payment_type_multiple_cats,
						$payment_type_multiple_images,
						$payment_type_image,
						$payment_type_expires,
						$payment_type_hidden,
						$payment_type_multiple_cats_amount,
						$payment_type_max_uploads,
						$payment_type_action,
						$payment_type_access_fields,
						$payment_type_position,
						$payment_type_button,
						$is_front_page,
						$is_active
					)
				)
			);
		}
	}

	function update_plgsoft_payment_type($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$payment_type_id                   = isset($item_obj['payment_type_id']) ? (int) trim($item_obj['payment_type_id']) : 0;
			$payment_type_order                = isset($item_obj['payment_type_order']) ? (int) trim($item_obj['payment_type_order']) : 0;
			$payment_type_price                = isset($item_obj['payment_type_price']) ? (double) trim($item_obj['payment_type_price']) : 0;
			$payment_type_name                 = isset($item_obj['payment_type_name']) ? trim($item_obj['payment_type_name']) : "";
			$payment_type_subtext              = isset($item_obj['payment_type_subtext']) ? trim($item_obj['payment_type_subtext']) : "";
			$payment_type_description          = isset($item_obj['payment_type_description']) ? trim($item_obj['payment_type_description']) : "";
			$payment_type_multiple_cats        = isset($item_obj['payment_type_multiple_cats']) ? trim($item_obj['payment_type_multiple_cats']) : "";
			$payment_type_multiple_images      = isset($item_obj['payment_type_multiple_images']) ? trim($item_obj['payment_type_multiple_images']) : "";
			$payment_type_image                = isset($item_obj['payment_type_image']) ? trim($item_obj['payment_type_image']) : "";
			$payment_type_expires              = isset($item_obj['payment_type_expires']) ? (int) trim($item_obj['payment_type_expires']) : 0;
			$payment_type_hidden               = isset($item_obj['payment_type_hidden']) ? trim($item_obj['payment_type_hidden']) : "";
			$payment_type_multiple_cats_amount = isset($item_obj['payment_type_multiple_cats_amount']) ? trim($item_obj['payment_type_multiple_cats_amount']) : "";
			$payment_type_max_uploads          = isset($item_obj['payment_type_max_uploads']) ? trim($item_obj['payment_type_max_uploads']) : "";
			$payment_type_action               = isset($item_obj['payment_type_action']) ? trim($item_obj['payment_type_action']) : "";
			$payment_type_access_fields        = isset($item_obj['payment_type_access_fields']) ? trim($item_obj['payment_type_access_fields']) : "";
			$payment_type_position             = isset($item_obj['payment_type_position']) ? trim($item_obj['payment_type_position']) : "";
			$payment_type_button               = isset($item_obj['payment_type_button']) ? trim($item_obj['payment_type_button']) : "";
			$is_front_page                     = isset($item_obj['is_front_page']) ? (int) trim($item_obj['is_front_page']) : 0;
			$is_active                         = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$sql = "UPDATE ".$table_name." SET payment_type_order='%d', " .
				" payment_type_price='%f', " .
				" payment_type_name='%s', " .
				" payment_type_subtext='%s', " .
				" payment_type_description='%s', " .
				" payment_type_multiple_cats='%s', " .
				" payment_type_multiple_images='%s', " .
				" payment_type_image='%s', " .
				" payment_type_expires='%d', " .
				" payment_type_hidden='%s', " .
				" payment_type_multiple_cats_amount='%s', " .
				" payment_type_max_uploads='%s', " .
				" payment_type_action='%s', " .
				" payment_type_access_fields='%s', " .
				" payment_type_position='%s', " .
				" payment_type_button='%s', " .
				" is_front_page='%d', " .
				" is_active='%d' " .
			" WHERE payment_type_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$payment_type_order,
						$payment_type_price,
						$payment_type_name,
						$payment_type_subtext,
						$payment_type_description,
						$payment_type_multiple_cats,
						$payment_type_multiple_images,
						$payment_type_image,
						$payment_type_expires,
						$payment_type_hidden,
						$payment_type_multiple_cats_amount,
						$payment_type_max_uploads,
						$payment_type_action,
						$payment_type_access_fields,
						$payment_type_position,
						$payment_type_button,
						$is_front_page,
						$is_active,
						$payment_type_id
					)
				)
			);
		}
	}

	function delete_plgsoft_payment_type($payment_type_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($payment_type_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE payment_type_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $payment_type_id));
		}
	}

	function active_plgsoft_payment_type($payment_type_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE payment_type_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $payment_type_id));
		}
	}

	function deactive_plgsoft_payment_type($payment_type_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE payment_type_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $payment_type_id));
		}
	}
}
?>
