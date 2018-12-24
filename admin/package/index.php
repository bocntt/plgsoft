<?php
require_once(wp_plugin_plgsoft_admin_dir . "/package/package_database.php");
global $table_name;
$package_database = new package_database();
$package_database->set_table_name($table_name);

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_package';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$package_id = isset($_REQUEST["package_id"]) ? trim($_REQUEST["package_id"]) : "";
$is_validate = false;
$package_order_error = '';
$package_price_error = '';
$package_name_error = '';
$package_subtext_error = '';
$package_description_error = '';
$package_multiple_cats_error = '';
$package_multiple_images_error = '';
$package_image_error = '';
$package_expires_error = '';
$package_hidden_error = '';
$package_multiple_cats_amount_error = '';
$package_max_uploads_error = '';
$package_action_error = '';
$is_active_error = '';
$package_position_error = '';
$package_button_error = '';
$is_front_page_error = '';
$array_yes_no_property = get_array_yes_no_plgsoft_property();
$array_yes_no_text = get_array_yes_no_plgsoft_text();
$array_access_fields = get_array_access_fields();
$array_position = get_array_position();
$array_button = get_array_button();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_package', 'keyword' => $keyword));

if ($task == 'delete') {
	$package_database->delete_plgsoft_package($package_id);
	$task = "list";
	$msg_id = "The package is deleted successfully";
} elseif ($task == 'import_default_data') {
	$array_package[] = array('package_order' => '1',
						'package_price' => '0.00',
						'package_name' => 'Basic package',
						'package_subtext' => 'Business Name, Address, Logo, Short Description, list of services provided,
							choice of 3 business categories. Can only be used for 60 days, after which time listing will expire.',
						'package_description' => 'Business owner will receive an email 14 days before listing expires and has to login and
							renew listing before the 60 days by clicking on renew listing link or button.
							Business owner will be given choice to upgrade to a better listing package at that time.
							Emails will be sent out monthly by cron job explaining benefits of upgrading to a Standard business package
							and showing a list of all packages available to upgrade.',
						'package_multiple_cats' => '3',
						'package_multiple_images' => '1',
						'package_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
						'package_expires' => '60',
						'package_hidden' => 'no',
						'package_multiple_cats_amount' => '30',
						'package_max_uploads' => '30',
						'package_action' => '0',
						'package_position' => 'left',
						'package_button' => 'subscribe-for-free',
						'is_front_page' => '1');
	$array_package[] = array('package_order' => '2',
						'package_price' => '9.95',
						'package_name' => 'Standard Business',
						'package_subtext' => 'Business Name, Address, Logo, Google Map, Short Description, Long Description, Main photo,
							additional photos, Website address link, list of services provided, choice of 3 business categories.',
						'package_description' => 'Emails will be sent out quarterly by cron job explaining benefits of upgrading to a
							Featured Business package and showing a list of all packages available to upgrade.',
						'package_multiple_cats' => '3',
						'package_multiple_images' => '1',
						'package_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
						'package_expires' => '30',
						'package_hidden' => 'no',
						'package_multiple_cats_amount' => '30',
						'package_max_uploads' => '30',
						'package_action' => '0',
						'package_position' => 'left',
						'package_button' => 'sign-up-today',
						'is_front_page' => '1');
	$array_package[] = array('package_order' => '3',
						'package_price' => '29.95',
						'package_name' => 'Featured Business',
						'package_subtext' => 'Listing Includes all items of Standard business: Business Name, Address, Logo, Google Map,
							Short Description, Long Description, Main photo, additional photos, Website address link, list of services provided,
							choice of 5 business categories.',
						'package_description' => 'Plus includes: Videos uploading, Rotating featured listing on all categories selected
							in category pages, list pages and in any services searched as well as social sharing on business listing.<br>
							Emails will be sent out quarterly by cron job explaining benefits of upgrading to a Premium featured package
							and showing a list of all packages available to upgrade.',
						'package_multiple_cats' => '5',
						'package_multiple_images' => '1',
						'package_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
						'package_expires' => '30',
						'package_hidden' => 'no',
						'package_multiple_cats_amount' => '30',
						'package_max_uploads' => '30',
						'package_action' => '0',
						'package_position' => 'left',
						'package_button' => 'upgrade-today',
						'is_front_page' => '1');
	$array_package[] = array('package_order' => '4',
						'package_price' => '99.95',
						'package_name' => 'Premium Featured',
						'package_subtext' => 'Listing Includes: Business Name, Address, Logo, Google Map, Short Description, Long Description,
							videos uploading on listing, Main photo, additional photos, Website address link, list of services provided,
							choice of 5 business categories.',
						'package_description' => 'Plus includes: Rotating featured listing on all categories selected in category pages,
							list pages and in any services searched, social sharing on business listing, featured placement on home page
							of website for your city, placement in monthly newsletters to consumers, placement on plg soft social media monthly.<br>
							Emails will be sent out quarterly by cron job explaining benefits of upgrading to a Get Noticed package.',
						'package_multiple_cats' => '5',
						'package_multiple_images' => '1',
						'package_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
						'package_expires' => '30',
						'package_hidden' => 'no',
						'package_multiple_cats_amount' => '30',
						'package_max_uploads' => '30',
						'package_action' => '0',
						'package_position' => 'left',
						'package_button' => 'upgrade-today',
						'is_front_page' => '1');

	$package_array = array();
	for($i=0; $i<sizeof($array_package); $i++) {
		$package_array['package_order'] = $i;
		$package_array['package_price'] = $array_package[$i]['package_price'];
		$package_array['package_name'] = $array_package[$i]['package_name'];
		$package_array['package_subtext'] = $array_package[$i]['package_subtext'];
		$package_array['package_description'] = $array_package[$i]['package_description'];
		$package_array['package_multiple_cats'] = $array_package[$i]['package_multiple_cats'];
		$package_array['package_multiple_images'] = $array_package[$i]['package_multiple_images'];
		$package_array['package_image'] = $array_package[$i]['package_image'];
		$package_array['package_expires'] = $array_package[$i]['package_expires'];
		$package_array['package_hidden'] = $array_package[$i]['package_hidden'];
		$package_array['package_multiple_cats_amount'] = $array_package[$i]['package_multiple_cats_amount'];
		$package_array['package_max_uploads'] = $array_package[$i]['package_max_uploads'];
		$package_array['package_action'] = $array_package[$i]['package_action'];
		$package_array['package_position'] = $array_package[$i]['package_position'];
		$package_array['package_button'] = $array_package[$i]['package_button'];
		$package_array['is_front_page'] = $array_package[$i]['is_front_page'];
		$package_array['is_active'] = 1;
		$package_database->insert_plgsoft_package($package_array);
	}
	$task = "list";
	$msg_id = "These package are imported successfully";
} elseif ($task == 'active') {
	$package_database->active_plgsoft_package($package_id);
	$task = "list";
	$msg_id = "The package is actived";
} elseif ($task == 'deactive') {
	$package_database->deactive_plgsoft_package($package_id);
	$task = "list";
	$msg_id = "The package is deactived";
} else {
	if ($is_save==0) {
		if (strlen($package_id)==0) {
			$package_id                   = isset($_POST["package_id"]) ? trim($_POST["package_id"]) : "";
			$package_order                = isset($_POST["package_order"]) ? trim($_POST["package_order"]) : 0;
			$package_price                = isset($_POST["package_price"]) ? trim($_POST["package_price"]) : 0;
			$package_name                 = isset($_POST["package_name"]) ? trim($_POST["package_name"]) : "";
			$package_subtext              = isset($_POST["package_subtext"]) ? trim($_POST["package_subtext"]) : "";
			$package_description          = isset($_POST["package_description"]) ? trim($_POST["package_description"]) : "";
			$package_multiple_cats        = isset($_POST["package_multiple_cats"]) ? trim($_POST["package_multiple_cats"]) : "";
			$package_multiple_images      = isset($_POST["package_multiple_images"]) ? trim($_POST["package_multiple_images"]) : "";
			$package_image                = isset($_POST["package_image"]) ? trim($_POST["package_image"]) : "";
			$package_expires              = isset($_POST["package_expires"]) ? trim($_POST["package_expires"]) : 0;
			$package_hidden               = isset($_POST["package_hidden"]) ? trim($_POST["package_hidden"]) : "";
			$package_multiple_cats_amount = isset($_POST["package_multiple_cats_amount"]) ? trim($_POST["package_multiple_cats_amount"]) : 0;
			$package_max_uploads          = isset($_POST["package_max_uploads"]) ? trim($_POST["package_max_uploads"]) : 0;
			$package_action               = isset($_POST["package_action"]) ? trim($_POST["package_action"]) : 0;
			$package_access_fields        = isset($_POST["package_access_fields"]) ? $_POST["package_access_fields"] : array();
			$package_position             = isset($_POST["package_position"]) ? $_POST["package_position"] : "";
			$package_button               = isset($_POST["package_button"]) ? $_POST["package_button"] : "";
			$is_front_page                = isset($_POST["is_front_page"]) ? 1 : 0;
			$is_active                    = isset($_POST["is_active"]) ? 1 : 0;
		} else {
			$package_obj = $package_database->get_plgsoft_package_by_package_id($package_id);
			$package_id                   = $package_obj['package_id'];
			$package_order                = $package_obj['package_order'];
			$package_price                = $package_obj['package_price'];
			$package_name                 = $package_obj['package_name'];
			$package_subtext              = $package_obj['package_subtext'];
			$package_description          = $package_obj['package_description'];
			$package_multiple_cats        = $package_obj['package_multiple_cats'];
			$package_multiple_images      = $package_obj['package_multiple_images'];
			$package_image                = $package_obj['package_image'];
			$package_expires              = $package_obj['package_expires'];
			$package_hidden               = $package_obj['package_hidden'];
			$package_multiple_cats_amount = $package_obj['package_multiple_cats_amount'];
			$package_max_uploads          = $package_obj['package_max_uploads'];
			$package_action               = $package_obj['package_action'];
			$package_access_fields        = $package_obj['package_access_fields'];
			$package_position             = $package_obj['package_position'];
			$package_button               = $package_obj['package_button'];
			$is_front_page                = $package_obj['is_front_page'];
			$is_active                    = $package_obj['is_active'];
			if (strlen($package_access_fields) > 0) {
				$package_access_fields = explode(",", $package_access_fields);
			} else {
				$package_access_fields = array();
			}
		}
	} else {
		$package_order                = isset($_POST["package_order"]) ? trim($_POST["package_order"]) : 0;
		$package_price                = isset($_POST["package_price"]) ? trim($_POST["package_price"]) : 0;
		$package_name                 = isset($_POST["package_name"]) ? trim($_POST["package_name"]) : "";
		$package_subtext              = isset($_POST["package_subtext"]) ? trim($_POST["package_subtext"]) : "";
		$package_description          = isset($_POST["package_description"]) ? trim($_POST["package_description"]) : "";
		$package_multiple_cats        = isset($_POST["package_multiple_cats"]) ? trim($_POST["package_multiple_cats"]) : "";
		$package_multiple_images      = isset($_POST["package_multiple_images"]) ? trim($_POST["package_multiple_images"]) : "";
		$package_image                = isset($_POST["package_image"]) ? trim($_POST["package_image"]) : "";
		$package_expires              = isset($_POST["package_expires"]) ? trim($_POST["package_expires"]) : 0;
		$package_hidden               = isset($_POST["package_hidden"]) ? trim($_POST["package_hidden"]) : "";
		$package_multiple_cats_amount = isset($_POST["package_multiple_cats_amount"]) ? trim($_POST["package_multiple_cats_amount"]) : 0;
		$package_max_uploads          = isset($_POST["package_max_uploads"]) ? trim($_POST["package_max_uploads"]) : 0;
		$package_action               = isset($_POST["package_action"]) ? trim($_POST["package_action"]) : 0;
		$package_access_fields        = isset($_POST["package_access_fields"]) ? $_POST["package_access_fields"] : array();
		$package_position             = isset($_POST["package_position"]) ? $_POST["package_position"] : "";
		$package_button               = isset($_POST["package_button"]) ? $_POST["package_button"] : "";
		$is_front_page                = isset($_POST["is_front_page"]) ? 1 : 0;
		$is_active                    = isset($_POST["is_active"]) ? 1 : 0;

		$check_exist = $package_database->check_exist_package_name($package_name, $package_id);
		if ((strlen($package_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($package_name) == 0) {
				$is_validate = false;
				$package_name_error = "Package Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$package_name_error = "Package Name is existed";
				}
			}
		}

		$check_package_order = check_number_order_listing($package_order);
		if ($check_package_order && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_package_order) {
				$is_validate = false;
				$package_order_error = "Order Listing is not number";
			}
		}

		$check_package_price = check_number_price($package_price);
		if ($check_package_price && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_package_price) {
				$is_validate = false;
				$package_price_error = "Price is not number";
			}
		}

		$check_package_multiple_cats = check_number_order_listing($package_multiple_cats);
		if ($check_package_multiple_cats && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_package_multiple_cats) {
				$is_validate = false;
				$package_multiple_cats_error = "Multiple Categories is not number";
			}
		}

		$check_package_multiple_images = check_number_order_listing($package_multiple_images);
		if ($check_package_multiple_images && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_package_multiple_images) {
				$is_validate = false;
				$package_multiple_images_error = "Multiple Images is not number";
			}
		}

		$check_package_expires = check_number_order_listing($package_expires);
		if ($check_package_expires && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_package_expires) {
				$is_validate = false;
				$package_expires_error = "Expires is not number";
			}
		}

		$check_package_multiple_cats_amount = check_number_order_listing($package_multiple_cats_amount);
		if ($check_package_multiple_cats_amount && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_package_multiple_cats_amount) {
				$is_validate = false;
				$package_multiple_cats_amount_error = "Multiple Categories Amount is not number";
			}
		}

		$check_package_max_uploads = check_number_order_listing($package_max_uploads);
		if ($check_package_max_uploads && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_package_max_uploads) {
				$is_validate = false;
				$package_max_uploads_error = "Max Uploads is not number";
			}
		}

		$check_package_action = check_number_order_listing($package_action);
		if ($check_package_action && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_package_action) {
				$is_validate = false;
				$package_action_error = "Package Action is not number";
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
		if ((strlen($package_position) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($package_position) == 0) {
				$is_validate = false;
				$package_position_error = "Position is empty";
			}
		}
		if ((strlen($package_button) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($package_button) == 0) {
				$is_validate = false;
				$package_button_error = "Button is empty";
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
			$package_array = array();
			$package_array['package_order'] = $package_order;
			$package_array['package_price'] = $package_price;
			$package_array['package_name'] = $package_name;
			$package_array['package_subtext'] = $package_subtext;
			$package_array['package_description'] = $package_description;
			$package_array['package_multiple_cats'] = $package_multiple_cats;
			$package_array['package_multiple_images'] = $package_multiple_images;
			$package_array['package_image'] = $package_image;
			$package_array['package_expires'] = $package_expires;
			$package_array['package_hidden'] = $package_hidden;
			$package_array['package_multiple_cats_amount'] = $package_multiple_cats_amount;
			$package_array['package_max_uploads'] = $package_max_uploads;
			$package_array['package_action'] = $package_action;
			$package_access_fields = implode(",", $package_access_fields);
			$package_array['package_access_fields'] = $package_access_fields;
			$package_array['package_position'] = $package_position;
			$package_array['package_button'] = $package_button;
			$package_array['is_front_page'] = $is_front_page;
			$package_array['is_active'] = $is_active;
			if ($package_id > 0) {
				$package_array['package_id'] = $package_id;
				$package_database->update_plgsoft_package($package_array);
				$task = "list";
				$msg_id = "The package is edited successfully";
			} else {
				$package_database->insert_plgsoft_package($package_array);
				$task = "list";
				$msg_id = "The package is added successfully";
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
	$total_package = $package_database->get_total_plgsoft_package($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;
	$list_package = $package_database->get_list_plgsoft_package($array_keywords, $limit, $offset);
	$package_url = get_plgsoft_admin_url(array('page' => 'manage_package', 'task' => 'add'));
	?>
	<?php if ($total_package > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Package', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Package', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $package_url ); ?>"><?php _e( 'Add Package', 'plgsoft' ) ?></a>
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
						<div style="clear: both;"></div>
					</div>
					<div class="plgsoft-sub-tab-content">
						<?php if (strlen($msg_id) > 0) { ?>
							<div class="message"><?php echo $msg_id; ?></div>
						<?php } ?>
						<table class="table sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Package Name', 'plgsoft' ) ?></th>
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
								<?php foreach ($list_package as $package_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_package', 'package_id' => $package_item['package_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_package', 'package_id' => $package_item['package_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $package_item['package_id']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $package_item['package_name']; ?>
											</a>
										</td>
										<td class="text-right">$<?php echo $package_item['package_price']; ?></td>
										<td class="text-center">
											<?php
											if ($package_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_package', 'package_id' => $package_item['package_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_package', 'package_id' => $package_item['package_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($package_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center"><?php echo $array_position[$package_item['package_position']]; ?></td>
										<td class="text-center"><?php echo $array_button[$package_item['package_button']]; ?></td>
										<td class="text-center"><?php echo $array_yes_no_property[$package_item['is_front_page']]; ?></td>
										<td class="text-center"><?php echo $package_item['package_order']; ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_package, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any package', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo $manage_list_url; ?>"><?php _e( 'Manage Package', 'plgsoft' ) ?></a>
							<a href="<?php echo $package_url; ?>"><?php _e( 'Add Package', 'plgsoft' ) ?></a>
							<?php $package_import_data_url = get_plgsoft_admin_url(array('page' => 'manage_package', 'task' => 'import_default_data')); ?>
							<a style="padding-left: 10px;" href="<?php echo esc_url( $package_import_data_url ); ?>"><?php _e( 'Import Default Data', 'plgsoft' ) ?></a>
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
	$package_url = get_plgsoft_admin_url(array('page' => 'manage_package', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if (strlen($package_id) > 0) { ?>
			<h2><?php _e( 'Edit Package', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Package', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo $manage_list_url; ?>"><?php _e( 'Manage Package', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo $package_url; ?>"><?php _e( 'Add Package', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmPackage" name="frmPackage" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="package_id" name="package_id" value="<?php echo $package_id; ?>">
						<?php if (strlen($package_id) > 0) { ?>
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
						<div class="row<?php echo (strlen($package_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_name"><?php _e( 'Package Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_name" name="package_name" size="70" value="<?php echo esc_attr($package_name); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($package_order_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_order"><?php _e( 'Order Listing', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_order_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_order_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_order" name="package_order" size="35" value="<?php echo esc_attr( $package_order ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($package_price_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_price"><?php _e( 'Price', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_price_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_price_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_price" name="package_price" size="70" value="<?php echo esc_attr($package_price); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="package_subtext"><?php _e( 'Sub Text', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<textarea class="form-control textarea" id="package_subtext" name="package_subtext" rows="5" cols="70"><?php echo esc_html($package_subtext); ?></textarea>
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="package_description"><?php _e( 'Description', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<textarea class="form-control textarea" id="package_description" name="package_description" rows="5" cols="70"><?php echo esc_html($package_description); ?></textarea>
							</div>
						</div>
						<div class="row<?php echo (strlen($package_multiple_cats_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_multiple_cats"><?php _e( 'Multiple Categories', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_multiple_cats_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_multiple_cats_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_multiple_cats" name="package_multiple_cats" size="70" value="<?php echo esc_attr($package_multiple_cats); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($package_multiple_images_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_multiple_images"><?php _e( 'Multiple Images', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_multiple_images_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_multiple_images_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_multiple_images" name="package_multiple_images" size="35" value="<?php echo esc_attr( $package_multiple_images ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($package_image_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_images"><?php _e( 'Image', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_image_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_image_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_image" name="package_image" size="70" value="<?php echo esc_attr($package_image); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($package_expires_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_expires"><?php _e( 'Expires', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_expires_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_expires_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_expires" name="package_expires" size="70" value="<?php echo esc_attr($package_expires); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($package_hidden_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_hidden"><?php _e( 'Hidden', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_hidden_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_hidden_error; ?></label>
								<?php } ?>
								<select id="package_hidden" name="package_hidden" class="package_hidden form-control select">
									<?php foreach ($array_yes_no_text as $key => $value) { ?>
										<?php if($key == $package_hidden) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($package_multiple_cats_amount_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_multiple_cat_amount"><?php _e( 'Multiple Categories Amount', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_multiple_cats_amount_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_multiple_cats_amount_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_multiple_cats_amount" name="package_multiple_cats_amount" size="70" value="<?php echo esc_attr($package_multiple_cats_amount); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($package_max_uploads_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_max_uploads"><?php _e( 'Max Uploads', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_max_uploads_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_max_uploads_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_max_uploads" name="package_max_uploads" size="70" value="<?php echo esc_attr($package_max_uploads); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($package_action_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_action"><?php _e( 'Package Action', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_action_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_action_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="package_action" name="package_action" size="70" value="<?php echo esc_attr($package_action); ?>" />
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
							<label class="col-2" for="package_access_fields"><?php _e( 'Access Fields', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<div class="row">
									<?php $index_access_field = 0; ?>
									<?php foreach ($array_access_fields as $key_access_field => $value_access_field) { ?>
										<?php $index_access_field++; ?>
										<div class="col-4" style="/*float: left; width: 33%;*/">
											<input type="checkbox" id="package_access_fields<?php echo $key_access_field; ?>" name="package_access_fields[]"
												value="<?php echo $key_access_field; ?>"
												<?php if ((sizeof($package_access_fields) > 0) && in_array($key_access_field, $package_access_fields)) { ?> checked="checked" <?php } ?> />
											<label><?php echo stripslashes($value_access_field); ?></label>
										</div>
										<?php if ($index_access_field % 3 == 0) { ?><div style="clear: both;"></div><?php } ?>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="row<?php echo (strlen($package_position_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_position"><?php _e( 'Position', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_position_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_position_error; ?></label>
								<?php } ?>
								<select id="package_position" name="package_position" class="package_position form-control select">
									<?php foreach ($array_position as $key => $value) { ?>
										<?php if($key == $package_position) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($package_button_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_button"><?php _e( 'Button', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_button_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_button_error; ?></label>
								<?php } ?>
								<select id="package_button" name="package_button" class="package_button form-control select">
									<?php foreach ($array_button as $key => $value) { ?>
										<?php if($key == $package_button) { ?>
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
