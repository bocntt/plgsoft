<?php
require_once(wp_plugin_plgsoft_admin_dir . "/payment_type/payment_type_database.php");
global $table_name;
$payment_type_database = new payment_type_database();
$payment_type_database->set_table_name($table_name);

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_payment_type';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$payment_type_id = isset($_REQUEST["payment_type_id"]) ? trim($_REQUEST["payment_type_id"]) : "";
$is_validate = false;
$payment_type_order_error = '';
$payment_type_price_error = '';
$payment_type_name_error = '';
$payment_type_subtext_error = '';
$payment_type_description_error = '';
$payment_type_multiple_cats_error = '';
$payment_type_multiple_images_error = '';
$payment_type_image_error = '';
$payment_type_expires_error = '';
$payment_type_hidden_error = '';
$payment_type_multiple_cats_amount_error = '';
$payment_type_max_uploads_error = '';
$payment_type_action_error = '';
$is_active_error = '';
$payment_type_position_error = '';
$payment_type_button_error = '';
$is_front_page_error = '';
$array_yes_no_property = get_array_yes_no_plgsoft_property();
$array_yes_no_text = get_array_yes_no_plgsoft_text();
$array_access_fields = get_array_access_fields();
$array_position = get_array_position();
$array_button = get_array_button();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_payment_type', 'keyword' => $keyword));

