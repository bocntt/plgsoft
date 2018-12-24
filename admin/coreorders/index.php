<?php
require_once(wp_plugin_plgsoft_admin_dir . "/coreorders/coreorders_database.php");

global $table_name;
$coreorders_database = new coreorders_database();
$coreorders_database->set_table_name($table_name);

$array_quotes_status = get_array_quotes_status();
$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_coreorders';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$autoid = isset($_REQUEST["autoid"]) ? trim($_REQUEST["autoid"]) : 0;
$is_validate = false;
$order_date_error = ''; $order_ip_error = ''; $order_time_error = '';
$order_data_error = ''; $order_items_error = '';

$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_coreorders', 'keyword' => $keyword));

if ($task == 'delete') {
	$coreorders_database->delete_plgsoft_coreorders($autoid);
	$task = "list";
	$msg_id = "The core orders is deleted successfully";
} else {
	if ($is_save==0) {
		if ($autoid == 0) {
			$autoid          = isset($_POST["autoid"]) ? trim($_POST["autoid"]) : 0;
			$order_ip        = isset($_POST["order_ip"]) ? trim($_POST["order_ip"]) : "";
			$order_date      = isset($_POST["order_date"]) ? trim($_POST["order_date"]) : "";
			$order_time      = isset($_POST["order_time"]) ? trim($_POST["order_time"]) : "";
			$order_data      = isset($_POST["order_data"]) ? trim($_POST["order_data"]) : 0;
			$user_id         = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : 0;
			$order_id        = isset($_POST["order_id"]) ? trim($_POST["order_id"]) : 0;
			$order_items     = isset($_POST["order_items"]) ? trim($_POST["order_items"]) : "";
			$order_email     = isset($_POST["order_email"]) ? trim($_POST["order_email"]) : "";
			$order_shipping  = isset($_POST["order_shipping"]) ? trim($_POST["order_shipping"]) : "";
			$order_tax       = isset($_POST["order_tax"]) ? trim($_POST["order_tax"]) : "";
			$order_total     = isset($_POST["order_total"]) ? trim($_POST["order_total"]) : "";
			$order_status    = isset($_POST["order_status"]) ? trim($_POST["order_status"]) : "";
			$user_login_name = isset($_POST["user_login_name"]) ? trim($_POST["user_login_name"]) : "";
			$shipping_label  = isset($_POST["shipping_label"]) ? trim($_POST["shipping_label"]) : "";
			$payment_data    = isset($_POST["payment_data"]) ? trim($_POST["payment_data"]) : "";
		} else {
			$coreorders_obj = $coreorders_database->get_plgsoft_coreorders_by_id($autoid);
			$autoid          = $coreorders_obj['autoid'];
			$order_ip        = $coreorders_obj['order_ip'];
			$order_date      = $coreorders_obj['order_date'];
			$order_time      = $coreorders_obj['order_time'];
			$order_data      = $coreorders_obj['order_data'];
			$user_id         = $coreorders_obj['user_id'];
			$order_id        = $coreorders_obj['order_id'];
			$order_items     = $coreorders_obj['order_items'];
			$order_email     = $coreorders_obj['order_email'];
			$order_shipping  = $coreorders_obj['order_shipping'];
			$order_tax       = $coreorders_obj['order_tax'];
			$order_total     = $coreorders_obj['order_total'];
			$order_status    = $coreorders_obj['order_status'];
			$user_login_name = $coreorders_obj['user_login_name'];
			$shipping_label  = $coreorders_obj['shipping_label'];
			$payment_data    = $coreorders_obj['payment_data'];
		}
	} else {
		$order_ip        = isset($_POST["order_ip"]) ? trim($_POST["order_ip"]) : "";
		$order_date      = isset($_POST["order_date"]) ? trim($_POST["order_date"]) : "";
		$order_time      = isset($_POST["order_time"]) ? trim($_POST["order_time"]) : "";
		$order_data      = isset($_POST["order_data"]) ? trim($_POST["order_data"]) : 0;
		$user_id         = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : 0;
		$order_id        = isset($_POST["order_id"]) ? trim($_POST["order_id"]) : 0;
		$order_items     = isset($_POST["order_items"]) ? trim($_POST["order_items"]) : "";
		$order_email     = isset($_POST["order_email"]) ? trim($_POST["order_email"]) : "";
		$order_shipping  = isset($_POST["order_shipping"]) ? trim($_POST["order_shipping"]) : "";
		$order_tax       = isset($_POST["order_tax"]) ? trim($_POST["order_tax"]) : "";
		$order_total     = isset($_POST["order_total"]) ? trim($_POST["order_total"]) : "";
		$order_status    = isset($_POST["order_status"]) ? trim($_POST["order_status"]) : "";
		$user_login_name = isset($_POST["user_login_name"]) ? trim($_POST["user_login_name"]) : "";
		$shipping_label  = isset($_POST["shipping_label"]) ? trim($_POST["shipping_label"]) : "";
		$payment_data    = isset($_POST["payment_data"]) ? trim($_POST["payment_data"]) : "";

		if (strlen($order_ip) > 0) {
			$is_validate = true;
		} else {
			if (strlen($order_ip) == 0) {
				$is_validate = false;
				$order_ip_error = "Order IP is empty";
			}
		}
		if ((strlen($order_date) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			$is_validate = false;
			$order_date_error = "Order Date is empty";
		}
		if ($is_validate) {
			$coreorders_array = array();
			$coreorders_array['order_ip']        = $order_ip;
			$coreorders_array['order_date']      = $order_date;
			$coreorders_array['order_time']      = $order_time;
			$coreorders_array['order_data']      = $order_data;
			$coreorders_array['user_id']         = $user_id;
			$coreorders_array['order_id']        = $order_id;
			$coreorders_array['order_items']     = $order_items;
			$coreorders_array['order_email']     = $order_email;
			$coreorders_array['order_shipping']  = $order_shipping;
			$coreorders_array['order_tax']       = $order_tax;
			$coreorders_array['order_total']     = $order_total;
			$coreorders_array['order_status']    = $order_status;
			$coreorders_array['user_login_name'] = $user_login_name;
			$coreorders_array['shipping_label']  = $shipping_label;
			$coreorders_array['payment_data']    = $payment_data;
			if ($autoid > 0) {
				$coreorders_array['autoid'] = $autoid;
				$coreorders_database->update_plgsoft_coreorders($coreorders_array);
				$task = "list";
				$msg_id = "The core orders is edited successfully";
			} else {
				$coreorders_database->insert_plgsoft_coreorders($coreorders_array);
				$task = "list";
				$msg_id = "The core orders is added successfully";
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
	$total_coreorders = $coreorders_database->get_total_plgsoft_coreorders($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_coreorders = $coreorders_database->get_list_plgsoft_coreorders($array_keywords, $limit, $offset);
	$coreorders_url = get_plgsoft_admin_url(array('page' => 'manage_coreorders', 'task' => 'add'));
	$array_user_id = $coreorders_database->get_array_user_id();
	$array_order_id = $coreorders_database->get_array_order_id();
	$array_user_id = array_merge($array_user_id, $array_order_id);
	$users_array = get_users_by_array_user_id($array_user_id);
	?>
	<?php if ($total_coreorders > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Core Orders', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Core Orders', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $coreorders_url ); ?>"><?php _e( 'Add Core Orders', 'plgsoft' ) ?></a>
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
							<div class="message"><?php echo $msg_id; ?></div>
						<?php } ?>
						<table class="table table-striped table-hovered table-responsive sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Order IP', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Order Date', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Order Time', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'User Login', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Order ID', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Items', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Email', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_coreorders as $coreorders_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_coreorders', 'autoid' => $coreorders_item['autoid'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_coreorders', 'autoid' => $coreorders_item['autoid'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<?php echo esc_html( $coreorders_item['autoid'] ); ?>
										</td>
										<td>
											<?php echo esc_html( $coreorders_item['order_ip'] ); ?>
										</td>
										<td><?php echo esc_html( $coreorders_item['order_date'] ); ?></td>
										<td>
											<?php if(isset($coreorders_item['order_time']) && (strlen($coreorders_item['order_time']) > 0)){ ?>
												<?php echo esc_html( $coreorders_item['order_time'] ); ?>
											<?php } ?>
										</td>
										<td>
											<?php
											$user_login = isset($users_array[$coreorders_item['user_id']]['user_login']) ? $users_array[$coreorders_item['user_id']]['user_login'] : "";
											echo esc_html( $user_login );
											?>
										</td>
										<td><?php echo esc_html( $coreorders_item['order_id'] ); ?></td>
										<td><?php echo esc_html( $array_quotes_status[$coreorders_item['order_items']] ); ?></td>
										<td class="text-right"><?php echo esc_html( $coreorders_item['order_email'] ); ?></td>
										<td class="text-right">
											<a class="btn btn-danger" href="<?php echo esc_url( $delete_link ); ?>"><i class="fa fa-fw fa-trash"></i></a>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</thead>
						</table>
						<div class="row text-center">
							<?php
							$class_Pagings = new class_Pagings($start, $total_coreorders, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any core orders', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Core Orders', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $coreorders_url ); ?>"><?php _e( 'Add Core Orders', 'plgsoft' ) ?></a>
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
	$coreorders_url = get_plgsoft_admin_url(array('page' => 'manage_coreorders', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($autoid > 0) { ?>
			<h2><?php _e( 'Edit Core Orders', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Core Orders', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Core Orders', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $coreorders_url ); ?>"><?php _e( 'Add Core Orders', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmCoreOrders" name="frmCoreOrders" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="autoid" name="autoid" value="<?php echo esc_attr( $autoid ); ?>">
						<?php if ($autoid > 0) { ?>
							<input type="hidden" id="task" name="task" value="edit">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } else { ?>
							<input type="hidden" id="task" name="task" value="add">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } ?>
						<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
						<input type="hidden" id="user_id" name="user_id" value="<?php echo esc_attr( $user_id ); ?>" />
						<input type="hidden" id="order_id" name="order_id" value="<?php echo esc_attr( $order_id ); ?>" />
						<input type="hidden" id="order_email" name="order_email" value="<?php echo esc_attr( $order_email ); ?>" />
						<input type="hidden" id="order_data" name="order_data" value="<?php echo esc_attr( $order_data ); ?>" />
						<input type="hidden" id="order_shipping" name="order_shipping" value="<?php echo esc_attr( $order_shipping ); ?>" />
						<input type="hidden" id="order_tax" name="order_tax" value="<?php echo esc_attr( $order_tax ); ?>" />
						<input type="hidden" id="order_total" name="order_total" value="<?php echo esc_attr( $order_total ); ?>" />
						<input type="hidden" id="order_status" name="order_status" value="<?php echo esc_attr( $order_status ); ?>" />
						<input type="hidden" id="user_login_name" name="user_login_name" value="<?php echo esc_attr( $user_login_name ); ?>" />
						<input type="hidden" id="shipping_label" name="shipping_label" value="<?php echo esc_attr( $shipping_label ); ?>" />
						<input type="hidden" id="payment_data" name="payment_data" value="<?php echo esc_attr( $payment_data ); ?>" />
						<div class="row">
							<label for="required"><?php _e( '* Required', 'plgsoft' ) ?></label>
						</div>
						<div class="row<?php echo (strlen($order_ip_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="order_ip"><?php _e( 'Order IP', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($order_ip_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $order_ip_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="order_ip" name="order_ip" size="70" value="<?php echo esc_attr( $order_ip ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($order_date_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="order_date"><?php _e( 'Order Date', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($order_date_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $order_date_error; ?></label>
								<?php } ?>
								<textarea class="row" id="order_date" name="order_date" rows="10" cols="70"><?php echo esc_html( $order_date ); ?></textarea>
							</div>
						</div>
						<?php if(isset($order_time) && (strlen($order_time) > 0)){ ?>
							<div class="row">
								<label class="col-2" for="order_time"><?php _e( 'Order Time', 'plgsoft' ) ?></label>
								<div class="col-10 field-wrap">
									<?php if (strlen($order_time_error) > 0) { ?>
										<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $order_time_error; ?></label>
									<?php } ?>
									<input type="hidden" id="order_time" name="order_time" size="70" value="<?php echo esc_attr( $order_time ); ?>" />
									<?php echo esc_html( $order_time ); ?>
								</div>
							</div>
						<?php } ?>
						<div class="row<?php echo (strlen($order_items_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="order_item"><?php _e( 'Order Items', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($order_items_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $order_items_error; ?></label>
								<?php } ?>
								<select id="order_items" name="order_items" class="is_active form-control select">
									<?php foreach ($array_quotes_status as $key => $value) { ?>
										<?php if($key == $order_items) { ?>
											<option selected="selected" value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
										<?php } else { ?>
											<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
										<?php } ?>
									<?php } ?>
								</select>
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
