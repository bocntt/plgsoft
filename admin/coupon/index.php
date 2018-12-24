<?php
require_once(wp_plugin_plgsoft_admin_dir . "/coupon/coupon_database.php");

global $table_name;
$coupon_database = new coupon_database();
$coupon_database->set_table_name($table_name);

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_coupon';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$coupon_id = isset($_REQUEST["coupon_id"]) ? trim($_REQUEST["coupon_id"]) : 0;
$is_validate = false;
$coupon_code_error = ''; $coupon_name_error = ''; $coupon_type_error = ''; $coupon_discount_error = '';
$coupon_total_error = ''; $uses_total_error = ''; $uses_customer_error = ''; $is_active_error = '';

$array_yes_no_property = get_array_yes_no_plgsoft_property();
$array_coupon_type = get_array_coupon_type();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_coupon', 'keyword' => $keyword));

if ($task == 'delete') {
	$coupon_database->delete_plgsoft_coupon($coupon_id);
	$task = "list";
	$msg_id = "The coupon is deleted successfully";
} elseif ($task == 'active') {
	$coupon_database->active_plgsoft_coupon($coupon_id);
	$task = "list";
	$msg_id = "The coupon is actived";
} elseif ($task == 'deactive') {
	$coupon_database->deactive_plgsoft_coupon($coupon_id);
	$task = "list";
	$msg_id = "The coupon is deactived";
} else {
	if ($is_save==0) {
		if ($coupon_id == 0) {
			$coupon_id       = isset($_POST["coupon_id"]) ? trim($_POST["coupon_id"]) : 0;
			$coupon_name     = isset($_POST["coupon_name"]) ? trim($_POST["coupon_name"]) : "";
			$coupon_code     = isset($_POST["coupon_code"]) ? trim($_POST["coupon_code"]) : "";
			$coupon_type     = isset($_POST["coupon_type"]) ? trim($_POST["coupon_type"]) : "";
			$coupon_discount = isset($_POST["coupon_discount"]) ? trim($_POST["coupon_discount"]) : 0;
			if (strlen($coupon_discount) == 0) $coupon_discount = 0;
			$coupon_total = isset($_POST["coupon_total"]) ? trim($_POST["coupon_total"]) : 0;
			if (strlen($coupon_total) == 0) $coupon_total = 0;
			$uses_total = isset($_POST["uses_total"]) ? trim($_POST["uses_total"]) : 0;
			if (strlen($uses_total) == 0) $uses_total = 0;
			$uses_customer = isset($_POST["uses_customer"]) ? trim($_POST["uses_customer"]) : 0;
			if (strlen($uses_customer) == 0) $uses_customer = 0;
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
		} else {
			$coupon_obj      = $coupon_database->get_plgsoft_coupon_by_coupon_id($coupon_id);
			$coupon_id       = $coupon_obj['coupon_id'];
			$coupon_name     = $coupon_obj['coupon_name'];
			$coupon_code     = $coupon_obj['coupon_code'];
			$coupon_type     = $coupon_obj['coupon_type'];
			$coupon_discount = $coupon_obj['coupon_discount'];
			$coupon_total    = $coupon_obj['coupon_total'];
			$uses_total      = $coupon_obj['uses_total'];
			$uses_customer   = $coupon_obj['uses_customer'];
			$is_active       = $coupon_obj['is_active'];
		}
	} else {
		$coupon_name = isset($_POST["coupon_name"]) ? trim($_POST["coupon_name"]) : "";
		$coupon_code = isset($_POST["coupon_code"]) ? trim($_POST["coupon_code"]) : "";
		$coupon_type = isset($_POST["coupon_type"]) ? trim($_POST["coupon_type"]) : "";
		$coupon_discount = isset($_POST["coupon_discount"]) ? trim($_POST["coupon_discount"]) : 0;
		if (strlen($coupon_discount) == 0) $coupon_discount = 0;
		$coupon_total = isset($_POST["coupon_total"]) ? trim($_POST["coupon_total"]) : 0;
		if (strlen($coupon_total) == 0) $coupon_total = 0;
		$uses_total = isset($_POST["uses_total"]) ? trim($_POST["uses_total"]) : 0;
		if (strlen($uses_total) == 0) $uses_total = 0;
		$uses_customer = isset($_POST["uses_customer"]) ? trim($_POST["uses_customer"]) : 0;
		if (strlen($uses_customer) == 0) $uses_customer = 0;
		$is_active = isset($_POST["is_active"]) ? 1 : 0;

		$check_exist = $coupon_database->check_exist_coupon_name($coupon_name, $coupon_id);
		if ((strlen($coupon_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($coupon_name) == 0) {
				$is_validate = false;
				$coupon_name_error = "Coupon Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$coupon_name_error = "Coupon Name is existed";
				}
			}
		}
		$check_exist_coupon_code = $coupon_database->check_exist_coupon_code($coupon_code, $coupon_id);
		if ((strlen($coupon_code) > 0) && !$check_exist_coupon_code && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($coupon_code) > 0) {
				if ($check_exist_coupon_code) {
					$is_validate = false;
					$coupon_code_error = "Coupon Code is existed";
				}
			} else {
				$is_validate = false;
				$coupon_code_error = "Coupon Code is empty";
			}
		}
		$check_coupon_discount = check_number_order_listing($coupon_discount);
		if ($check_coupon_discount && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_coupon_discount) {
				$is_validate = false;
				$coupon_discount_error = "Coupon Discount is not number";
			}
		}
		$check_coupon_total = check_number_order_listing($coupon_total);
		if ($check_coupon_total && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_coupon_total) {
				$is_validate = false;
				$coupon_total_error = "Coupon Total is not number";
			}
		}
		$check_uses_total = check_number_order_listing($uses_total);
		if ($check_uses_total && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_uses_total) {
				$is_validate = false;
				$uses_total_error = "Uses Total is not number";
			}
		}
		$check_uses_customer = check_number_order_listing($uses_customer);
		if ($check_uses_customer && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_uses_customer) {
				$is_validate = false;
				$uses_customer_error = "Uses Customer is not number";
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
		if ($is_validate) {
			$coupon_array = array();
			$coupon_array['coupon_name']     = $coupon_name;
			$coupon_array['coupon_code']     = $coupon_code;
			$coupon_array['coupon_type']     = $coupon_type;
			$coupon_array['coupon_discount'] = $coupon_discount;
			$coupon_array['coupon_total']    = $coupon_total;
			$coupon_array['uses_total']      = $uses_total;
			$coupon_array['uses_customer']   = $uses_customer;
			$coupon_array['is_active']       = $is_active;
			if ($coupon_id > 0) {
				$coupon_array['coupon_id'] = $coupon_id;
				$coupon_database->update_plgsoft_coupon($coupon_array);
				$task = "list";
				$msg_id = "The coupon is edited successfully";
			} else {
				$coupon_database->insert_plgsoft_coupon($coupon_array);
				$task = "list";
				$msg_id = "The coupon is added successfully";
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
	$total_coupon = $coupon_database->get_total_plgsoft_coupon($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_coupon = $coupon_database->get_list_plgsoft_coupon($array_keywords, $limit, $offset);
	$coupon_url = get_plgsoft_admin_url(array('page' => 'manage_coupon', 'task' => 'add'));
	?>
	<?php if ($total_coupon > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Coupon', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Coupon' ) ?></a>
							<a href="<?php echo esc_url( $coupon_url ); ?>"><?php _e( 'Add Coupon' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
								<input type="hidden" id="page" name="page" value="<?php echo esc_attr( $page ); ?>">
								<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
								<input type="hidden" id="task" name="task" value="<?php echo esc_attr( $task ); ?>">
								<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
								<input class="form-control" type="text" id="keyword" name="keyword" size="40" value="<?php echo esc_attr( $keyword ); ?>" />
								<input class="btn btn-default" type="submit" id="cmdSearch" name="cmdSearch" value="<?php _e( 'Search', 'plgsoft' ) ?>" />
							</form>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div class="plgsoft-sub-tab-content">
						<?php if (strlen($msg_id) > 0) { ?>
							<div class="message"><?php echo esc_html( $msg_id ); ?></div>
						<?php } ?>
						<table class="table table-striped table-hovered table-responsive sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Coupon Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Coupon Code', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Coupon Type', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Coupon Discount', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Coupon Total', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Uses Total', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_coupon as $coupon_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_coupon', 'coupon_id' => $coupon_item['coupon_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_coupon', 'coupon_id' => $coupon_item['coupon_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $coupon_item['coupon_id'] ); ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>"><?php echo esc_html( $coupon_item['coupon_name'] ); ?></a>
										</td>
										<td><?php echo esc_html( $coupon_item['coupon_code'] ); ?></td>
										<td><?php echo esc_html( $array_coupon_type[$coupon_item['coupon_type']] ); ?></td>
										<td class="text-right">
											<?php if ($coupon_item['coupon_type'] == 'P') { ?>
												<?php echo esc_html( $coupon_item['coupon_discount'] ); ?>%
											<?php } else { ?>
												$<?php echo esc_html( $coupon_item['coupon_discount'] ); ?>
											<?php } ?>
										</td>
										<td class="text-right">$<?php echo esc_html( $coupon_item['coupon_total'] ); ?></td>
										<td class="text-center">
											<?php
											if ($coupon_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_coupon', 'coupon_id' => $coupon_item['coupon_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_coupon', 'coupon_id' => $coupon_item['coupon_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($coupon_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-right"><?php echo esc_html( $coupon_item['uses_total'] ); ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_coupon, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any coupon', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Coupon', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $coupon_url ); ?>"><?php _e( 'Add Coupon', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
								<input type="hidden" id="page" name="page" value="<?php echo esc_attr( $page ); ?>">
								<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
								<input type="hidden" id="task" name="task" value="<?php echo esc_attr( $task ); ?>">
								<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
								<input class="form-control" type="text" id="keyword" name="keyword" size="40" value="<?php echo esc_attr( $keyword ); ?>" />
								<input class="btn btn-default" type="submit" id="cmdSearch" name="cmdSearch" value="Search" />
							</form>
						</div>
					</div>
					<div style="clear: both;"></div>
					<div class="plgsoft-sub-tab-content">
						<?php if (strlen($msg_id) > 0) { ?>
							<div class="message"><?php echo esc_html( $msg_id ); ?></div>
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
	$coupon_url = get_plgsoft_admin_url(array('page' => 'manage_coupon', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($coupon_id > 0) { ?>
			<h2><?php _e( 'Edit Coupon', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Coupon', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Coupon', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $coupon_url ); ?>"><?php _e( 'Add Coupon', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmCoupon" name="frmCoupon" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="coupon_id" name="coupon_id" value="<?php echo esc_attr( $coupon_id ); ?>">
						<?php if ($coupon_id > 0) { ?>
							<input type="hidden" id="task" name="task" value="edit">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } else { ?>
							<input type="hidden" id="task" name="task" value="add">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } ?>
						<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
						<div class="row">
							<label for="required"><?php _e( '* Required', 'plgsoft' ) ?></label>
						</div>
						<div class="row<?php echo (strlen($coupon_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="coupon_name"><?php _e( 'Coupon Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($coupon_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $coupon_name_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="coupon_name" name="coupon_name" size="70" value="<?php echo esc_attr( $coupon_name ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($coupon_code_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="coupon_code"><?php _e( 'Coupon Code', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($coupon_code_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $coupon_code_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="coupon_code" name="coupon_code" size="70" value="<?php echo esc_attr( $coupon_code ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($coupon_type_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="coupon_type"><?php _e( 'Coupon Type', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($coupon_type_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $coupon_type_error ); ?></label>
								<?php } ?>
								<select id="coupon_type" name="coupon_type" class="is_active form-control select">
									<?php foreach ($array_coupon_type as $key => $value) { ?>
										<?php if($key == $coupon_type) { ?>
											<option selected="selected" value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
										<?php } else { ?>
											<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($coupon_discount_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="coupon_discount"><?php _e( 'Coupon Discount', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($coupon_discount_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $coupon_discount_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="coupon_discount" name="coupon_discount" size="70" value="<?php echo esc_attr( $coupon_discount ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($coupon_total_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="coupon_total"><?php _e( 'Coupon Total', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($coupon_total_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $coupon_total_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="coupon_total" name="coupon_total" size="70" value="<?php echo esc_attr( $coupon_total ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($uses_total_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="uses_total"><?php _e( 'Uses Total', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($uses_total_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $uses_total_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="uses_total" name="uses_total" size="35" value="<?php echo esc_attr( $uses_total ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($uses_customer_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="uses_customer"><?php _e( 'Uses Customer', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($uses_customer_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $uses_customer_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="uses_customer" name="uses_customer" size="35" value="<?php echo esc_attr( $uses_customer ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($is_active_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="status"><?php _e( 'Status', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($is_active_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $is_active_error ); ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="is_active" id="is_active" <?php echo ($is_active == 1) ? 'checked="checked"' : ''; ?>>
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
