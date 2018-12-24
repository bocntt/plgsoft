<?php
require_once(wp_plugin_plgsoft_admin_dir . "/maincategories/maincategories_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/categories/categories_database.php");

global $table_name;
$maincategories_database = new maincategories_database();
$maincategories_database->set_table_name($table_name);

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_maincategories';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$main_category_id = isset($_REQUEST["main_category_id"]) ? trim($_REQUEST["main_category_id"]) : 0;
$is_validate = false;
$main_category_name_error = ''; $is_active_error = ''; $permalink_error = ''; $order_listing_error = '';

$array_yes_no_property = get_array_yes_no_plgsoft_property();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_maincategories', 'keyword' => $keyword));

if ($task == 'delete') {
	$categories_database = new categories_database();
	$total_categories = $categories_database->get_total_plgsoft_categories_by_main_category_id($main_category_id);
	if ($total_categories == 0) {
		$maincategories_database->delete_plgsoft_maincategories($main_category_id);
		$task = "list";
		$msg_id = "The main category is deleted successfully";
	} else {
		$task = "list";
		$msg_id = "Can not delete the main category. The are some categories in the main category";
	}
} elseif ($task == 'import_default_data') {
	$array_main_categories[] = array('main_category_name' => 'creative');
	$array_main_categories[] = array('main_category_name' => 'cause');
	$array_main_categories[] = array('main_category_name' => 'entrepreneurial');

	$maincategory_array = array();
	for($i=0; $i<sizeof($array_main_categories); $i++) {
		$maincategory_array['main_category_name'] = $array_main_categories[$i]['main_category_name'];
		$maincategory_array['permalink'] = get_plgsoft_permalink($array_main_categories[$i]['main_category_name']);
		$maincategory_array['order_listing'] = $i + 1;
		$maincategory_array['is_active'] = 1;
		$maincategory_array['seo_title'] = $array_main_categories[$i]['main_category_name'];
		$maincategory_array['seo_description'] = $array_main_categories[$i]['main_category_name'];
		$maincategories_database->insert_plgsoft_maincategories($maincategory_array);
	}
	$task = "list";
	$msg_id = "These main categories are imported successfully";
} elseif ($task == 'active') {
	$maincategories_database->active_plgsoft_maincategories($main_category_id);
	$task = "list";
	$msg_id = "The main category is actived";
} elseif ($task == 'deactive') {
	$maincategories_database->deactive_plgsoft_maincategories($main_category_id);
	$task = "list";
	$msg_id = "The main category is deactived";
} else {
	if ($is_save==0) {
		if ($main_category_id==0) {
			$main_category_id = isset($_POST["main_category_id"]) ? trim($_POST["main_category_id"]) : 0;
			$main_category_name = isset($_POST["main_category_name"]) ? trim($_POST["main_category_name"]) : "";
			$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
			$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
			$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
			$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";
		} else {
			$maincategory_obj = $maincategories_database->get_plgsoft_maincategories_by_main_category_id($main_category_id);
			$main_category_name = $maincategory_obj['main_category_name'];
			$permalink = $maincategory_obj['permalink'];
			$order_listing = $maincategory_obj['order_listing'];
			$is_active = $maincategory_obj['is_active'];
			$main_category_id = $maincategory_obj['main_category_id'];
			$seo_title = $maincategory_obj['seo_title'];
			$seo_description = $maincategory_obj['seo_description'];
		}
	} else {
		$main_category_name = isset($_POST["main_category_name"]) ? trim($_POST["main_category_name"]) : "";
		$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
		$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
		$is_active = isset($_POST["is_active"]) ? 1 : 0;
		$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
		$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";

		$check_exist = $maincategories_database->check_exist_main_category_name($main_category_name, $main_category_id);
		if ((strlen($main_category_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($main_category_name) == 0) {
				$is_validate = false;
				$main_category_name_error = "Main Category Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$main_category_name_error = "Main Category Name is existed";
				}
			}
		}
		$check_exist_permalink = $maincategories_database->check_exist_permalink($permalink, $main_category_id);
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
			$maincategory_array = array();
			$maincategory_array['main_category_name'] = $main_category_name;
			$maincategory_array['permalink'] = $permalink;
			$maincategory_array['order_listing'] = $order_listing;
			$maincategory_array['is_active'] = $is_active;
			if (!isset($seo_title) || (isset($seo_title) && (strlen($seo_title) == 0))) $seo_title = $main_category_name;
			if (!isset($seo_description) || (isset($seo_description) && (strlen($seo_description) == 0))) $seo_description = $main_category_name;
			$maincategory_array['seo_title'] = $seo_title;
			$maincategory_array['seo_description'] = $seo_description;
			if ($main_category_id > 0) {
				$maincategory_array['main_category_id'] = $main_category_id;
				$maincategories_database->update_plgsoft_maincategories($maincategory_array);
				$task = "list";
				$msg_id = "The main category is edited successfully";
			} else {
				$maincategories_database->insert_plgsoft_maincategories($maincategory_array);
				$task = "list";
				$msg_id = "The main category is added successfully";
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
	$total_maincategories = $maincategories_database->get_total_plgsoft_maincategories($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_maincategories = $maincategories_database->get_list_plgsoft_maincategories($array_keywords, $limit, $offset);
	$maincategory_url = get_plgsoft_admin_url(array('page' => 'manage_maincategories', 'task' => 'add'));
	?>
	<?php if ($total_maincategories > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Main Categories', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Main Category', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $maincategory_url ); ?>"><?php _e( 'Add Main Category', 'plgsoft' ) ?></a>
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
									<th scope="col"><?php _e( 'Main Category Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Permalink', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_maincategories as $maincategory_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_maincategories', 'main_category_id' => $maincategory_item['main_category_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_maincategories', 'main_category_id' => $maincategory_item['main_category_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $maincategory_item['main_category_id']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $maincategory_item['main_category_name']; ?>
											</a>
										</td>
										<td><?php echo $maincategory_item['permalink']; ?></td>
										<td class="text-center">
											<?php
											if ($maincategory_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_maincategories', 'main_category_id' => $maincategory_item['main_category_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = 'Active';
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_maincategories', 'main_category_id' => $maincategory_item['main_category_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = 'Deactive';
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($maincategory_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center"><?php echo $maincategory_item['order_listing']; ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_maincategories, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any main category', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Main Category', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $maincategory_url ); ?>"><?php _e( 'Add Main Category', 'plgsoft' ) ?></a>
							<?php
							$import_default_url = get_plgsoft_admin_url(array('page' => 'manage_maincategories', 'task' => 'import_default_data'));
							?>
							<a href="<?php echo esc_url( $import_default_url ); ?>"><?php _e( 'Import Default Data', 'plgsoft' ) ?></a>
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
							<div class="message"><?php echo $msg_id; ?></div>
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
	$maincategory_url = get_plgsoft_admin_url(array('page' => 'manage_maincategories', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($main_category_id > 0) { ?>
			<h2><?php _e( 'Edit Main Category', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Main Category', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Main Category', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $maincategory_url ); ?>"><?php _e( 'Add Main Category', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmMainCategory" name="frmMainCategory" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="main_category_id" name="main_category_id" value="<?php echo $main_category_id; ?>">
						<?php if ($main_category_id > 0) { ?>
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
						<div class="row<?php echo (strlen($main_category_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="main_category_name"><?php _e( 'Main Category Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($main_category_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $main_category_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="main_category_name" name="main_category_name" size="70" value="<?php echo esc_attr( $main_category_name ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($permalink_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="permalink"><?php _e( 'Permalink', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($permalink_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $permalink_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="permalink" name="permalink" size="70" value="<?php echo esc_attr( $permalink ); ?>" />
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
								<input class="form-control" type="text" id="seo_title" name="seo_title" size="70" value="<?php echo esc_attr( $seo_title ); ?>" />
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
