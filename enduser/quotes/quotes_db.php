<?php
class quotes_db {
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

	function get_total_quotes($array_keywords=array()) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT COUNT(id) AS cnt FROM " .$table_name.
				" WHERE 1=1";
		$total_quotes = $wpdb->get_var($sql);
		return $total_quotes;
	}

	function get_all_quotes($array_keywords=array(), $limit=0, $offset=0) {
		global $wpdb;
		$results = array();
		$table_name = $wpdb->prefix . $this->table_name;
		$sql = "SELECT id, from_user, to_user, content, message, image,
				status, anything_else, about_yourself, zip_code, email_address, phone_number, full_name, category_id, send_date FROM " .$table_name.
			" WHERE 1=1" .
			" ORDER BY id DESC";
		if (($limit > 0) && ($offset >= 0)) {
			$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
		}
		$list_results = $wpdb->get_results($sql);
		$index = 0;
		foreach ($list_results as $item_obj) {
			if (!in_array($item_obj->from_user, $this->array_from_user)) {
				$this->array_from_user[] = $item_obj->from_user;
			}
			if (!in_array($item_obj->to_user, $this->array_to_user)) {
				$this->array_to_user[] = $item_obj->to_user;
			}
			$results[$index]['id'] = $item_obj->id;
			$results[$index]['from_user'] = $item_obj->from_user;
			$results[$index]['to_user'] = $item_obj->to_user;
			$results[$index]['content'] = $item_obj->content;
			$results[$index]['message'] = $item_obj->message;
			$results[$index]['image'] = $item_obj->image;
			$results[$index]['status'] = $item_obj->status;
			$results[$index]['anything_else'] = $item_obj->anything_else;
			$results[$index]['about_yourself'] = $item_obj->about_yourself;
			$results[$index]['zip_code'] = $item_obj->zip_code;
			$results[$index]['email_address'] = $item_obj->email_address;
			$results[$index]['phone_number'] = $item_obj->phone_number;
			$results[$index]['full_name'] = $item_obj->full_name;
			$results[$index]['category_id'] = $item_obj->category_id;
			$results[$index]['send_date'] = $item_obj->send_date;
			$index++;
		}
		return $results;
	}

	function get_plgsoft_quotes_by_id($id) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$result_obj = array();
		if (strlen($table_name) == 0) {
			return $result_obj;
		} else {
			$sql = "SELECT * " .
				" FROM " . $table_name . " WHERE 1=1 AND id='" . $id . "'";
			$item_obj = $wpdb->get_row($sql);
			if(isset($item_obj)) {
				$result_obj['id'] = $item_obj->id;
				$result_obj['from_user'] = $item_obj->from_user;
				$result_obj['to_user'] = $item_obj->to_user;
				$result_obj['content'] = $item_obj->content;
				$result_obj['message'] = $item_obj->message;
				$result_obj['image'] = $item_obj->image;
				$result_obj['status'] = $item_obj->status;
				$result_obj['anything_else'] = $item_obj->anything_else;
				$result_obj['about_yourself'] = $item_obj->about_yourself;
				$result_obj['zip_code'] = $item_obj->zip_code;
				$result_obj['email_address'] = $item_obj->email_address;
				$result_obj['phone_number'] = $item_obj->phone_number;
				$result_obj['full_name'] = $item_obj->full_name;
				$result_obj['category_id'] = $item_obj->category_id;
				$result_obj['send_date'] = $item_obj->send_date;
			}
			return $result_obj;
		}
	}

	function get_just_quotes_id_by_params($params) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$anything_else = isset($params['anything_else']) ? $params['anything_else'] : 0;
		$about_yourself = isset($params['about_yourself']) ? $params['about_yourself'] : 0;
		$zip_code = isset($params['zip_code']) ? $params['zip_code'] : "";
		$email_address = isset($params['email_address']) ? $params['email_address'] : "";
		$phone_number = isset($params['phone_number']) ? $params['phone_number'] : "";
		$full_name = isset($params['full_name']) ? $params['full_name'] : "";
		$category_id = isset($params['category_id']) ? $params['category_id'] : 0;
		$send_date = isset($params['send_date']) ? $params['send_date'] : "";
		if (strlen($table_name) == 0) {
			return 0;
		} else {
			$sql = "SELECT MAX(id) " .
				" FROM " . $table_name . " WHERE 1=1 AND anything_else='" .$anything_else. "' AND about_yourself='" .$about_yourself.
				"' AND zip_code='" .$zip_code. "' AND email_address='" .$email_address. "' AND phone_number='" .$phone_number.
				"' AND full_name='" .$full_name. "' AND category_id='" .$category_id. "'AND send_date='" .$send_date. "'";
			$quotes_id = $wpdb->get_var($sql);
			if (strlen($quotes_id) == 0) $quotes_id = 0;
			return $quotes_id;
		}
	}

	function insert_plgsoft_quotes($item_obj) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		if (strlen($table_name) > 0) {
			$from_user      = isset($item_obj['from_user']) ? (int) trim($item_obj['from_user']) : 0;
			$to_user        = isset($item_obj['to_user']) ? (int) trim($item_obj['to_user']) : 0;
			$content        = isset($item_obj['content']) ? trim($item_obj['content']) : '';
			$message        = isset($item_obj['message']) ? trim($item_obj['message']) : "";
			$image          = isset($item_obj['image']) ? trim($item_obj['image']) : "";
			$status         = isset($item_obj['status']) ? trim($item_obj['status']) : "";
			$anything_else  = isset($item_obj['anything_else']) ? trim($item_obj['anything_else']) : "";
			$about_yourself = isset($item_obj['about_yourself']) ? trim($item_obj['about_yourself']) : "";
			$zip_code       = isset($item_obj['zip_code']) ? trim($item_obj['zip_code']) : "";
			$email_address  = isset($item_obj['email_address']) ? trim($item_obj['email_address']) : "";
			$phone_number   = isset($item_obj['phone_number']) ? trim($item_obj['phone_number']) : "";
			$full_name      = isset($item_obj['full_name']) ? trim($item_obj['full_name']) : "";
			$category_id    = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$send_date      = isset($item_obj['send_date']) ? trim($item_obj['send_date']) : '';
			$sql = "INSERT INTO ".$table_name."(from_user, to_user, content, message, image, status, anything_else, about_yourself, zip_code, email_address, phone_number, full_name, category_id, send_date) " .
				" VALUES ('%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s')";
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
			$content        = isset($item_obj['content']) ? trim($item_obj['content']) : '';
			$message        = isset($item_obj['message']) ? trim($item_obj['message']) : "";
			$image          = isset($item_obj['image']) ? trim($item_obj['image']) : "";
			$status         = isset($item_obj['status']) ? trim($item_obj['status']) : "";
			$anything_else  = isset($item_obj['anything_else']) ? trim($item_obj['anything_else']) : "";
			$about_yourself = isset($item_obj['about_yourself']) ? trim($item_obj['about_yourself']) : "";
			$zip_code       = isset($item_obj['zip_code']) ? trim($item_obj['zip_code']) : "";
			$email_address  = isset($item_obj['email_address']) ? trim($item_obj['email_address']) : "";
			$phone_number   = isset($item_obj['phone_number']) ? trim($item_obj['phone_number']) : "";
			$full_name      = isset($item_obj['full_name']) ? trim($item_obj['full_name']) : "";
			$category_id    = isset($item_obj['category_id']) ? (int) trim($item_obj['category_id']) : 0;
			$send_date      = isset($item_obj['send_date']) ? trim($item_obj['send_date']) : '';

			$sql = "UPDATE ".$table_name." SET from_user='%d', " .
				" to_user='%d', " .
				" content='%s', " .
				" message='%s', " .
				" image='%s', " .
				" status='%s', " .
				" anything_else='%s', " .
				" about_yourself='%s', " .
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
			$wpdb->query($wpdb->prepare($sql, $id));
		}
	}
}
?>