if ($task == 'delete') {
	$payment_type_database->delete_plgsoft_payment_type($payment_type_id);
	$task = "list";
	$msg_id = "The payment_type is deleted successfully";
} elseif ($task == 'import_default_data') {
	$array_payment_type[] = array('payment_type_order' => '1',
						'payment_type_price' => '0.00',
						'payment_type_name' => 'Basic payment_type',
						'payment_type_subtext' => 'Business Name, Address, Logo, Short Description, list of services provided,
							choice of 3 business categories. Can only be used for 60 days, after which time listing will expire.',
						'payment_type_description' => 'Business owner will receive an email 14 days before listing expires and has to login and
							renew listing before the 60 days by clicking on renew listing link or button.
							Business owner will be given choice to upgrade to a better listing payment_type at that time.
							Emails will be sent out monthly by cron job explaining benefits of upgrading to a Standard business payment_type
							and showing a list of all payment_types available to upgrade.',
						'payment_type_multiple_cats' => '3',
						'payment_type_multiple_images' => '1',
						'payment_type_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_payment_type.jpg',
						'payment_type_expires' => '60',
						'payment_type_hidden' => 'no',
						'payment_type_multiple_cats_amount' => '30',
						'payment_type_max_uploads' => '30',
						'payment_type_action' => '0',
						'payment_type_position' => 'left',
						'payment_type_button' => 'subscribe-for-free',
						'is_front_page' => '1');
	$array_payment_type[] = array('payment_type_order' => '2',
						'payment_type_price' => '9.95',
						'payment_type_name' => 'Standard Business',
						'payment_type_subtext' => 'Business Name, Address, Logo, Google Map, Short Description, Long Description, Main photo,
							additional photos, Website address link, list of services provided, choice of 3 business categories.',
						'payment_type_description' => 'Emails will be sent out quarterly by cron job explaining benefits of upgrading to a
							Featured Business payment_type and showing a list of all payment_types available to upgrade.',
						'payment_type_multiple_cats' => '3',
						'payment_type_multiple_images' => '1',
						'payment_type_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_payment_type.jpg',
						'payment_type_expires' => '30',
						'payment_type_hidden' => 'no',
						'payment_type_multiple_cats_amount' => '30',
						'payment_type_max_uploads' => '30',
						'payment_type_action' => '0',
						'payment_type_position' => 'left',
						'payment_type_button' => 'sign-up-today',
						'is_front_page' => '1');
	$array_payment_type[] = array('payment_type_order' => '3',
						'payment_type_price' => '29.95',
						'payment_type_name' => 'Featured Business',
						'payment_type_subtext' => 'Listing Includes all items of Standard business: Business Name, Address, Logo, Google Map,
							Short Description, Long Description, Main photo, additional photos, Website address link, list of services provided,
							choice of 5 business categories.',
						'payment_type_description' => 'Plus includes: Videos uploading, Rotating featured listing on all categories selected
							in category pages, list pages and in any services searched as well as social sharing on business listing.<br>
							Emails will be sent out quarterly by cron job explaining benefits of upgrading to a Premium featured payment_type
							and showing a list of all payment_types available to upgrade.',
						'payment_type_multiple_cats' => '5',
						'payment_type_multiple_images' => '1',
						'payment_type_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_payment_type.jpg',
						'payment_type_expires' => '30',
						'payment_type_hidden' => 'no',
						'payment_type_multiple_cats_amount' => '30',
						'payment_type_max_uploads' => '30',
						'payment_type_action' => '0',
						'payment_type_position' => 'left',
						'payment_type_button' => 'upgrade-today',
						'is_front_page' => '1');
	$array_payment_type[] = array('payment_type_order' => '4',
						'payment_type_price' => '99.95',
						'payment_type_name' => 'Premium Featured',
						'payment_type_subtext' => 'Listing Includes: Business Name, Address, Logo, Google Map, Short Description, Long Description,
							videos uploading on listing, Main photo, additional photos, Website address link, list of services provided,
							choice of 5 business categories.',
						'payment_type_description' => 'Plus includes: Rotating featured listing on all categories selected in category pages,
							list pages and in any services searched, social sharing on business listing, featured placement on home page
							of website for your city, placement in monthly newsletters to consumers, placement on plg soft social media monthly.<br>
							Emails will be sent out quarterly by cron job explaining benefits of upgrading to a Get Noticed payment_type.',
						'payment_type_multiple_cats' => '5',
						'payment_type_multiple_images' => '1',
						'payment_type_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_payment_type.jpg',
						'payment_type_expires' => '30',
						'payment_type_hidden' => 'no',
						'payment_type_multiple_cats_amount' => '30',
						'payment_type_max_uploads' => '30',
						'payment_type_action' => '0',
						'payment_type_position' => 'left',
						'payment_type_button' => 'upgrade-today',
						'is_front_page' => '1');

	$payment_type_array = array();
	for($i=0; $i<sizeof($array_payment_type); $i++) {
		$payment_type_array['payment_type_order'] = $i;
		$payment_type_array['payment_type_price'] = $array_payment_type[$i]['payment_type_price'];
		$payment_type_array['payment_type_name'] = $array_payment_type[$i]['payment_type_name'];
		$payment_type_array['payment_type_subtext'] = $array_payment_type[$i]['payment_type_subtext'];
		$payment_type_array['payment_type_description'] = $array_payment_type[$i]['payment_type_description'];
		$payment_type_array['payment_type_multiple_cats'] = $array_payment_type[$i]['payment_type_multiple_cats'];
		$payment_type_array['payment_type_multiple_images'] = $array_payment_type[$i]['payment_type_multiple_images'];
		$payment_type_array['payment_type_image'] = $array_payment_type[$i]['payment_type_image'];
		$payment_type_array['payment_type_expires'] = $array_payment_type[$i]['payment_type_expires'];
		$payment_type_array['payment_type_hidden'] = $array_payment_type[$i]['payment_type_hidden'];
		$payment_type_array['payment_type_multiple_cats_amount'] = $array_payment_type[$i]['payment_type_multiple_cats_amount'];
		$payment_type_array['payment_type_max_uploads'] = $array_payment_type[$i]['payment_type_max_uploads'];
		$payment_type_array['payment_type_action'] = $array_payment_type[$i]['payment_type_action'];
		$payment_type_array['payment_type_position'] = $array_payment_type[$i]['payment_type_position'];
		$payment_type_array['payment_type_button'] = $array_payment_type[$i]['payment_type_button'];
		$payment_type_array['is_front_page'] = $array_payment_type[$i]['is_front_page'];
		$payment_type_array['is_active'] = 1;
		$payment_type_database->insert_plgsoft_payment_type($payment_type_array);
	}
	$task = "list";
	$msg_id = "These payment_type are imported successfully";
} elseif ($task == 'active') {
	$payment_type_database->active_plgsoft_payment_type($payment_type_id);
	$task = "list";
	$msg_id = "The payment_type is actived";
} elseif ($task == 'deactive') {
	$payment_type_database->deactive_plgsoft_payment_type($payment_type_id);
	$task = "list";
	$msg_id = "The payment_type is deactived";
} else {
	if ($is_save==0) {
		if (strlen($payment_type_id)==0) {
			$payment_type_id = isset($_POST["payment_type_id"]) ? trim($_POST["payment_type_id"]) : "";
			$payment_type_order = isset($_POST["payment_type_order"]) ? trim($_POST["payment_type_order"]) : 0;
			$payment_type_price = isset($_POST["payment_type_price"]) ? trim($_POST["payment_type_price"]) : 0;
			$payment_type_name = isset($_POST["payment_type_name"]) ? trim($_POST["payment_type_name"]) : "";
			$payment_type_subtext = isset($_POST["payment_type_subtext"]) ? trim($_POST["payment_type_subtext"]) : "";
			$payment_type_description = isset($_POST["payment_type_description"]) ? trim($_POST["payment_type_description"]) : "";
			$payment_type_multiple_cats = isset($_POST["payment_type_multiple_cats"]) ? trim($_POST["payment_type_multiple_cats"]) : "";
			$payment_type_multiple_images = isset($_POST["payment_type_multiple_images"]) ? trim($_POST["payment_type_multiple_images"]) : "";
			$payment_type_image = isset($_POST["payment_type_image"]) ? trim($_POST["payment_type_image"]) : "";
			$payment_type_expires = isset($_POST["payment_type_expires"]) ? trim($_POST["payment_type_expires"]) : 0;
			$payment_type_hidden = isset($_POST["payment_type_hidden"]) ? trim($_POST["payment_type_hidden"]) : "";
			$payment_type_multiple_cats_amount = isset($_POST["payment_type_multiple_cats_amount"]) ? trim($_POST["payment_type_multiple_cats_amount"]) : 0;
			$payment_type_max_uploads = isset($_POST["payment_type_max_uploads"]) ? trim($_POST["payment_type_max_uploads"]) : 0;
			$payment_type_action = isset($_POST["payment_type_action"]) ? trim($_POST["payment_type_action"]) : 0;
			$payment_type_access_fields = isset($_POST["payment_type_access_fields"]) ? $_POST["payment_type_access_fields"] : array();
			$payment_type_position = isset($_POST["payment_type_position"]) ? $_POST["payment_type_position"] : "";
			$payment_type_button = isset($_POST["payment_type_button"]) ? $_POST["payment_type_button"] : "";
			$is_front_page = isset($_POST["is_front_page"]) ? 1 : 0;
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
		} else {
			$payment_type_obj = $payment_type_database->get_plgsoft_payment_type_by_payment_type_id($payment_type_id);
			$payment_type_id = $payment_type_obj['payment_type_id'];
			$payment_type_order = $payment_type_obj['payment_type_order'];
			$payment_type_price = $payment_type_obj['payment_type_price'];
			$payment_type_name = $payment_type_obj['payment_type_name'];
			$payment_type_subtext = $payment_type_obj['payment_type_subtext'];
			$payment_type_description = $payment_type_obj['payment_type_description'];
			$payment_type_multiple_cats = $payment_type_obj['payment_type_multiple_cats'];
			$payment_type_multiple_images = $payment_type_obj['payment_type_multiple_images'];
			$payment_type_image = $payment_type_obj['payment_type_image'];
			$payment_type_expires = $payment_type_obj['payment_type_expires'];
			$payment_type_hidden = $payment_type_obj['payment_type_hidden'];
			$payment_type_multiple_cats_amount = $payment_type_obj['payment_type_multiple_cats_amount'];
			$payment_type_max_uploads = $payment_type_obj['payment_type_max_uploads'];
			$payment_type_action = $payment_type_obj['payment_type_action'];
			$payment_type_access_fields = $payment_type_obj['payment_type_access_fields'];
			$payment_type_position = $payment_type_obj['payment_type_position'];
			$payment_type_button = $payment_type_obj['payment_type_button'];
			$is_front_page = $payment_type_obj['is_front_page'];
			$is_active = $payment_type_obj['is_active'];
			if (strlen($payment_type_access_fields) > 0) {
				$payment_type_access_fields = explode(",", $payment_type_access_fields);
			} else {
				$payment_type_access_fields = array();
			}
		}
	} else {
		$payment_type_order = isset($_POST["payment_type_order"]) ? trim($_POST["payment_type_order"]) : 0;
		$payment_type_price = isset($_POST["payment_type_price"]) ? trim($_POST["payment_type_price"]) : 0;
		$payment_type_name = isset($_POST["payment_type_name"]) ? trim($_POST["payment_type_name"]) : "";
		$payment_type_subtext = isset($_POST["payment_type_subtext"]) ? trim($_POST["payment_type_subtext"]) : "";
		$payment_type_description = isset($_POST["payment_type_description"]) ? trim($_POST["payment_type_description"]) : "";
		$payment_type_multiple_cats = isset($_POST["payment_type_multiple_cats"]) ? trim($_POST["payment_type_multiple_cats"]) : "";
		$payment_type_multiple_images = isset($_POST["payment_type_multiple_images"]) ? trim($_POST["payment_type_multiple_images"]) : "";
		$payment_type_image = isset($_POST["payment_type_image"]) ? trim($_POST["payment_type_image"]) : "";
		$payment_type_expires = isset($_POST["payment_type_expires"]) ? trim($_POST["payment_type_expires"]) : 0;
		$payment_type_hidden = isset($_POST["payment_type_hidden"]) ? trim($_POST["payment_type_hidden"]) : "";
		$payment_type_multiple_cats_amount = isset($_POST["payment_type_multiple_cats_amount"]) ? trim($_POST["payment_type_multiple_cats_amount"]) : 0;
		$payment_type_max_uploads = isset($_POST["payment_type_max_uploads"]) ? trim($_POST["payment_type_max_uploads"]) : 0;
		$payment_type_action = isset($_POST["payment_type_action"]) ? trim($_POST["payment_type_action"]) : 0;
		$payment_type_access_fields = isset($_POST["payment_type_access_fields"]) ? $_POST["payment_type_access_fields"] : array();
		$payment_type_position = isset($_POST["payment_type_position"]) ? $_POST["payment_type_position"] : "";
		$payment_type_button = isset($_POST["payment_type_button"]) ? $_POST["payment_type_button"] : "";
		$is_front_page = isset($_POST["is_front_page"]) ? 1 : 0;
		$is_active = isset($_POST["is_active"]) ? 1 : 0;

		$check_exist = $payment_type_database->check_exist_payment_type_name($payment_type_name, $payment_type_id);
		if ((strlen($payment_type_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($payment_type_name) == 0) {
				$is_validate = false;
				$payment_type_name_error = "Payment Type Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$payment_type_name_error = "Payment Type Name is existed";
				}
			}
		}

		$check_payment_type_order = check_number_order_listing($payment_type_order);
		if ($check_payment_type_order && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_payment_type_order) {
				$is_validate = false;
				$payment_type_order_error = "Order Listing is not number";
			}
		}

		$check_payment_type_price = check_number_price($payment_type_price);
		if ($check_payment_type_price && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_payment_type_price) {
				$is_validate = false;
				$payment_type_price_error = "Price is not number";
			}
		}

		$check_payment_type_multiple_cats = check_number_order_listing($payment_type_multiple_cats);
		if ($check_payment_type_multiple_cats && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_payment_type_multiple_cats) {
				$is_validate = false;
				$payment_type_multiple_cats_error = "Multiple Categories is not number";
			}
		}

		$check_payment_type_multiple_images = check_number_order_listing($payment_type_multiple_images);
		if ($check_payment_type_multiple_images && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_payment_type_multiple_images) {
				$is_validate = false;
				$payment_type_multiple_images_error = "Multiple Images is not number";
			}
		}

		$check_payment_type_expires = check_number_order_listing($payment_type_expires);
		if ($check_payment_type_expires && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_payment_type_expires) {
				$is_validate = false;
				$payment_type_expires_error = "Expires is not number";
			}
		}

		$check_payment_type_multiple_cats_amount = check_number_order_listing($payment_type_multiple_cats_amount);
		if ($check_payment_type_multiple_cats_amount && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_payment_type_multiple_cats_amount) {
				$is_validate = false;
				$payment_type_multiple_cats_amount_error = "Multiple Categories Amount is not number";
			}
		}

		$check_payment_type_max_uploads = check_number_order_listing($payment_type_max_uploads);
		if ($check_payment_type_max_uploads && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_payment_type_max_uploads) {
				$is_validate = false;
				$payment_type_max_uploads_error = "Max Uploads is not number";
			}
		}

		$check_payment_type_action = check_number_order_listing($payment_type_action);
		if ($check_payment_type_action && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_payment_type_action) {
				$is_validate = false;
				$payment_type_action_error = "Payment Type Action is not number";
			}
		}

		if ((strlen($is_active) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($is_active) == 0) {
				$is_validate = false;
				$is_active_error = "Status is empty";
			}
		}
		if ((strlen($payment_type_position) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($payment_type_position) == 0) {
				$is_validate = false;
				$payment_type_position_error = "Position is empty";
			}
		}
		if ((strlen($payment_type_button) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($payment_type_button) == 0) {
				$is_validate = false;
				$payment_type_button_error = "Button is empty";
			}
		}
		if ((strlen($is_front_page) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($is_front_page) == 0) {
				$is_validate = false;
				$is_front_page_error = "Front Page is empty";
			}
		}
		if ($is_validate) {
			$payment_type_array = array();
			$payment_type_array['payment_type_order']                = $payment_type_order;
			$payment_type_array['payment_type_price']                = $payment_type_price;
			$payment_type_array['payment_type_name']                 = $payment_type_name;
			$payment_type_array['payment_type_subtext']              = $payment_type_subtext;
			$payment_type_array['payment_type_description']          = $payment_type_description;
			$payment_type_array['payment_type_multiple_cats']        = $payment_type_multiple_cats;
			$payment_type_array['payment_type_multiple_images']      = $payment_type_multiple_images;
			$payment_type_array['payment_type_image']                = $payment_type_image;
			$payment_type_array['payment_type_expires']              = $payment_type_expires;
			$payment_type_array['payment_type_hidden']               = $payment_type_hidden;
			$payment_type_array['payment_type_multiple_cats_amount'] = $payment_type_multiple_cats_amount;
			$payment_type_array['payment_type_max_uploads']          = $payment_type_max_uploads;
			$payment_type_array['payment_type_action']               = $payment_type_action;
			$payment_type_access_fields          = implode(",", $payment_type_access_fields);
			$payment_type_array['payment_type_access_fields'] = $payment_type_access_fields;
			$payment_type_array['payment_type_position']      = $payment_type_position;
			$payment_type_array['payment_type_button']        = $payment_type_button;
			$payment_type_array['is_front_page']              = $is_front_page;
			$payment_type_array['is_active']                  = $is_active;
			if ($payment_type_id > 0) {
				$payment_type_array['payment_type_id'] = $payment_type_id;
				$payment_type_database->update_plgsoft_payment_type($payment_type_array);
				$task = "list";
				$msg_id = "The payment_type is edited successfully";
			} else {
				$payment_type_database->insert_plgsoft_payment_type($payment_type_array);
				$task = "list";
				$msg_id = "The payment_type is added successfully";
			}
		}
	}
}
?>
<?php if ($task=='list') { ?>
	<?php
	$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
	$array_keywords = array();
	$array_keywords['keyword'] = $keyword;
	$total_payment_type = $payment_type_database->get_total_plgsoft_payment_type($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;
	$list_payment_type = $payment_type_database->get_list_plgsoft_payment_type($array_keywords, $limit, $offset);
	$payment_type_url = get_plgsoft_admin_url(array('page' => 'manage_payment_type', 'task' => 'add'));
	?>
	<?php if ($total_payment_type > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Payment Type', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Payment Type', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $payment_type_url ); ?>"><?php _e( 'Add Payment Type', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="get" action="<?php echo $manage_list_url; ?>" id="frmSearch" name="frmSearch">
								<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
								<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
								<input type="hidden" id="task" name="task" value="<?php echo $task; ?>">
								<input type="hidden" id="table_name" name="table_name" value="<?php echo $table_name; ?>">
								<input class="form-control" type="text" id="keyword" name="keyword" size="40" value="<?php echo esc_attr( $keyword ); ?>" />
								<input class="btn btn-default" type="submit" id="cmdSearch" name="cmdSearch" value="<?php _e( 'Search', 'plgsoft' ) ?>" />
							</form>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div class="plgsoft-sub-tab-content">
						<?php if (strlen($msg_id) > 0) { ?>
							<div style="margin-bottom: 10px; text-align: center; color: blue;"><?php echo $msg_id; ?></div>
						<?php } ?>
						<table class="table sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Payment Type Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Price', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Position', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Button', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Front Page', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_payment_type as $payment_type_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_payment_type', 'payment_type_id' => $payment_type_item['payment_type_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_payment_type', 'payment_type_id' => $payment_type_item['payment_type_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $payment_type_item['payment_type_id']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $payment_type_item['payment_type_name']; ?>
											</a>
										</td>
										<td class="text-right">$<?php echo $payment_type_item['payment_type_price']; ?></td>
										<td class="text-center">
											<?php
											if ($payment_type_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_payment_type', 'payment_type_id' => $payment_type_item['payment_type_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_payment_type', 'payment_type_id' => $payment_type_item['payment_type_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($payment_type_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center"><?php echo $array_position[$payment_type_item['payment_type_position']]; ?></td>
										<td class="text-center"><?php echo $array_button[$payment_type_item['payment_type_button']]; ?></td>
										<td class="text-center"><?php echo $array_yes_no_property[$payment_type_item['is_front_page']]; ?></td>
										<td class="text-center"><?php echo $payment_type_item['payment_type_order']; ?></td>
										<td class="text-right">
											<a class="btn btn-primary" href="<?php echo esc_url( $edit_link ); ?>"><i class="fa fa-fw fa-edit"></i></a>
											<a class="btn btn-danger" href="<?php echo esc_url( $delete_link ); ?>"><i class="fa fa-fw fa-trash"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<div class="row text-center">
							<?php
							$class_Pagings = new class_Pagings($start, $total_payment_type, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any payment type', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Payment Type', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $payment_type_url ); ?>"><?php _e( 'Add Payment Type', 'plgsoft' ) ?></a>
							<?php $payment_type_import_data_url = get_plgsoft_admin_url(array('page' => 'manage_payment_type', 'task' => 'import_default_data')); ?>
							<a style="padding-left: 10px;" href="<?php echo esc_url( $payment_type_import_data_url ); ?>"><?php _e( 'Import Default Data', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="get" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
								<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
								<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
								<input type="hidden" id="task" name="task" value="<?php echo $task; ?>">
								<input type="hidden" id="table_name" name="table_name" value="<?php echo $table_name; ?>">
								<input class="form-control" type="text" id="keyword" name="keyword" size="40" value="<?php echo esc_attr( $keyword ); ?>" />
								<input class="btn btn-default" type="submit" id="cmdSearch" name="cmdSearch" value="<?php _e( 'Search', 'plgsoft' ) ?>" />
							</form>
						</div>
					</div>
					<div style="clear: both;"></div>
					<div class="plgsoft-sub-tab-content">
						<?php if (strlen($msg_id) > 0) { ?>
							<div style="margin-bottom: 10px; text-align: center; color: blue;"><?php echo $msg_id; ?></div>
						<?php } ?>
						<div class="row text-center">
							<?php echo __('There are no results for this search. Please try another search.', 'plgsoft'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php } else {
	$payment_type_url = get_plgsoft_admin_url(array('page' => 'manage_payment_type', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if (strlen($payment_type_id) > 0) { ?>
			<h2><?php _e( 'Edit payment_type', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add payment_type', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Payment Type', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $payment_type_url ); ?>"><?php _e( 'Add Payment Type', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmpayment_type" name="frmpayment_type" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="payment_type_id" name="payment_type_id" value="<?php echo $payment_type_id; ?>">
						<?php if (strlen($payment_type_id) > 0) { ?>
							<input type="hidden" id="task" name="task" value="edit">
							<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
						<?php } else { ?>
							<input type="hidden" id="task" name="task" value="add">
							<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
						<?php } ?>
						<input type="hidden" id="table_name" name="table_name" value="<?php echo $table_name; ?>">
						<div class="row">
							<label for="required"><?php _e( '* Required', 'plgsoft' ) ?></label>
						</div>
						<div class="row<?php echo (strlen($payment_type_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_name"><?php _e( 'Payment Type Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_name" name="payment_type_name" size="70" value="<?php echo esc_attr($payment_type_name); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_order_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_order"><?php _e( 'Order Listing', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_order_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_order_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_order" name="payment_type_order" size="35" value="<?php echo esc_attr( $payment_type_order ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_price_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_price"><?php _e( 'Price', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_price_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_price_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_price" name="payment_type_price" size="70" value="<?php echo esc_attr( $payment_type_price ); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="payment_type_subtext"><?php _e( 'Sub Text', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<textarea class="form-control textarea" id="payment_type_subtext" name="payment_type_subtext" rows="5" cols="70"><?php echo esc_html($payment_type_subtext); ?></textarea>
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="payment_type_description"><?php _e( 'Description', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<textarea class="form-control textarea" id="payment_type_description" name="payment_type_description" rows="5" cols="70"><?php echo esc_html($payment_type_description); ?></textarea>
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_multiple_cats_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_multiple_cats"><?php _e( 'Multiple Categories', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_multiple_cats_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_multiple_cats_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_multiple_cats" name="payment_type_multiple_cats" size="70" value="<?php echo esc_attr( $payment_type_multiple_cats ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_multiple_images_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_multiple_images"><?php _e( 'Multiple Images', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_multiple_images_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_multiple_images_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_multiple_images" name="payment_type_multiple_images" size="35" value="<?php echo esc_attr( $payment_type_multiple_images ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_image_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_image"><?php _e( 'Image', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_image_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_image_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_image" name="payment_type_image" size="70" value="<?php echo esc_attr( $payment_type_image ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_expires_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_expires"><?php _e( 'Expires', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_expires_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_expires_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_expires" name="payment_type_expires" size="70" value="<?php echo esc_attr( $payment_type_expires ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_hidden_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_hidden"><?php _e( 'Hidden', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_hidden_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_hidden_error; ?></label>
								<?php } ?>
								<select id="payment_type_hidden" name="payment_type_hidden" class="payment_type_hidden form-control select">
									<?php foreach ($array_yes_no_text as $key => $value) { ?>
										<?php if($key == $payment_type_hidden) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_multiple_cats_amount_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_multiple_cats_amount"><?php _e( 'Multiple Categories Amount', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_multiple_cats_amount_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_multiple_cats_amount_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_multiple_cats_amount" name="payment_type_multiple_cats_amount" size="70" value="<?php echo esc_attr( $payment_type_multiple_cats_amount ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_max_uploads_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_max_uploads"><?php _e( 'Max Uploads', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_max_uploads_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_max_uploads_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_max_uploads" name="payment_type_max_uploads" size="70" value="<?php echo esc_attr( $payment_type_max_uploads ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_action_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_action"><?php _e( 'Payment Type Action', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_action_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_action_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="payment_type_action" name="payment_type_action" size="70" value="<?php echo esc_attr( $payment_type_action ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($is_active_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="status"><?php _e( 'Status', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($is_active_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $is_active_error; ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="is_active" id="is_active" <?php echo ($is_active == 1) ? 'checked="checked"' : ''; ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="payment_type_access_fields"><?php _e( 'Access Fields', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<div class="row">
									<?php $index_access_field = 0; ?>
									<?php foreach ($array_access_fields as $key_access_field => $value_access_field) { ?>
										<?php $index_access_field++; ?>
										<div class="col-4" style="/*float: left; width: 33%;*/">
											<input type="checkbox" id="payment_type_access_fields<?php echo $key_access_field; ?>" name="payment_type_access_fields[]"
												value="<?php echo $key_access_field; ?>"
												<?php if ((sizeof($payment_type_access_fields) > 0) && in_array($key_access_field, $payment_type_access_fields)) { ?> checked="checked" <?php } ?> />
											<label><?php echo stripslashes($value_access_field); ?></label>
										</div>
										<?php if ($index_access_field % 3 == 0) { ?><div style="clear: both;"></div><?php } ?>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_position_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_position"><?php _e( 'Position', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_position_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_position_error; ?></label>
								<?php } ?>
								<select id="payment_type_position" name="payment_type_position" class="payment_type_position form-control select">
									<?php foreach ($array_position as $key => $value) { ?>
										<?php if($key == $payment_type_position) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($payment_type_button_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="payment_type_button"><?php _e( 'Button', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($payment_type_button_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $payment_type_button_error; ?></label>
								<?php } ?>
								<select id="payment_type_button" name="payment_type_button" class="payment_type_button form-control select">
									<?php foreach ($array_button as $key => $value) { ?>
										<?php if($key == $payment_type_button) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($is_front_page_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="is_front_page"><?php _e( 'Front Page', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($is_front_page_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $is_front_page_error; ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="is_front_page" id="is_front_page" <?php echo ($is_front_page == 1) ? 'checked="checked"' : ''; ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<input class="btn btn-primary" type="submit" id="cmdSave" name="cmdSave" value="<?php _e( 'Save', 'plgsoft' ) ?>" />
								<input class="btn btn-default" type="reset" id="cmdCancel" name="cmdCancel" value="<?php _e( 'Cancel', 'plgsoft' ) ?>" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
