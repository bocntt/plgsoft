<?php
class quotes_database {
	var $table_name = "quotes";
	var $array_from_user = array();
	var $array_to_user = array();

	function get_table_name() {
		return $this->table_name;
	}
	function set_table_name($table_name) {
		$this->table_name = $table_name;
	}

	function get_array_from_user() {
		return $this->array_from_user;
	}
	function set_array_from_user($array_from_user) {
		$this->array_from_user = $array_from_user;
	}

	function get_array_to_user() {
		return $this->array_to_user;
	}
	function set_array_to_user($array_to_user) {
		$this->array_to_user = $array_to_user;
	}

	function get_total_plgsoft_quotes($array_keywords=array()) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT COUNT(id) FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(from_user) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(to_user) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(content) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(message) LIKE '%%%s%%')";
				$total_quotes = $wpdb->get_var($wpdb->prepare($sql, array($keyword, $keyword, $keyword, $keyword)));
			} else {
				$total_quotes = $wpdb->get_var($sql);
			}
			return $total_quotes;
		}
	}

	function get_list_plgsoft_quotes($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$keyword = isset($array_keywords['keyword']) ? $array_keywords['keyword'] : "";
		$keyword = strtolower(trim($keyword));
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) == 0) {
			return array();
		} else {
			$sql = "SELECT id, from_user, to_user, content, message, image,
				status, anything_else, about_yourself, zip_code, email_address, phone_number, full_name, category_id, send_date" .
				" FROM " . $table_name;
			$sql .= " WHERE 1=1";
			if (strlen($keyword) > 0) {
				$sql .= " AND (LOWER(from_user) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(to_user) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(content) LIKE '%%%s%%')";
				$sql .= " OR (LOWER(message) LIKE '%%%s%%')";
			}
			$sql .= " ORDER BY id DESC";
			if (($limit > 0) && ($offset >= 0)) {
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
			if (strlen($keyword) > 0) {
				$list_results = $wpdb->get_results($wpdb->prepare($sql, array($keyword, $keyword, $keyword, $keyword)));
			} else {
				$list_results = $wpdb->get_results($sql);
			}
			$array_result = array();
			$index = 0;
			foreach ($list_results as $item_obj) {
				if (!in_array($item_obj->from_user, $this->array_from_user)) {
					$this->array_from_user[] = $item_obj->from_user;
				}
				if (!in_array($item_obj->to_user, $this->array_to_user)) {
					$this->array_to_user[] = $item_obj->to_user;
				}
				$array_result[$index]['id']             = $item_obj->id;
				$array_result[$index]['from_user']      = $item_obj->from_user;
				$array_result[$index]['to_user']        = $item_obj->to_user;
				$array_result[$index]['content']        = $item_obj->content;
				$array_result[$index]['message']        = $item_obj->message;
				$array_result[$index]['image']          = $item_obj->image;
				$array_result[$index]['status']         = $item_obj->status;
				$array_result[$index]['anything_else']  = $item_obj->anything_else;
				$array_result[$index]['about_yourself'] = $item_obj->about_yourself;
				$array_result[$index]['zip_code']       = $item_obj->zip_code;
				$array_result[$index]['email_address']  = $item_obj->email_address;
				$array_result[$index]['phone_number']   = $item_obj->phone_number;
				$array_result[$index]['full_name']      = $item_obj->full_name;
				$array_result[$index]['category_id']    = $item_obj->category_id;
				$array_result[$index]['send_date']      = $item_obj->send_date;
				$index++;
			}
			return $array_result;
		}
	}

	function get_plgsoft_quotes_by_id($id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE id='%d'";
			$result_obj = $wpdb->get_row($wpdb->prepare($sql, $id), ARRAY_A);
			return $result_obj;
		}
	}

	function insert_plgsoft_quotes($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$from_user      = isset($item_obj['from_user']) ? (int) trim($item_obj['from_user']) : 0;
			$to_user        = isset($item_obj['to_user']) ? (int) trim($item_obj['to_user']) : 0;
			$content        = isset($item_obj['content']) ? trim($item_obj['content']) : "";
			$message        = isset($item_obj['message']) ? trim($item_obj['message']) : "";
			$image          = isset($item_obj['image']) ? trim($item_obj['image']) : "";
			$status         = isset($item_obj['status']) ? trim($item_obj['status']) : "";
			$anything_else  = isset($item_obj['anything_else']) ? (int) trim($item_obj['anything_else']) : "";
			$about_yourself = isset($item_obj['about_yourself']) ? (int) trim($item_obj['about_yourself']) : "";
			$zip_code       = isset($item_obj['zip_code']) ? trim($item_obj['zip_code']) : "";
			$email_address  = isset($item_obj['email_address']) ? trim($item_obj['email_address']) : "";
			$phone_number   = isset($item_obj['phone_number']) ? trim($item_obj['phone_number']) : "";
			$full_name      = isset($item_obj['full_name']) ? trim($item_obj['full_name']) : "";
			$category_id    = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$send_date      = isset($item_obj['send_date']) ? trim($item_obj['send_date']) : "";
			$sql = "INSERT INTO ".$table_name."(from_user, to_user, content, message, image, status, anything_else, about_yourself, zip_code, email_address, phone_number, full_name, category_id, send_date) " .
				" VALUES ('%d', '%d', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%d', '%s')";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$from_user,
						$to_user,
						$content,
						$message,
						$image,
						$status,
						$anything_else,
						$about_yourself,
						$zip_code,
						$email_address,
						$phone_number,
						$full_name,
						$category_id,
						$send_date
					)
				)
			);
		}
	}

	function update_plgsoft_quotes($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$id             = isset($item_obj['id']) ? (int) trim($item_obj['id']) : 0;
			$from_user      = isset($item_obj['from_user']) ? (int) trim($item_obj['from_user']) : 0;
			$to_user        = isset($item_obj['to_user']) ? (int) trim($item_obj['to_user']) : 0;
			$content        = isset($item_obj['content']) ? trim($item_obj['content']) : "";
			$message        = isset($item_obj['message']) ? trim($item_obj['message']) : "";
			$image          = isset($item_obj['image']) ? trim($item_obj['image']) : "";
			$status         = isset($item_obj['status']) ? trim($item_obj['status']) : "";
			$anything_else  = isset($item_obj['anything_else']) ? (int) trim($item_obj['anything_else']) : "";
			$about_yourself = isset($item_obj['about_yourself']) ? (int) trim($item_obj['about_yourself']) : "";
			$zip_code       = isset($item_obj['zip_code']) ? trim($item_obj['zip_code']) : "";
			$email_address  = isset($item_obj['email_address']) ? trim($item_obj['email_address']) : "";
			$phone_number   = isset($item_obj['phone_number']) ? trim($item_obj['phone_number']) : "";
			$full_name      = isset($item_obj['full_name']) ? trim($item_obj['full_name']) : "";
			$category_id    = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$send_date      = isset($item_obj['send_date']) ? trim($item_obj['send_date']) : "";

			$sql = "UPDATE ".$table_name." SET from_user='%d', " .
				" to_user='%d', " .
				" content='%s', " .
				" message='%s', " .
				" image='%s', " .
				" status='%s', " .
				" anything_else='%d', " .
				" about_yourself='%d', " .
				" zip_code='%s', " .
				" email_address='%s', " .
				" phone_number='%s', " .
				" full_name='%s', " .
				" category_id='%d', " .
				" send_date='%s' " .
			" WHERE id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$from_user,
						$to_user,
						$content,
						$message,
						$image,
						$status,
						$anything_else,
						$about_yourself,
						$zip_code,
						$email_address,
						$phone_number,
						$full_name,
						$category_id,
						$send_date,
						$id
					)
				)
			);
		}
	}

	function delete_plgsoft_quotes($id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (($id > 0) && (strlen($table_name) > 0)) {
			global $wpdb;
			$sql = "DELETE FROM ".$table_name." WHERE id='%d'";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					$id
				)
			);
		}
	}
}
?>
