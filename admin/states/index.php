<?php
require_once(wp_plugin_plgsoft_admin_dir . "/states/states_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/countries/countries_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/cities/cities_database.php");
global $table_name;
$states_database = new states_database();
$states_database->set_table_name($table_name);
$countries_database = new countries_database();
$countries_database->set_table_name("plgsoft_countries");
$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_states';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$state_id = isset($_REQUEST["state_id"]) ? trim($_REQUEST["state_id"]) : 0;
$is_validate = false;
$state_name_error = ''; $state_code_error = ''; $order_listing_error = ''; $country_key_error = ''; $is_active_error = ''; $permalink_error = '';

$array_yes_no_property = get_array_yes_no_plgsoft_property();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_states', 'keyword' => $keyword));

if ($task == 'delete') {
	$cities_database = new cities_database();
	$total_cities = $cities_database->get_total_plgsoft_cities_by_state_id($state_id);
	if ($total_cities == 0) {
		$states_database->delete_plgsoft_states($state_id);
		$task = "list";
		$msg_id = "The state is deleted successfully";
	} else {
		$task = "list";
		$msg_id = "Can not delete the state. The are some cities in the state";
	}
} elseif ($task == 'import_default_data') {
	global $wpdb;
	$check_table = $wpdb->get_var("SHOW TABLES LIKE 'icareweb_states'");
	if (isset($check_table) && ($check_table == 'icareweb_states')) {
		$total_states = $states_database->get_total_plgsoft_states(array());

		$sql = "SELECT COUNT(state_id) FROM icareweb_states";
		$total_state = $wpdb->get_var($sql);
		if (isset($total_state) && ($total_state > 0) && isset($total_states) && ($total_states == 0)) {
			$sql = "INSERT INTO ".$wpdb->prefix."plgsoft_states(state_name, state_code, order_listing, permalink, is_active, country_key)";
			$sql .= " SELECT state_name, state_code, order_listing, permalink, is_active, country_key FROM icareweb_states";
			$wpdb->prepare($sql, array());
			$wpdb->query($sql);

			$sql = "UPDATE ".$wpdb->prefix."plgsoft_states SET seo_title = state_name, seo_description = state_name";
			$wpdb->prepare($sql, array());
			$wpdb->query($sql);
		}
	} else {
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AL', 'state_name' => 'Alabama');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AK', 'state_name' => 'Alaska');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AS', 'state_name' => 'American Samoa');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AZ', 'state_name' => 'Arizona');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AR', 'state_name' => 'Arkansas');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AF', 'state_name' => 'Armed Forces Africa');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AA', 'state_name' => 'Armed Forces Americas');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AC', 'state_name' => 'Armed Forces Canada');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AE', 'state_name' => 'Armed Forces Europe');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AM', 'state_name' => 'Armed Forces Middle East');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'AP', 'state_name' => 'Armed Forces Pacific');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'CA', 'state_name' => 'California');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'CO', 'state_name' => 'Colorado');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'CT', 'state_name' => 'Connecticut');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'DE', 'state_name' => 'Delaware');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'DC', 'state_name' => 'District of Columbia');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'FM', 'state_name' => 'Federated States Of Micronesia');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'FL', 'state_name' => 'Florida');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'GA', 'state_name' => 'Georgia');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'GU', 'state_name' => 'Guam');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'HI', 'state_name' => 'Hawaii');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'ID', 'state_name' => 'Idaho');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'IL', 'state_name' => 'Illinois');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'IN', 'state_name' => 'Indiana');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'IA', 'state_name' => 'Iowa');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'KS', 'state_name' => 'Kansas');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'KY', 'state_name' => 'Kentucky');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'LA', 'state_name' => 'Louisiana');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'ME', 'state_name' => 'Maine');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MH', 'state_name' => 'Marshall Islands');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MD', 'state_name' => 'Maryland');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MA', 'state_name' => 'Massachusetts');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MI', 'state_name' => 'Michigan');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MN', 'state_name' => 'Minnesota');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MS', 'state_name' => 'Mississippi');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MO', 'state_name' => 'Missouri');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MT', 'state_name' => 'Montana');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'NE', 'state_name' => 'Nebraska');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'NV', 'state_name' => 'Nevada');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'NH', 'state_name' => 'New Hampshire');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'NJ', 'state_name' => 'New Jersey');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'NM', 'state_name' => 'New Mexico');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'NY', 'state_name' => 'New York');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'NC', 'state_name' => 'North Carolina');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'ND', 'state_name' => 'North Dakota');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'MP', 'state_name' => 'Northern Mariana Islands');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'OH', 'state_name' => 'Ohio');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'OK', 'state_name' => 'Oklahoma');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'OR', 'state_name' => 'Oregon');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'PW', 'state_name' => 'Palau');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'PA', 'state_name' => 'Pennsylvania');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'PR', 'state_name' => 'Puerto Rico');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'RI', 'state_name' => 'Rhode Island');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'SC', 'state_name' => 'South Carolina');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'SD', 'state_name' => 'South Dakota');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'TN', 'state_name' => 'Tennessee');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'TX', 'state_name' => 'Texas');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'UT', 'state_name' => 'Utah');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'VT', 'state_name' => 'Vermont');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'VI', 'state_name' => 'Virgin Islands');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'VA', 'state_name' => 'Virginia');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'WA', 'state_name' => 'Washington');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'WV', 'state_name' => 'West Virginia');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'WI', 'state_name' => 'Wisconsin');
		$array_states[] = array('country_key' => 'US', 'state_code' => 'WY', 'state_name' => 'Wyoming');

		$state_array = array();
		for($i=0; $i<sizeof($array_states); $i++) {
			$state_array['state_name'] = $array_states[$i]['state_name'];
			$state_array['state_code'] = $array_states[$i]['state_code'];
			$state_array['country_key'] = strtolower($array_states[$i]['country_key']);
			$state_array['permalink'] = get_plgsoft_permalink($array_states[$i]['state_name']);
			$state_array['order_listing'] = $i;
			$state_array['is_active'] = 1;
			$state_array['seo_title'] = $array_states[$i]['state_name'];
			$state_array['seo_description'] = $array_states[$i]['state_name'];
			$states_database->insert_plgsoft_states($state_array);
		}
	}
	$task = "list";
	$msg_id = "These states are imported successfully";
} elseif ($task == 'active') {
	$states_database->active_plgsoft_states($state_id);
	$task = "list";
	$msg_id = "The state is actived";
} elseif ($task == 'deactive') {
	$states_database->deactive_plgsoft_states($state_id);
	$task = "list";
	$msg_id = "The state is deactived";
} else {
	$list_countries = $countries_database->get_list_plgsoft_countries();
	if ($is_save==0) {
		if ($state_id == 0) {
			$state_id = isset($_POST["state_id"]) ? trim($_POST["state_id"]) : "";
			$state_name = isset($_POST["state_name"]) ? trim($_POST["state_name"]) : "";
			$state_code = isset($_POST["state_code"]) ? trim($_POST["state_code"]) : "";
			$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
			$country_key = isset($_POST["country_key"]) ? trim($_POST["country_key"]) : "";
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
			$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
			$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
			$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";
		} else {
			$state_obj = $states_database->get_plgsoft_states_by_state_id($state_id);
			$state_name = $state_obj['state_name'];
			$state_code = $state_obj['state_code'];
			$order_listing = $state_obj['order_listing'];
			$country_key = $state_obj['country_key'];
			$is_active = $state_obj['is_active'];
			$permalink = $state_obj['permalink'];
			$state_id = $state_obj['state_id'];
			$seo_title = $state_obj['seo_title'];
			$seo_description = $state_obj['seo_description'];
		}
	} else {
		$state_name = isset($_POST["state_name"]) ? trim($_POST["state_name"]) : "";
		$state_code = isset($_POST["state_code"]) ? trim($_POST["state_code"]) : "";
		$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
		$country_key = isset($_POST["country_key"]) ? trim($_POST["country_key"]) : "";
		$is_active = isset($_POST["is_active"]) ? 1 : 0;
		$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
		$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
		$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";

		$check_exist = $states_database->check_exist_state_name($state_name, $state_id);
		if ((strlen($state_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($state_name) == 0) {
				$is_validate = false;
				$state_name_error = "State Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$state_name_error = "State Name is existed";
				}
			}
		}
		$check_exist_permalink = $states_database->check_exist_permalink($permalink, $state_id);
		if ((strlen($permalink) > 0) && !$check_exist_permalink && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($permalink) > 0) {
				if ($check_exist_permalink) {
					$is_validate = false;
					$permalink_error = "Permalink is existed";
				}
			}
		}
		if ((strlen($state_code) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($state_code) == 0) {
				$is_validate = false;
				$state_code_error = "State Code is empty";
			}
		}
		if ((strlen($country_key) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($country_key) == 0) {
				$is_validate = false;
				$country_key_error = "Country Name is empty";
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
			$state_array = array();
			$state_array['state_name'] = $state_name;
			$state_array['state_code'] = $state_code;
			$state_array['order_listing'] = $order_listing;
			$state_array['country_key'] = strtolower($country_key);
			$state_array['is_active'] = $is_active;
			$state_array['permalink'] = $permalink;
			if (!isset($seo_title) || (isset($seo_title) && (strlen($seo_title) == 0))) $seo_title = $state_name;
			if (!isset($seo_description) || (isset($seo_description) && (strlen($seo_description) == 0))) $seo_description = $state_name;
			$state_array['seo_title'] = $seo_title;
			$state_array['seo_description'] = $seo_description;

			if ($state_id > 0) {
				$state_array['state_id'] = $state_id;
				$states_database->update_plgsoft_states($state_array);
				$task = "list";
				$msg_id = "The state is edited successfully";
			} else {
				$states_database->insert_plgsoft_states($state_array);
				$task = "list";
				$msg_id = "The state is added successfully";
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
	$total_states = $states_database->get_total_plgsoft_states($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;
	$list_states = $states_database->get_list_plgsoft_states($array_keywords, $limit, $offset);
	$state_url = get_plgsoft_admin_url(array('page' => 'manage_states', 'task' => 'add'));
	$list_countries = $countries_database->get_all_plgsoft_countries_by_array_country_key($states_database->get_array_country_key());
	?>
	<?php if ($total_states > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List States', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage State', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $state_url ); ?>"><?php _e( 'Add State', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
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
									<th scope="col"><?php _e( 'State Code', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'State Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Permalink', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Country Name', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_states as $state_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_states', 'state_id' => $state_item['state_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_states', 'state_id' => $state_item['state_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $state_item['state_id']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $state_item['state_code']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $state_item['state_name']; ?>
											</a>
										</td>
										<td><?php echo $state_item['permalink']; ?></td>
										<td><?php echo $list_countries[$state_item['country_key']]; ?></td>
										<td class="text-center">
											<?php
											if ($state_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_states', 'state_id' => $state_item['state_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_states', 'state_id' => $state_item['state_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($state_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center"><?php echo $state_item['order_listing']; ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_states, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any state', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage State', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $state_url ); ?>"><?php _e( 'Add State', 'plgsoft' ) ?></a>
							<?php
							$total_all_states = $states_database->get_total_plgsoft_states(array());
							if ($total_all_states == 0) {
								$state_import_data_url = get_plgsoft_admin_url(array('page' => 'manage_states', 'task' => 'import_default_data'));
							?>
								<a style="padding-left: 10px;" href="<?php echo esc_url( $state_import_data_url ); ?>"><?php _e( 'Import Default Data', 'plgsoft' ) ?></a>
							<?php } ?>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
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
	$state_url = get_plgsoft_admin_url(array('page' => 'manage_states', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($state_id > 0) { ?>
			<h2><?php _e( 'Edit State', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add State', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage State', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $state_url ); ?>"><?php _e( 'Add State', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmState" name="frmState" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="state_id" name="state_id" value="<?php echo $state_id; ?>">
						<?php if ($state_id > 0) { ?>
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
						<div class="row<?php echo (strlen($state_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="state_name"><?php _e( 'State Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($state_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $state_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="state_name" name="state_name" size="70" value="<?php echo esc_attr($state_name); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($permalink_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="permalink"><?php _e( 'Permalink', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($permalink_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $permalink_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="permalink" name="permalink" size="70" value="<?php echo esc_attr($permalink); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($state_code_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="state_code"><?php _e( 'State Code', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($state_code_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $state_code_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="state_code" name="state_code" size="35" value="<?php echo esc_attr( $state_code ); ?>" />
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
						<div class="row<?php echo (strlen($country_key_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="country_key"><?php _e( 'Country Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($country_key_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $country_key_error; ?></label>
								<?php } ?>
								<select id="country_key" name="country_key" class="country_key form-control select">
									<option value=""><?php _e( 'Select country', 'plgsoft' ) ?></option>
									<?php for ($i = 0; $i < sizeof($list_countries); $i++) { ?>
										<?php if($list_countries[$i]['country_key'] == $country_key) { ?>
											<option selected="selected" value="<?php echo $list_countries[$i]['country_key']; ?>"><?php echo $list_countries[$i]['country_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $list_countries[$i]['country_key']; ?>"><?php echo $list_countries[$i]['country_name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
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
							<label class="col-2" for="seo_title"><?php _e( 'SEO Title', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<input class="form-control" type="text" id="seo_title" name="seo_title" size="70" value="<?php echo esc_attr($seo_title); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="seo_description"><?php _e( 'SEO Description', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<textarea class="form-control textarea" id="seo_description" name="seo_description" rows="5" cols="70"><?php echo esc_html($seo_description); ?></textarea>
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
