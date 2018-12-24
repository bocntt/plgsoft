<?php
class membership_db {
	var $table_name = "plgsoft_membership";

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_total_membership($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(membership_id) AS cnt FROM " .$table_name.
				" WHERE is_active='1' AND is_front_page='1'";
		$total_membership = $wpdb->get_var($sql);
		return $total_membership;
	}

	function get_all_membership($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT * FROM " .$table_name.
				" WHERE is_active='1' AND is_front_page='1'" .
				" ORDER BY membership_order";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		foreach ($list_results as $item_obj) {
			$index = $item_obj->membership_id;
			$results[$index]['ID'] = $item_obj->membership_id;
			$results[$index]['order'] = $item_obj->membership_order;
			$results[$index]['price'] = $item_obj->membership_price;
			$results[$index]['submissionamount'] = $item_obj->membership_submissionamount;
			$results[$index]['name'] = $item_obj->membership_name;
			$results[$index]['subtext'] = $item_obj->membership_subtext;
			$results[$index]['description'] = $item_obj->membership_description;
			$results[$index]['multiple_cats'] = $item_obj->membership_multiple_cats;
			$results[$index]['multiple_images'] = $item_obj->membership_multiple_images;
			$results[$index]['image'] = $item_obj->membership_image;
			$results[$index]['expires'] = $item_obj->membership_expires;
			$results[$index]['access_fields'] = $item_obj->membership_access_fields;
			$results[$index]['position'] = $item_obj->membership_position;
			$results[$index]['button'] = $item_obj->membership_button;
			$results[$index]['is_front_page'] = $item_obj->is_front_page;
			$results[$index]['frontpage'] = $item_obj->frontpage;
			$results[$index]['featured'] = $item_obj->featured;
			$results[$index]['html'] = $item_obj->html;
			$results[$index]['visitorcounter'] = $item_obj->visitorcounter;
			$results[$index]['topcategory'] = $item_obj->topcategory;
			$results[$index]['showgooglemap'] = $item_obj->showgooglemap;
			$results[$index]['is_active'] = $item_obj->is_active;
			$results[$index]['package'] = $item_obj->package_id;
			$results[$index]['enhancement']['price'] = $item_obj->membership_price;
			if (isset($item_obj->frontpage) && ($item_obj->frontpage == 1)) {
				$results[$index]['enhancement'][1] = "on";
			} else {
				$results[$index]['enhancement'][1] = "off";
			}
			if (isset($item_obj->featured) && ($item_obj->featured == 1)) {
				$results[$index]['enhancement'][2] = "on";
			} else {
				$results[$index]['enhancement'][2] = "off";
			}
			if (isset($item_obj->html) && ($item_obj->html == 1)) {
				$results[$index]['enhancement'][3] = "on";
			} else {
				$results[$index]['enhancement'][3] = "off";
			}
			if (isset($item_obj->visitorcounter) && ($item_obj->visitorcounter == 1)) {
				$results[$index]['enhancement'][4] = "on";
			} else {
				$results[$index]['enhancement'][4] = "off";
			}
			if (isset($item_obj->topcategory) && ($item_obj->topcategory == 1)) {
				$results[$index]['enhancement'][5] = "on";
			} else {
				$results[$index]['enhancement'][5] = "off";
			}
			if (isset($item_obj->showgooglemap) && ($item_obj->showgooglemap == 1)) {
				$results[$index]['enhancement'][6] = "on";
			} else {
				$results[$index]['enhancement'][6] = "off";
			}
		}
		return $results;
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
			$sql = "SELECT * FROM " . $table_name . " WHERE is_active='1' AND is_front_page='1' AND membership_id='" . $membership_id . "'";
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
				$result_obj['package'] = $item_obj->package_id;
				$result_obj['enhancement']['price'] = $item_obj->membership_price;
				if (isset($item_obj->frontpage) && ($item_obj->frontpage == 1)) {
					$result_obj['enhancement'][1] = "on";
				} else {
					$result_obj['enhancement'][1] = "off";
				}
				if (isset($item_obj->featured) && ($item_obj->featured == 1)) {
					$result_obj['enhancement'][2] = "on";
				} else {
					$result_obj['enhancement'][2] = "off";
				}
				if (isset($item_obj->html) && ($item_obj->html == 1)) {
					$result_obj['enhancement'][3] = "on";
				} else {
					$result_obj['enhancement'][3] = "off";
				}
				if (isset($item_obj->visitorcounter) && ($item_obj->visitorcounter == 1)) {
					$result_obj['enhancement'][4] = "on";
				} else {
					$result_obj['enhancement'][4] = "off";
				}
				if (isset($item_obj->topcategory) && ($item_obj->topcategory == 1)) {
					$result_obj['enhancement'][5] = "on";
				} else {
					$result_obj['enhancement'][5] = "off";
				}
				if (isset($item_obj->showgooglemap) && ($item_obj->showgooglemap == 1)) {
					$result_obj['enhancement'][6] = "on";
				} else {
					$result_obj['enhancement'][6] = "off";
				}
			}
			return $result_obj;
		}
	}
}
?>
