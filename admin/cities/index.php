<?php
require_once(wp_plugin_plgsoft_admin_dir . "/cities/cities_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/states/states_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/countries/countries_database.php");

global $table_name;
$cities_database = new cities_database();
$cities_database->set_table_name($table_name);
$countries_database = new countries_database();
$countries_database->set_table_name("plgsoft_countries");
$states_database = new states_database();
$states_database->set_table_name("plgsoft_states");

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_cities';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$city_id = isset($_REQUEST["city_id"]) ? trim($_REQUEST["city_id"]) : "";
$is_validate = false;
$city_name_error = ''; $is_active_error = ''; $is_top_error = ''; $is_more_error = '';
$country_key_error = ''; $state_id_error = '';
$permalink_error = ''; $order_listing_error = '';
$array_yes_no_property = get_array_yes_no_plgsoft_property();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_cities', 'keyword' => $keyword));

if ($task == 'delete') {
	$cities_database->delete_plgsoft_cities($city_id);
	$task = "list";
	$msg_id = "The city is deleted successfully";
} elseif ($task == 'import_default_data') {
	global $wpdb;
	$check_table = $wpdb->get_var("SHOW TABLES LIKE 'icareweb_cities'");
	if (isset($check_table) && ($check_table == 'icareweb_cities')) {
		$total_cities = $cities_database->get_total_plgsoft_cities(array());

		$sql = "SELECT COUNT(state_id) FROM icareweb_cities";
		$total_city = $wpdb->get_var($sql);
		if (isset($total_city) && ($total_city > 0) && isset($total_cities) && ($total_cities == 0)) {
			$sql = "INSERT INTO ".$wpdb->prefix."plgsoft_cities(city_name, city_code, order_listing, permalink, is_active, state_id, country_key)";
			$sql .= " SELECT city_name, city_code, order_listing, permalink, is_active, state_id, country_key FROM icareweb_cities";
			$wpdb->query($sql);

			$sql = "UPDATE ".$wpdb->prefix."plgsoft_cities SET seo_title = city_name, seo_description = city_name";
			$wpdb->query($sql);
		}
	} else {
		$array_cities[] = array('city_name' => 'Addison', 'state_id' => 1);
		$array_cities[] = array('city_name' => 'Birmingham', 'state_id' => 1);
		$array_cities[] = array('city_name' => 'Campbell', 'state_id' => 1);
		$array_cities[] = array('city_name' => 'Alhambra', 'state_id' => 12);
		$array_cities[] = array('city_name' => 'Chicago Park', 'state_id' => 12);
		$array_cities[] = array('city_name' => 'Oceano', 'state_id' => 12);
		$array_cities[] = array('city_name' => 'Akron', 'state_id' => 14);
		$array_cities[] = array('city_name' => 'Bristol', 'state_id' => 14);
		$array_cities[] = array('city_name' => 'Green Mountain Falls', 'state_id' => 14);
		$array_cities[] = array('city_name' => 'East Haven', 'state_id' => 15);
		$array_cities[] = array('city_name' => 'Greens Farms', 'state_id' => 15);
		$array_cities[] = array('city_name' => 'New Hartford', 'state_id' => 15);
		$array_cities[] = array('city_name' => 'Bethany Beach', 'state_id' => 16);
		$array_cities[] = array('city_name' => 'Saint Georges', 'state_id' => 16);
		$array_cities[] = array('city_name' => 'New Castle', 'state_id' => 16);
		$array_cities[] = array('city_name' => 'Alta Loma', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Arthur City', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Balch Springs', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Beach City', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Big Bend Natl Park', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Blue Mound', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Caddo Mills', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Carrizo Springs', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Clear Lake Shores', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Copperas Cove', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Cypress Mill', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Dripping Springs', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Elysian Fields', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Fort Hancock', 'state_id' => 57);
		$array_cities[] = array('city_name' => 'Austin', 'state_id' => 57);

		$city_array = array();
		for($i=0; $i<sizeof($array_cities); $i++) {
			$city_array['city_code'] = $i;
			$city_name = $array_cities[$i]['city_name'];
			$city_array['city_name'] = $city_name;
			$city_array['permalink'] = get_plgsoft_permalink($city_name);
			$city_array['order_listing'] = $i;
			$city_array['country_key'] = strtolower("US");
			$city_array['state_id'] = $array_cities[$i]['state_id'];
			$city_array['is_active'] = 1;
			$city_array['seo_title'] = $array_cities[$i]['city_name'];
			$city_array['seo_description'] = $array_cities[$i]['city_name'];
			$cities_database->insert_plgsoft_cities($city_array);
		}
	}
	$task = "list";
	$msg_id = "These cities are imported successfully";
} elseif ($task == 'active') {
	$cities_database->active_plgsoft_cities($city_id);
	$task = "list";
	$msg_id = "The city is actived";
} elseif ($task == 'is_top') {
	$cities_database->is_top_plgsoft_cities($city_id);
	$task = "list";
	$msg_id = "The city is top city";
} elseif ($task == 'is_more') {
	$cities_database->is_more_plgsoft_cities($city_id);
	$task = "list";
	$msg_id = "The city is more city";
} elseif ($task == 'deactive') {
	$cities_database->deactive_plgsoft_cities($city_id);
	$task = "list";
	$msg_id = "The city is deactived";
} elseif ($task == 'is_not_top') {
	$cities_database->is_not_top_plgsoft_cities($city_id);
	$task = "list";
	$msg_id = "The city is not top city";
} elseif ($task == 'is_not_more') {
	$cities_database->is_not_more_plgsoft_cities($city_id);
	$task = "list";
	$msg_id = "The city is not more city";
} else {
	$list_countries = $countries_database->get_list_plgsoft_countries();
	if ($is_save==0) {
		if (strlen($city_id)==0) {
			$city_id = isset($_POST["city_id"]) ? trim($_POST["city_id"]) : 0;
			$city_name = isset($_POST["city_name"]) ? trim($_POST["city_name"]) : "";
			$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
			$country_key = isset($_POST["country_key"]) ? trim($_POST["country_key"]) : "";
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
			$is_top = isset($_POST["is_top"]) ? 1 : 0;
			$is_more = isset($_POST["is_more"]) ? 1 : 0;
			$state_id = isset($_POST["state_id"]) ? trim($_POST["state_id"]) : "";
			$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
			$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
			$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";
			$list_states = $states_database->get_all_plgsoft_states_by_country_key($country_key);
		} else {
			$city_obj = $cities_database->get_plgsoft_cities_by_city_id($city_id);
			$city_name = $city_obj['city_name'];
			$city_code = $city_obj['city_code'];
			$order_listing = $city_obj['order_listing'];
			$is_active = $city_obj['is_active'];
			$is_top = $city_obj['is_top'];
			$is_more = $city_obj['is_more'];
			$city_id = $city_obj['city_id'];
			$state_id = $city_obj['state_id'];
			$country_key = $city_obj['country_key'];
			$permalink = $city_obj['permalink'];
			$seo_title = $city_obj['seo_title'];
			$seo_description = $city_obj['seo_description'];
			$list_states = $states_database->get_all_plgsoft_states_by_country_key($country_key);
		}
	} else {
		$city_name = isset($_POST["city_name"]) ? trim($_POST["city_name"]) : "";
		$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
		$country_key = isset($_POST["country_key"]) ? trim($_POST["country_key"]) : "";
		$state_id = isset($_POST["state_id"]) ? trim($_POST["state_id"]) : "";
		$is_active = isset($_POST["is_active"]) ? 1 : 0;
		$is_top = isset($_POST["is_top"]) ? 1 : 0;
		$is_more = isset($_POST["is_more"]) ? 1 : 0;
		$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
		$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
		$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";
		$list_states = $states_database->get_all_plgsoft_states_by_country_key($country_key);

		$check_exist = $cities_database->check_exist_city_name($city_name, $city_id);
		if ((strlen($city_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($city_name) == 0) {
				$is_validate = false;
				$city_name_error = "City Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$city_name_error = "City Name is existed";
				}
			}
		}
		$check_exist_permalink = $cities_database->check_exist_permalink($permalink, $city_id);
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
		if ((strlen($country_key) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($country_key) == 0) {
				$is_validate = false;
				$country_key_error = "Country Name is empty";
			}
		}
		if ((strlen($state_id) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($state_id) == 0) {
				$is_validate = false;
				$state_id_error = "State is empty";
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
		if ((strlen($is_top) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($is_top) == 0) {
				$is_validate = false;
				$is_top_error = "Top city is empty";
			}
		}
		if ((strlen($is_more) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($is_more) == 0) {
				$is_validate = false;
				$is_more_error = "More city is empty";
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
			$city_array = array();
			$city_array['city_name'] = $city_name;
			$city_array['order_listing'] = $order_listing;
			$city_array['country_key'] = strtolower($country_key);
			$city_array['state_id'] = $state_id;
			$city_array['is_active'] = $is_active;
			$city_array['is_top'] = $is_top;
			$city_array['is_more'] = $is_more;
			$city_array['permalink'] = $permalink;
			if (!isset($seo_title) || (isset($seo_title) && (strlen($seo_title) == 0))) $seo_title = $city_name;
			if (!isset($seo_description) || (isset($seo_description) && (strlen($seo_description) == 0))) $seo_description = $city_name;
			$city_array['seo_title'] = $seo_title;
			$city_array['seo_description'] = $seo_description;

			if ($city_id > 0) {
				$city_array['city_id'] = $city_id;
				$cities_database->update_plgsoft_cities($city_array);
				$task = "list";
				$msg_id = "The city is edited successfully";
			} else {
				$cities_database->insert_plgsoft_cities($city_array);
				$task = "list";
				$msg_id = "The city is added successfully";
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
	$total_cities = $cities_database->get_total_plgsoft_cities($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;
	$list_cities = $cities_database->get_list_plgsoft_cities($array_keywords, $limit, $offset);
	$city_url = get_plgsoft_admin_url(array('page' => 'manage_cities', 'task' => 'add'));
	$list_countries = $countries_database->get_all_plgsoft_countries_by_array_country_key($cities_database->get_array_country_key());
	$list_states = $states_database->get_all_plgsoft_states_by_array_state_id($cities_database->get_array_state_id());
	?>
	<?php if ($total_cities > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Cities', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage City', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $city_url ); ?>"><?php _e( 'Add City', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
								<input type="hidden" id="page" name="page" value="<?php echo esc_attr( $page ) ?>">
								<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ) ?>">
								<input type="hidden" id="task" name="task" value="<?php echo esc_attr( $task ) ?>">
								<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ) ?>">
								<input type="text" class="form-control" id="keyword" name="keyword" size="40" value="<?php echo esc_attr( $keyword ) ?>" />
								<input type="submit" class="btn btn-default" id="cmdSearch" name="cmdSearch" value="<?php _e ('Search', 'plgsoft' ) ?>" />
							</form>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div class="plgsoft-sub-tab-content">
						<?php if (strlen($msg_id) > 0) { ?>
							<div class="message"><?php echo esc_html( $msg_id ) ?></div>
						<?php } ?>
						<table class="table table-striped table-hovered table-responsive sortable" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'City Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Permalink', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Country Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'State Name', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Top City', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'More City', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_cities as $city_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_cities', 'city_id' => $city_item['city_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_cities', 'city_id' => $city_item['city_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $city_item['city_id'] ); ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>"><?php echo esc_html( $city_item['city_name'] ); ?></a>
										</td>
										<td><?php echo esc_html( $city_item['permalink'] ); ?></td>
										<td><?php echo esc_html( $list_countries[$city_item['country_key']] ); ?></td>
										<td><?php echo esc_html( $list_states[$city_item['state_id']] ); ?></td>
										<td class="text-center">
											<?php
												if ($city_item['is_active'] == 1) {
													$status_link = get_plgsoft_admin_url(array('page' => 'manage_cities', 'city_id' => $city_item['city_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
													$status_lable = 'Active';
												} else {
													$status_link = get_plgsoft_admin_url(array('page' => 'manage_cities', 'city_id' => $city_item['city_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
													$status_lable = 'Deactive';
												}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($city_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center">
											<?php
												if ($city_item['is_top'] == 1) {
													$is_top_link = get_plgsoft_admin_url(array('page' => 'manage_cities', 'city_id' => $city_item['city_id'], 'task' => 'is_not_top', 'keyword' => $keyword, 'start' => $start));
													$is_top_lable = 'Top City';
												} else {
													$is_top_link = get_plgsoft_admin_url(array('page' => 'manage_cities', 'city_id' => $city_item['city_id'], 'task' => 'is_top', 'keyword' => $keyword, 'start' => $start));
													$is_top_lable = 'Not Top City';
												}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $is_top_link; ?>');" name="is_top" id="is_top" <?php echo ($city_item['is_top'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center">
											<?php
											if ($city_item['is_more'] == 1) {
												$is_more_link = get_plgsoft_admin_url(array('page' => 'manage_cities', 'city_id' => $city_item['city_id'], 'task' => 'is_not_more', 'keyword' => $keyword, 'start' => $start));
												$is_more_lable = 'More City';
											} else {
												$is_more_link = get_plgsoft_admin_url(array('page' => 'manage_cities', 'city_id' => $city_item['city_id'], 'task' => 'is_more', 'keyword' => $keyword, 'start' => $start));
												$is_more_lable = 'Not More City';
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $is_more_link; ?>');" name="is_more" id="is_more" <?php echo ($city_item['is_more'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center"><?php echo esc_html( $city_item['order_listing'] ); ?></td>
										<td class="text-right">
											<a class="btn btn-primary" href="<?php echo esc_url( $edit_link ); ?>"><i class="fa fa-fw fa-edit"></i></a>
											<a class="btn btn-danger" href="<?php echo esc_url( $delete_link ); ?>"><i class="fa fa-fw fa-trash"></i></a>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</thead>
						</table>
						<div class="row text-center">
							<?php
							$class_Pagings = new class_Pagings($start, $total_cities, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any city', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage City', 'plgsoft' ) ?></a>
							<?php $city_import_data_url = get_plgsoft_admin_url(array('page' => 'manage_cities', 'task' => 'import_default_data')); ?>
							<a href="<?php echo esc_url( $city_url ); ?>"><?php _e( 'Add City', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $city_import_data_url ); ?>"><?php _e( 'Import Default Data', 'plgsoft' ) ?></a>
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
							<div class="message"><?php echo esc_html( $msg_id ) ?></div>
						<?php } ?>
						<div class="row text-center">
							<?php echo __('There are no results for this search. Please try another search.', 'plgsoft'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php } else { ?>
	<?php
		$city_url = get_plgsoft_admin_url(array('page' => 'manage_cities', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if (strlen($city_id) > 0) { ?>
			<h2><?php _e( 'Edit City', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add City', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage City', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $city_url ); ?>"><?php _e( 'Add City', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form method="post" class="form" role="form" action="<?php echo esc_url( $manage_list_url ); ?>" id="frm_city" name="frm_city" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="city_id" name="city_id" value="<?php echo esc_attr( $city_id ); ?>">
						<?php if (strlen($city_id) > 0) { ?>
							<input type="hidden" id="task" name="task" value="edit">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } else { ?>
							<input type="hidden" id="task" name="task" value="add">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } ?>
						<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
						<div class="row">
							<label class="col-2" for="city_name"><?php _e( 'City Name', 'plgsoft' ) ?></label>
							<div class="field-wrap col-10<?php echo (strlen($city_name_error) > 0) ? ' has-error' : ''; ?>">
								<?php if (strlen($city_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $city_name_error ?></label>
								<?php } ?>
								<input type="text" class="form-control" id="city_name" name="city_name" size="70" value="<?php echo esc_attr( $city_name ); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="permalink"><?php _e( 'Permalink', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap<?php echo (strlen($permalink_error) > 0) ? ' has-error' : ''; ?>">
								<?php if (strlen($permalink_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $permalink_error ); ?></label>
								<?php } ?>
								<input type="text" class="form-control" id="permalink" name="permalink" size="70" value="<?php echo esc_attr( $permalink ); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="order_listing"><?php _e( 'Order Listing', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap<?php echo (strlen($order_listing_error) > 0) ? ' has-error' : ''; ?>">
								<?php if (strlen($order_listing_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $order_listing_error ); ?></label>
								<?php } ?>
								<input type="text" class="form-control" id="order_listing" name="order_listing" size="35" value="<?php echo esc_attr( $order_listing ); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="country_key"><?php _e( 'Country Name', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap<?php echo (strlen($country_key_error) > 0) ? ' has-error' : ''; ?>">
								<?php if (strlen($country_key_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $country_key_error ); ?></label>
								<?php } ?>
								<select id="country_key" name="country_key" class="country_key form-control">
									<option value=""><?php _e( 'Select country', 'plgsoft' ) ?></option>
									<?php for ($i = 0; $i < sizeof($list_countries); $i++) { ?>
										<?php if($list_countries[$i]['country_key'] == $country_key) { ?>
											<option selected="selected" value="<?php echo esc_attr( $list_countries[$i]['country_key'] ); ?>"><?php echo esc_html( $list_countries[$i]['country_name'] ); ?></option>
										<?php } else { ?>
											<option value="<?php echo esc_attr( $list_countries[$i]['country_key'] ); ?>"><?php echo esc_html( $list_countries[$i]['country_name'] ); ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="state_id"><?php _e( 'State', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap<?php echo (strlen($state_id_error) > 0) ? ' has-error' : ''; ?>">
								<?php if (strlen($state_id_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $state_id_error ); ?></label>
								<?php } ?>
								<select id="state_id" name="state_id" class="state_id form-control">
									<option value=""><?php _e( 'Select state', 'plgsoft' ) ?></option>
									<?php foreach ($list_states as $key => $value) { ?>
										<?php if($key == $state_id) { ?>
											<option selected="selected" value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
										<?php } else { ?>
											<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="is_active"><?php _e( 'Status', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap<?php echo (strlen($is_active_error) > 0) ? ' has-error' : ''; ?>">
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
							<label class="col-2" for="is_top"><?php _e( 'Top City', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap<?php echo (strlen($is_top_error) > 0) ? ' has-error' : ''; ?>">
								<?php if (strlen($is_top_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $is_top_error ); ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="is_top" id="is_top" <?php echo ($is_top == 1) ? 'checked="checked"' : ''; ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="is_more"><?php _e( 'More City', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap<?php echo (strlen($is_more_error) > 0) ? ' has-error' : ''; ?>">
								<?php if (strlen($is_more_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $is_more_error ); ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="is_more" id="is_more" <?php echo ($is_more == 1) ? 'checked="checked"' : ''; ?>>
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
								<textarea class="form-control" id="seo_description" name="seo_description" rows="5" cols="70"><?php echo esc_html($seo_description); ?></textarea>
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
