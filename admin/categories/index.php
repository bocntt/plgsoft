<?php
require_once(wp_plugin_plgsoft_admin_dir . "/categories/categories_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/maincategories/maincategories_database.php");

global $table_name;
$categories_database = new categories_database();
$categories_database->set_table_name($table_name);
$maincategories_database = new maincategories_database();

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_categories';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$category_id = isset($_REQUEST["category_id"]) ? trim($_REQUEST["category_id"]) : 0;
$is_validate = false;
$category_name_error = ''; $is_active_error = ''; $main_category_id_error = ''; $permalink_error = ''; $order_listing_error = '';
$array_yes_no_property = get_array_yes_no_plgsoft_property();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_categories', 'keyword' => $keyword));

if ($task == 'delete') {
	$categories_database->delete_plgsoft_categories($category_id);
	$task = "list";
	$msg_id = "The category is deleted successfully";
} elseif ($task == 'import_default_data') {
	$array_categories[] = array('category_name' => 'Art');
	$array_categories[] = array('category_name' => 'Comic');
	$array_categories[] = array('category_name' => 'Dance');
	$array_categories[] = array('category_name' => 'Design');
	$array_categories[] = array('category_name' => 'Fashion');
	$array_categories[] = array('category_name' => 'Film');
	$array_categories[] = array('category_name' => 'Gaming');
	$array_categories[] = array('category_name' => 'Music');
	$array_categories[] = array('category_name' => 'Photography');
	$array_categories[] = array('category_name' => 'Theatre');
	$array_categories[] = array('category_name' => 'Transmedia');
	$array_categories[] = array('category_name' => 'Video / Web');
	$array_categories[] = array('category_name' => 'Writing');
	$array_categories[] = array('category_name' => 'Animals');
	$array_categories[] = array('category_name' => 'Community');
	$array_categories[] = array('category_name' => 'Education');
	$array_categories[] = array('category_name' => 'Environment');
	$array_categories[] = array('category_name' => 'Health');
	$array_categories[] = array('category_name' => 'Politics');
	$array_categories[] = array('category_name' => 'Religion');
	$array_categories[] = array('category_name' => 'Food');
	$array_categories[] = array('category_name' => 'Small Business');
	$array_categories[] = array('category_name' => 'Sports');
	$array_categories[] = array('category_name' => 'Technology');

	$category_array = array();
	for($i=0; $i<sizeof($array_categories); $i++) {
		$category_array['category_name'] = $array_categories[$i]['category_name'];
		$category_array['permalink'] = get_plgsoft_permalink($array_categories[$i]['category_name']);
		$category_array['order_listing'] = $i+1;
		$category_array['is_active'] = 1;
		$category_array['main_category_id'] = $i % 2 + 1;
		$category_array['seo_title'] = $array_categories[$i]['category_name'];
		$category_array['seo_description'] = $array_categories[$i]['category_name'];
		$categories_database->insert_plgsoft_categories($category_array);
	}
	$task = "list";
	$msg_id = "These categories are imported successfully";
} elseif ($task == 'active') {
	$categories_database->active_plgsoft_categories($category_id);
	$task = "list";
	$msg_id = "The category is actived";
} elseif ($task == 'deactive') {
	$categories_database->deactive_plgsoft_categories($category_id);
	$task = "list";
	$msg_id = "The category is deactived";
} else {
	$list_maincategories = $maincategories_database->get_list_plgsoft_maincategories();
	if ($is_save==0) {
		if ($category_id==0) {
			$category_id = isset($_POST["category_id"]) ? trim($_POST["category_id"]) : 0;
			$category_name = isset($_POST["category_name"]) ? trim($_POST["category_name"]) : "";
			$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
			$main_category_id = isset($_POST["main_category_id"]) ? trim($_POST["main_category_id"]) : "";
			$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
			$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
			$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";
		} else {
			$category_obj = $categories_database->get_plgsoft_categories_by_category_id($category_id);
			$category_name = $category_obj['category_name'];
			$order_listing = $category_obj['order_listing'];
			$is_active = $category_obj['is_active'];
			$category_id = $category_obj['category_id'];
			$main_category_id = $category_obj['main_category_id'];
			$permalink = $category_obj['permalink'];
			$seo_title = $category_obj['seo_title'];
			$seo_description = $category_obj['seo_description'];
		}
	} else {
		$category_name = isset($_POST["category_name"]) ? trim($_POST["category_name"]) : "";
		$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
		$is_active = isset($_POST["is_active"]) ? 1 : 0;
		$main_category_id = isset($_POST["main_category_id"]) ? trim($_POST["main_category_id"]) : "";
		$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
		$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
		$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";

		$check_exist = $categories_database->check_exist_category_name($category_name, $category_id);
		if ((strlen($category_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($category_name) == 0) {
				$is_validate = false;
				$category_name_error = "Category Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$category_name_error = "Category Name is existed";
				}
			}
		}
		$check_exist_permalink = $categories_database->check_exist_permalink($permalink, $category_id);
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
		if ((strlen($main_category_id) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($main_category_id) == 0) {
				$is_validate = false;
				$main_category_id_error = "Main Category is empty";
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
			$category_array = array();
			$category_array['category_name'] = $category_name;
			$category_array['order_listing'] = $order_listing;
			$category_array['is_active'] = $is_active;
			$category_array['main_category_id'] = $main_category_id;
			$category_array['permalink'] = $permalink;
			if (!isset($seo_title) || (isset($seo_title) && (strlen($seo_title) == 0))) $seo_title = $category_name;
			if (!isset($seo_description) || (isset($seo_description) && (strlen($seo_description) == 0))) $seo_description = $category_name;
			$category_array['seo_title'] = $seo_title;
			$category_array['seo_description'] = $seo_description;
			if ($category_id > 0) {
				$category_array['category_id'] = $category_id;
				$categories_database->update_plgsoft_categories($category_array);
				$task = "list";
				$msg_id = "The category is edited successfully";
			} else {
				$categories_database->insert_plgsoft_categories($category_array);
				$task = "list";
				$msg_id = "The category is added successfully";
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
	$total_categories = $categories_database->get_total_plgsoft_categories($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_categories = $categories_database->get_list_plgsoft_categories($array_keywords, $limit, $offset);
	$category_url = get_plgsoft_admin_url(array('page' => 'manage_categories', 'task' => 'add'));
	$list_maincategories = $maincategories_database->get_all_plgsoft_maincategories_by_array_main_category_id($categories_database->get_array_main_category_id());
	?>
	<?php if ($total_categories > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Categories', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Category', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $category_url ); ?>"><?php _e( 'Add Category', 'plgsoft' ) ?></a>
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
						<table class="sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Category Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Main Category Name', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_categories as $category_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_categories', 'category_id' => $category_item['category_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_categories', 'category_id' => $category_item['category_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $category_item['category_id']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>"><?php echo $category_item['category_name']; ?></a>
										</td>
										<td><?php echo $list_maincategories[$category_item['main_category_id']]; ?></td>
										<td class="text-center">
											<?php
											if ($category_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_categories', 'category_id' => $category_item['category_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_categories', 'category_id' => $category_item['category_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($category_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center"><?php echo $category_item['order_listing']; ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_categories, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any category', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Category', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $category_url ); ?>"><?php _e( 'Add Category', 'plgsoft' ) ?></a>
							<?php
							$import_default_url = get_plgsoft_admin_url(array('page' => 'manage_categories', 'task' => 'import_default_data'));
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
	$category_url = get_plgsoft_admin_url(array('page' => 'manage_categories', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($category_id > 0) { ?>
			<h2><?php _e( 'Edit Category', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Category', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Category', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $category_url ); ?>"><?php _e( 'Add Category', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmCategory" name="frmCategory" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="category_id" name="category_id" value="<?php echo $category_id; ?>">
						<?php if ($category_id > 0) { ?>
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
						<div class="row<?php echo (strlen($category_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="category_name"><?php _e( 'Category Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="field-wrap col-10">
								<?php if (strlen($category_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $category_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="category_name" name="category_name" size="70" value="<?php echo esc_attr( $category_name ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($permalink_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="permalink"><?php _e( 'Permalink', 'plgsoft' ) ?></label>
							<div class="field-wrap col-10">
								<?php if (strlen($permalink_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $permalink_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="permalink" name="permalink" size="70" value="<?php echo esc_attr( $permalink ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($order_listing_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="order_listing"><?php _e( 'Order Listing', 'plgsoft' ) ?></label>
							<div class="field-wrap col-10">
								<?php if (strlen($order_listing_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $order_listing_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="order_listing" name="order_listing" size="35" value="<?php echo esc_attr( $order_listing ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($main_category_id_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="main_category_id"><?php _e( 'Main Category Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="field-wrap col-10">
								<?php if (strlen($main_category_id_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $main_category_id_error; ?></label>
								<?php } ?>
								<select id="main_category_id" name="main_category_id" class="main_category_id form-control select">
									<option value=""><?php _e( 'Select main category', 'plgsoft' ) ?></option>
									<?php for ($i = 0; $i < sizeof($list_maincategories); $i++) { ?>
										<?php if($list_maincategories[$i]['main_category_id'] == $main_category_id) { ?>
											<option selected="selected" value="<?php echo $list_maincategories[$i]['main_category_id']; ?>"><?php echo $list_maincategories[$i]['main_category_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $list_maincategories[$i]['main_category_id']; ?>"><?php echo $list_maincategories[$i]['main_category_name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($is_active_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="status"><?php _e( 'Status', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="field-wrap col-10">
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
							<div class="field-wrap col-10">
								<input class="form-control" type="text" id="seo_title" name="seo_title" size="70" value="<?php echo esc_attr( $seo_title ); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="seo_description"><?php _e( 'SEO Description', 'plgsoft' ) ?></label>
							<div class="field-wrap col-10">
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
