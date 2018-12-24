<?php
class membership_database {
	var $table_name;

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_plgsoft_membership($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(membership_id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(membership_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(membership_subtext) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(membership_description) LIKE '%".$keyword."%')";
			}
			$total_membership = $wpdb->get_var($sql);
			return $total_membership;
		}
	}

	function get_list_plgsoft_membership($array_keywords=array(), $limit=0, $offset=0) {
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
				$sql .= " AND (LOWER(membership_name) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(membership_subtext) LIKE '%".$keyword."%')";
				$sql .= " OR (LOWER(membership_description) LIKE '%".$keyword."%')";
			}
			$sql .= " ORDER BY membership_order";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				$array_result[$index]['membership_id'] = $item_obj->membership_id;
				$array_result[$index]['membership_order'] = $item_obj->membership_order;
				$array_result[$index]['membership_price'] = $item_obj->membership_price;
				$array_result[$index]['membership_submissionamount'] = $item_obj->membership_submissionamount;
				$array_result[$index]['membership_name'] = $item_obj->membership_name;
				$array_result[$index]['membership_subtext'] = $item_obj->membership_subtext;
				$array_result[$index]['membership_description'] = $item_obj->membership_description;
				$array_result[$index]['membership_multiple_cats'] = $item_obj->membership_multiple_cats;
				$array_result[$index]['membership_multiple_images'] = $item_obj->membership_multiple_images;
				$array_result[$index]['membership_image'] = $item_obj->membership_image;
				$array_result[$index]['membership_expires'] = $item_obj->membership_expires;
				$array_result[$index]['membership_access_fields'] = $item_obj->membership_access_fields;
				$array_result[$index]['membership_position'] = $item_obj->membership_position;
				$array_result[$index]['membership_button'] = $item_obj->membership_button;
				$array_result[$index]['is_front_page'] = $item_obj->is_front_page;
				$array_result[$index]['frontpage'] = $item_obj->frontpage;
				$array_result[$index]['featured'] = $item_obj->featured;
				$array_result[$index]['html'] = $item_obj->html;
				$array_result[$index]['visitorcounter'] = $item_obj->visitorcounter;
				$array_result[$index]['topcategory'] = $item_obj->topcategory;
				$array_result[$index]['showgooglemap'] = $item_obj->showgooglemap;
				$array_result[$index]['is_active'] = $item_obj->is_active;
				$array_result[$index]['package_id'] = $item_obj->package_id;
				$index++;
			}
			return $array_result;
		}
	}

	function get_all_plgsoft_membership_by_array_membership_id($array_membership_id=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (sizeof($array_membership_id) == 0) {
			return array();
		} else {
			$string_membership_id = implode("','", $array_membership_id);
			$sql = "SELECT membership_id, membership_name " .
				" FROM " . $table_name;
			$sql .= " WHERE membership_id IN ('".$string_membership_id."')";
			$list_results = $wpdb->get_results($sql);
			$array_result = array();
			foreach ($list_results as $item_obj) {
				$array_result[$item_obj->membership_id] = $item_obj->membership_name;
			}
			return $array_result;
		}
	}

	function get_plgsoft_membership_by_membership_id($membership_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE membership_id='" . $membership_id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['membership_id'] = $item_obj->membership_id;
				$result_obj['membership_order'] = $item_obj->membership_order;
				$result_obj['membership_price'] = $item_obj->membership_price;
				$result_obj['membership_submissionamount'] = $item_obj->membership_submissionamount;
				$result_obj['membership_name'] = $item_obj->membership_name;
				$result_obj['membership_subtext'] = $item_obj->membership_subtext;
				$result_obj['membership_description'] = $item_obj->membership_description;
				$result_obj['membership_multiple_cats'] = $item_obj->membership_multiple_cats;
				$result_obj['membership_multiple_images'] = $item_obj->membership_multiple_images;
				$result_obj['membership_image'] = $item_obj->membership_image;
				$result_obj['membership_expires'] = $item_obj->membership_expires;
				$result_obj['membership_access_fields'] = $item_obj->membership_access_fields;
				$result_obj['membership_position'] = $item_obj->membership_position;
				$result_obj['membership_button'] = $item_obj->membership_button;
				$result_obj['is_front_page'] = $item_obj->is_front_page;
				$result_obj['frontpage'] = $item_obj->frontpage;
				$result_obj['featured'] = $item_obj->featured;
				$result_obj['html'] = $item_obj->html;
				$result_obj['visitorcounter'] = $item_obj->visitorcounter;
				$result_obj['topcategory'] = $item_obj->topcategory;
				$result_obj['showgooglemap'] = $item_obj->showgooglemap;
				$result_obj['is_active'] = $item_obj->is_active;
				$result_obj['package_id'] = $item_obj->package_id;
			}
			return $result_obj;
		}
	}

	function check_exist_membership_name($membership_name, $membership_id="") {
		global $wpdb;
		$membership_name = strtolower(trim($membership_name));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return false;
		} else {
			$sql = "SELECT COUNT(membership_id) " .
				" FROM " . $table_name .
				" WHERE LOWER(membership_name)='".esc_sql($membership_name)."' AND membership_id <> '".$membership_id."'";
			$total_membership = $wpdb->get_var($sql);
			if ($total_membership == 0)
				return false;
			else
				return true;
		}
	}

	function insert_plgsoft_membership($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$membership_order            = isset($item_obj['membership_order']) ? (int) trim($item_obj['membership_order']) : 0;
			$membership_price            = isset($item_obj['membership_price']) ? (double) trim($item_obj['membership_price']) : 0;
			$membership_submissionamount = isset($item_obj['membership_submissionamount']) ? (double) trim($item_obj['membership_submissionamount']) : 0;
			$membership_name             = isset($item_obj['membership_name']) ? trim($item_obj['membership_name']) : "";
			$membership_subtext          = isset($item_obj['membership_subtext']) ? trim($item_obj['membership_subtext']) : "";
			$membership_description      = isset($item_obj['membership_description']) ? trim($item_obj['membership_description']) : "";
			$membership_multiple_cats    = isset($item_obj['membership_multiple_cats']) ? trim($item_obj['membership_multiple_cats']) : "";
			$membership_multiple_images  = isset($item_obj['membership_multiple_images']) ? trim($item_obj['membership_multiple_images']) : "";
			$membership_image            = isset($item_obj['membership_image']) ? trim($item_obj['membership_image']) : "";
			$membership_expires          = isset($item_obj['membership_expires']) ? (int) trim($item_obj['membership_expires']) : 0;
			$membership_access_fields    = isset($item_obj['membership_access_fields']) ? trim($item_obj['membership_access_fields']) : "";
			$membership_position         = isset($item_obj['membership_position']) ? trim($item_obj['membership_position']) : "";
			$membership_button           = isset($item_obj['membership_button']) ? trim($item_obj['membership_button']) : "";
			$is_front_page               = isset($item_obj['is_front_page']) ? (int) trim($item_obj['is_front_page']) : 0;
			$frontpage                   = isset($item_obj['frontpage']) ? (int) trim($item_obj['frontpage']) : 0;
			$featured                    = isset($item_obj['featured']) ? (int) trim($item_obj['featured']) : 0;
			$html                        = isset($item_obj['html']) ? (int) trim($item_obj['html']) : 0;
			$visitorcounter              = isset($item_obj['visitorcounter']) ? (int) trim($item_obj['visitorcounter']) : 0;
			$topcategory                 = isset($item_obj['topcategory']) ? (int) trim($item_obj['topcategory']) : 0;
			$showgooglemap               = isset($item_obj['showgooglemap']) ? (int) trim($item_obj['showgooglemap']) : 0;
			$is_active                   = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$package_id                  = isset($item_obj['package_id']) ? (int) trim($item_obj['package_id']) : 0;
			$sql = "INSERT INTO ".$table_name."(membership_order, membership_price, membership_submissionamount, membership_name, membership_subtext, membership_description, membership_multiple_cats, membership_multiple_images, membership_image, membership_expires, membership_access_fields, membership_position, membership_button, is_front_page, frontpage, featured, html, visitorcounter, topcategory, showgooglemap, is_active, package_id) " .
				" VALUES ('%d', '%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$membership_order,
						$membership_price,
						$membership_submissionamount,
						$membership_name,
						$membership_subtext,
						$membership_description,
						$membership_multiple_cats,
						$membership_multiple_images,
						$membership_image,
						$membership_expires,
						$membership_access_fields,
						$membership_position,
						$membership_button,
						$is_front_page,
						$frontpage,
						$featured,
						$html,
						$visitorcounter,
						$topcategory,
						$showgooglemap,
						$is_active,
						$package_id
					)
				)
			);
		}
	}

	function update_plgsoft_membership($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$membership_id               = isset($item_obj['membership_id']) ? (int) trim($item_obj['membership_id']) : 0;
			$membership_order            = isset($item_obj['membership_order']) ? (int) trim($item_obj['membership_order']) : 0;
			$membership_price            = isset($item_obj['membership_price']) ? (double) trim($item_obj['membership_price']) : 0;
			$membership_submissionamount = isset($item_obj['membership_submissionamount']) ? (double) trim($item_obj['membership_submissionamount']) : 0;
			$membership_name             = isset($item_obj['membership_name']) ? trim($item_obj['membership_name']) : "";
			$membership_subtext          = isset($item_obj['membership_subtext']) ? trim($item_obj['membership_subtext']) : "";
			$membership_description      = isset($item_obj['membership_description']) ? trim($item_obj['membership_description']) : "";
			$membership_multiple_cats    = isset($item_obj['membership_multiple_cats']) ? trim($item_obj['membership_multiple_cats']) : "";
			$membership_multiple_images  = isset($item_obj['membership_multiple_images']) ? trim($item_obj['membership_multiple_images']) : "";
			$membership_image            = isset($item_obj['membership_image']) ? trim($item_obj['membership_image']) : "";
			$membership_expires          = isset($item_obj['membership_expires']) ? (int) trim($item_obj['membership_expires']) : 0;
			$membership_access_fields    = isset($item_obj['membership_access_fields']) ? trim($item_obj['membership_access_fields']) : "";
			$membership_position         = isset($item_obj['membership_position']) ? trim($item_obj['membership_position']) : "";
			$membership_button           = isset($item_obj['membership_button']) ? trim($item_obj['membership_button']) : "";
			$is_front_page               = isset($item_obj['is_front_page']) ? (int) trim($item_obj['is_front_page']) : 0;
			$frontpage                   = isset($item_obj['frontpage']) ? (int) trim($item_obj['frontpage']) : 0;
			$featured                    = isset($item_obj['featured']) ? (int) trim($item_obj['featured']) : 0;
			$html                        = isset($item_obj['html']) ? (int) trim($item_obj['html']) : 0;
			$visitorcounter              = isset($item_obj['visitorcounter']) ? (int) trim($item_obj['visitorcounter']) : 0;
			$topcategory                 = isset($item_obj['topcategory']) ? (int) trim($item_obj['topcategory']) : 0;
			$showgooglemap               = isset($item_obj['showgooglemap']) ? (int) trim($item_obj['showgooglemap']) : 0;
			$is_active                   = isset($item_obj['is_active']) ? (int) trim($item_obj['is_active']) : 0;
			$package_id                  = isset($item_obj['package_id']) ? (int) trim($item_obj['package_id']) : 0;
			$sql = "UPDATE ".$table_name." SET membership_order='%d', " .
				" membership_price='%f', " .
				" membership_submissionamount='%f', " .
				" membership_name='%s', " .
				" membership_subtext='%s', " .
				" membership_description='%s', " .
				" membership_multiple_cats='%s', " .
				" membership_multiple_images='%s', " .
				" membership_image='%s', " .
				" membership_expires='%s', " .
				" membership_access_fields='%s', " .
				" membership_position='%s', " .
				" membership_button='%s', " .
				" is_front_page='%d', " .
				" frontpage='%d', " .
				" featured='%d', " .
				" html='%d', " .
				" visitorcounter='%d', " .
				" topcategory='%d', " .
				" showgooglemap='%d', " .
				" is_active='%d', " .
				" package_id='%d' " .
			" WHERE membership_id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$membership_order,
						$membership_price,
						$membership_submissionamount,
						$membership_name,
						$membership_subtext,
						$membership_description,
						$membership_multiple_cats,
						$membership_multiple_images,
						$membership_image,
						$membership_expires,
						$membership_access_fields,
						$membership_position,
						$membership_button,
						$is_front_page,
						$featured,
						$html,
						$visitorcounter,
						$topcategory,
						$showgooglemap,
						$is_active,
						$package_id,
						$membership_id
					)
				)
			);
		}
	}

	function delete_plgsoft_membership($membership_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($membership_id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE membership_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $membership_id));
		}
	}

	function active_plgsoft_membership($membership_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='1' WHERE membership_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $membership_id));
		}
	}

	function deactive_plgsoft_membership($membership_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$sql = "UPDATE ".$table_name." SET is_active='0' WHERE membership_id='%d'";
			$wpdb->query($wpdb->prepare($sql, $membership_id));
		}
	}
}
?>
