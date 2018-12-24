<?php
require_once(wp_plugin_plgsoft_admin_dir . "/fields/fields_database.php");
global $table_name;
$fields_database = new fields_database();
$fields_database->set_table_name($table_name);

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_fields';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$field_key = isset($_REQUEST["field_key"]) ? trim($_REQUEST["field_key"]) : "";
$field_key = get_plgsoft_code($field_key);
$field_business_type = isset($_REQUEST["field_business_type"]) ? trim($_REQUEST["field_business_type"]) : "";
$field_option_type = isset($_REQUEST["field_option_type"]) ? trim($_REQUEST["field_option_type"]) : "";
$field_option_value = isset($_REQUEST["field_option_value"]) ? trim($_REQUEST["field_option_value"]) : "";
$field_type = isset($_REQUEST["field_type"]) ? trim($_REQUEST["field_type"]) : "";
$is_validate = false;
$field_key_error = ''; $field_name_error = ''; $string_category_id_error = ''; $field_business_type_error = '';
$field_option_type_error = ''; $field_option_value_error = '';
$field_type_error = ''; $is_active_error = ''; $field_icon_error = ''; $order_listing_error = '';
$array_yes_no_property = get_array_yes_no_plgsoft_property();
$array_field_type = get_array_plgsoft_field_type();
$array_field_option_type = get_array_plgsoft_field_option_type();
$array_field_business_type = get_array_plgsoft_field_business_type();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_fields', 'keyword' => $keyword));

if ($task == 'delete') {
	$field_key = get_plgsoft_code($field_key);
	$fields_database->delete_plgsoft_fields($field_key);
	$task = "list";
	$msg_id = "The field is deleted successfully";
} elseif ($task == 'active') {
	$field_key = get_plgsoft_code($field_key);
	$fields_database->active_plgsoft_fields($field_key);
	$task = "list";
	$msg_id = "The field is actived";
} elseif ($task == 'deactive') {
	$field_key = get_plgsoft_code($field_key);
	$fields_database->deactive_plgsoft_fields($field_key);
	$task = "list";
	$msg_id = "The field is deactived";
} else {
	if ($is_save==0) {
		if (strlen($field_key)==0) {
			$field_key = isset($_POST["field_key"]) ? trim($_POST["field_key"]) : "";
			$field_key = get_plgsoft_code($field_key);
			$field_name = isset($_POST["field_name"]) ? trim($_POST["field_name"]) : "";
			$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
			$field_description = isset($_POST["field_description"]) ? trim($_POST["field_description"]) : "";
			$field_placeholder = isset($_POST["field_placeholder"]) ? trim($_POST["field_placeholder"]) : "";
			$field_type = isset($_POST["field_type"]) ? trim($_POST["field_type"]) : "";
			$field_business_type = isset($_POST["field_business_type"]) ? trim($_POST["field_business_type"]) : "";
			$field_option_type = isset($_POST["field_option_type"]) ? trim($_POST["field_option_type"]) : "";
			$field_option_value = isset($_POST["field_option_value"]) ? trim($_POST["field_option_value"]) : "";
			$string_category_id = isset($_POST["string_category_id"]) ? $_POST["string_category_id"] : array();
		} else {
			$field_obj = $fields_database->get_plgsoft_fields_by_field_key($field_key);
			$field_key = $field_obj['field_key'];
			$field_key = get_plgsoft_code($field_key);
			$field_name = $field_obj['field_name'];
			$order_listing = $field_obj['order_listing'];
			$is_active = $field_obj['is_active'];
			$field_description = $field_obj['field_description'];
			$field_placeholder = $field_obj['field_placeholder'];
			$field_type = $field_obj['field_type'];
			$field_business_type = $field_obj['field_business_type'];
			$field_option_type = $field_obj['field_option_type'];
			$field_option_value = $field_obj['field_option_value'];
			$string_category_id = $field_obj['string_category_id'];
			$string_category_id = explode(",", $string_category_id);
		}
	} else {
		$field_key = isset($_POST["field_key"]) ? trim($_POST["field_key"]) : "";
		$field_key = get_plgsoft_code($field_key);
		$field_name = isset($_POST["field_name"]) ? trim($_POST["field_name"]) : "";
		$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
		$is_active = isset($_POST["is_active"]) ? 1 : 0;
		$field_description = isset($_POST["field_description"]) ? trim($_POST["field_description"]) : "";
		$field_placeholder = isset($_POST["field_placeholder"]) ? trim($_POST["field_placeholder"]) : "";
		$field_type = isset($_POST["field_type"]) ? trim($_POST["field_type"]) : "";
		$field_business_type = isset($_POST["field_business_type"]) ? trim($_POST["field_business_type"]) : "";
		$field_option_type = isset($_POST["field_option_type"]) ? trim($_POST["field_option_type"]) : "";
		$field_option_value = isset($_POST["field_option_value"]) ? trim($_POST["field_option_value"]) : "";
		$string_category_id = isset($_POST["string_category_id"]) ? $_POST["string_category_id"] : array();

		if (strlen($field_key) > 0) {
			$is_validate = true;
		} else {
			if (strlen($field_key) == 0) {
				$is_validate = false;
				$field_key_error = "Field Key is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$field_key_error = "Field Key is existed";
				}
			}
		}
		$check_exist = $fields_database->check_exist_field_name($field_name, $field_key, $field_business_type);
		if ((strlen($field_name) > 0) && !$check_exist && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($field_name) == 0) {
				$is_validate = false;
				$field_name_error = "Field Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$field_name_error = "Field Name is existed";
				}
			}
		}
		if ((strlen($field_type) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($field_type) == 0) {
				$is_validate = false;
				$field_type_error = "Field Type is empty";
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
		if ((strlen($field_business_type) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($field_business_type) == 0) {
				$is_validate = false;
				$field_business_type_error = "Business Type is empty";
			}
		}
		if (isset($field_option_type) && ($field_option_type == 'manual')) {
			if ((strlen($field_option_value) > 0) && $is_validate) {
				$is_validate = true;
			} else {
				if (strlen($field_option_value) == 0) {
					$is_validate = false;
					$field_option_value_error = "Field Option Value is empty";
				}
			}
		}
		$check_order_listing = check_number_order_listing($order_listing);
		if ($check_order_listing && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_order_listing) {
				$is_validate = false;
				$order_listing_error = "Order Listing is not number";
			}
		}
		if ($is_validate) {
			$field_array = array();
			$field_key = get_plgsoft_code($field_key);
			$field_array['field_key'] = $field_key;
			$field_array['field_name'] = $field_name;
			$field_array['field_type'] = $field_type;
			$field_array['field_business_type'] = $field_business_type;
			$field_array['field_option_type'] = $field_option_type;
			$field_array['field_option_value'] = $field_option_value;
			$field_array['order_listing'] = $order_listing;
			$field_array['is_active'] = $is_active;
			if (!isset($field_description) || (isset($field_description) && (strlen($field_description) == 0))) $field_description = $field_name;
			if (!isset($field_placeholder) || (isset($field_placeholder) && (strlen($field_placeholder) == 0))) $field_placeholder = $field_name;
			$field_array['field_description'] = $field_description;
			$field_array['field_placeholder'] = $field_placeholder;
			$string_category_id = implode(",", $string_category_id);
			$field_array['string_category_id'] = $string_category_id;

			$check_exist_field_key = $fields_database->check_exist_field_key($field_key);
			if ((strlen($field_key) > 0) && $check_exist_field_key) {
				$field_array['field_key'] = strtolower($field_key);
				$fields_database->update_plgsoft_fields($field_array);
				$task = "list";
				$msg_id = "The field is edited successfully";
			} else {
				if (!$check_exist_field_key) {
					$fields_database->insert_plgsoft_fields($field_array);
				}
				$task = "list";
				$msg_id = "The field is added successfully";
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
	$total_fields = $fields_database->get_total_plgsoft_fields($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;
	$list_fields = $fields_database->get_list_plgsoft_fields($array_keywords, $limit, $offset);
	$field_url = get_plgsoft_admin_url(array('page' => 'manage_fields', 'task' => 'add'));
	?>
	<?php if ($total_fields > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Fields', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Field', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $field_url ); ?>"><?php _e( 'Add Field', 'plgsoft' ) ?></a>
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
									<th scope="col"><?php _e( 'Field Key', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Field Name', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Field Type', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Field Business Type', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_fields as $field_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_fields', 'field_key' => $field_item['field_key'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_fields', 'field_key' => $field_item['field_key'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $field_item['field_key']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>"><?php echo $field_item['field_name']; ?></a>
										</td>
										<td class="text-center">
											<?php
											if ($field_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_fields', 'field_key' => $field_item['field_key'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_fields', 'field_key' => $field_item['field_key'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($field_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center">
											<?php echo $array_field_type[$field_item['field_type']]; ?>
										</td>
										<td class="text-center">
											<?php echo $array_field_business_type[$field_item['field_business_type']]; ?>
										</td>
										<td class="text-center"><?php echo $field_item['order_listing']; ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_fields, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any field', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Field', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $field_url ); ?>"><?php _e( 'Add Field', 'plgsoft' ) ?></a>
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
	$field_url = get_plgsoft_admin_url(array('page' => 'manage_fields', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if (strlen($field_key) > 0) { ?>
			<h2><?php _e( 'Edit Field', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Field', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Field', 'plgsoft' ) ?></a>
					<a href="<?php echo esc_url( $field_url ); ?>"><?php _e( 'Add Field', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmField" name="frmField" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="field_key" name="field_key" value="<?php echo $field_key; ?>">
						<?php if (strlen($field_key) > 0) { ?>
							<input type="hidden" id="task" name="task" value="edit">
							<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
						<?php } else { ?>
							<input type="hidden" id="task" name="task" value="add">
							<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
						<?php } ?>
						<input type="hidden" id="table_name" name="table_name" value="<?php echo $table_name; ?>">
						<script>
							function onchange_field_type(field_type) {
								if (field_type == 'select') {
									$("#field_option_type_container").show();
								} else {
									$("#field_option_type_container").hide();
								}
							}
							function onchange_field_option_type(field_option_type) {
								if (field_option_type == 'manual') {
									$("#field_option_value_container").show();
								} else {
									$("#field_option_value_container").hide();
								}
							}
						</script>
						<div class="row">
							<label for="required"><?php _e( '* Required', 'plgsoft' ) ?></label>
						</div>
						<div class="row<?php echo (strlen($field_key_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="field_key"><?php _e( 'Field Key', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($field_key_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $field_key_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="field_key" name="field_key" size="70" value="<?php echo esc_attr($field_key); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($field_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="field_name"><?php _e( 'Field Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($field_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $field_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="field_name" name="field_name" size="70" value="<?php echo esc_attr($field_name); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($order_listing_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="order_listing"><?php _e( 'Order Listing', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($order_listing_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $order_listing_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="order_listing" name="order_listing" size="35" value="<?php echo esc_attr( $order_listing ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($string_category_id_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="category_id"><?php _e( 'Business Category', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($string_category_id_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $string_category_id_error; ?></label>
								<?php } ?>
								<?php $business_categories = categories_checkbox_list(); ?>
								<?php $index = 0; ?>
								<?php foreach ($business_categories as $category) { ?>
									<div style="float: left; width: 25%;">
										<div<?php if ($category->parent > 0) { ?> style="padding-left: 30px;"<?php } ?>>
											<?php $check_category_id = ""; ?>
											<?php if (isset($string_category_id) && (sizeof($string_category_id) > 0) && in_array($category->term_id, $string_category_id)) { ?>
												<?php $check_category_id = 'checked="checked"'; ?>
											<?php } ?>
											<input class="form-control" <?php echo $check_category_id; ?> type="checkbox" id="string_category_id<?php echo $category->term_id; ?>" name="string_category_id[]" value="<?php echo $category->term_id; ?>"> <?php echo $category->name; ?>
										</div>
									</div>
									<?php $index++ ?>
									<?php if (($index > 0) && ($index % 4 == 0)) { ?>
										<div style="clear: both;"></div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
						<div class="row<?php echo (strlen($field_business_type_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="field_business_type"><?php _e( 'Business Type', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($field_business_type_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $field_business_type_error; ?></label>
								<?php } ?>
								<select style="width: 225px;" id="field_business_type" name="field_business_type" class="is_active form-control select">
									<option value=""><?php _e( 'Select Business Type', 'plgsoft' ) ?></option>
									<?php foreach ($array_field_business_type as $key => $value) { ?>
										<?php if($key == $field_business_type) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($field_type_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="field_type"><?php _e( 'Field Type', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($field_type_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $field_type_error; ?></label>
								<?php } ?>
								<select style="width: 225px;" id="field_type" name="field_type" class="is_active form-control select" onchange="javascript:onchange_field_type(this.value);">
									<option value=""><?php _e( 'Select Field Type', 'plgsoft' ) ?></option>
									<?php foreach ($array_field_type as $key => $value) { ?>
										<?php if($key == $field_type) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<?php
						$field_option_type_style = 'style="display: none;"';
						$field_option_value_style = 'style="display: none;"';
						if (isset($field_type) && ($field_type == 'select')) {
							$field_option_type_style = '';
						}
						if (isset($field_option_type) && ($field_option_type == 'manual')) {
							$field_option_value_style = '';
						}
						?>
						<div class="row<?php echo (strlen($field_option_type_error) > 0) ? ' has-error' : ''; ?>" id="field_option_type_container" <?php echo $field_option_type_style; ?>>
							<label class="col-2" for="field_option_type"><?php _e( 'Field Option Type', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($field_option_type_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $field_option_type_error; ?></label>
								<?php } ?>
								<select style="width: 225px;" id="field_option_type" name="field_option_type" class="is_active form-control select" onchange="javascript:onchange_field_option_type(this.value);">
									<?php foreach ($array_field_option_type as $key => $value) { ?>
										<?php if($key == $field_option_type) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($field_option_value_error) > 0) ? ' has-error' : ''; ?>" id="field_option_value_container" <?php echo $field_option_value_style; ?>>
							<label class="col-2" for="field_option_value"><?php _e( 'Field Option Value', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($field_option_value_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $field_option_value_error; ?></label>
								<?php } ?>
								<div>value1=>text1,value2=>text2</div>
								<textarea class="form-control textarea" id="field_option_value" name="field_option_value" rows="5" cols="70"><?php echo esc_html($field_option_value); ?></textarea>
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
							<label class="col-2" for="field_description"><?php _e( 'Field Description', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<input class="form-control" type="text" id="field_description" name="field_description" size="70" value="<?php echo esc_attr($field_description); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="field_placeholder"><?php _e( 'Field Placeholder', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<textarea class="form-control textarea" id="field_placeholder" name="field_placeholder" rows="5" cols="70"><?php echo esc_html($field_placeholder); ?></textarea>
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
