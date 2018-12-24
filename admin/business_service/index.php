<?php
require_once(wp_plugin_plgsoft_admin_dir . "/business_service/business_service_database.php");

global $table_name;
$business_service_database = new business_service_database();
$business_service_database->set_table_name($table_name);

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_business_service';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$business_service_id = isset($_REQUEST["business_service_id"]) ? trim($_REQUEST["business_service_id"]) : 0;
$is_validate = false;
$business_service_name_error = ''; $is_active_error = ''; $permalink_error = '';

$array_yes_no_property = get_array_yes_no_plgsoft_property();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_business_service', 'keyword' => $keyword));

if ($task == 'delete') {
	$business_service_database->delete_plgsoft_business_service($business_service_id);
	$task = "list";
	$msg_id = "The business service is deleted successfully";
} elseif ($task == 'import_default_data') {
	$array_business_service[] = array('business_service_name' => 'creative');
	$array_business_service[] = array('business_service_name' => 'cause');
	$array_business_service[] = array('business_service_name' => 'entrepreneurial');

	$business_service_array = array();
	for($i=0; $i<sizeof($array_business_service); $i++) {
		$business_service_array['business_service_name'] = $array_business_service[$i]['business_service_name'];
		$business_service_array['permalink'] = get_plgsoft_permalink($array_business_service[$i]['business_service_name']);
		$business_service_array['is_active'] = 1;
		$business_service_array['seo_title'] = $array_business_service[$i]['business_service_name'];
		$business_service_array['seo_description'] = $array_business_service[$i]['business_service_name'];
		$business_service_database->insert_plgsoft_business_service($business_service_array);
	}
	$task = "list";
	$msg_id = "These business service are imported successfully";
} elseif ($task == 'active') {
	$business_service_database->active_plgsoft_business_service($business_service_id);
	$task = "list";
	$msg_id = "The business service is actived";
} elseif ($task == 'deactive') {
	$business_service_database->deactive_plgsoft_business_service($business_service_id);
	$task = "list";
	$msg_id = "The business service is deactived";
} else {
	if ($is_save==0) {
		if ($business_service_id==0) {
			$business_service_id = isset($_POST["business_service_id"]) ? trim($_POST["business_service_id"]) : 0;
			$business_service_name = isset($_POST["business_service_name"]) ? trim($_POST["business_service_name"]) : "";
			$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
			$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
			$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";
		} else {
			$business_service_obj = $business_service_database->get_plgsoft_business_service_by_business_service_id($business_service_id);
			$business_service_name = $business_service_obj['business_service_name'];
			$permalink = $business_service_obj['permalink'];
			$is_active = $business_service_obj['is_active'];
			$business_service_id = $business_service_obj['business_service_id'];
			$seo_title = $business_service_obj['seo_title'];
			$seo_description = $business_service_obj['seo_description'];
		}
	} else {
		$business_service_name = isset($_POST["business_service_name"]) ? trim($_POST["business_service_name"]) : "";
		$permalink = isset($_POST["permalink"]) ? trim($_POST["permalink"]) : "";
		$is_active = isset($_POST["is_active"]) ? 1 : 0;
		$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
		$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";

		$check_exist = $business_service_database->check_exist_business_service_name($business_service_name, $business_service_id);
		if ((strlen($business_service_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($business_service_name) == 0) {
				$is_validate = false;
				$business_service_name_error = "Business Service Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$business_service_name_error = "Business Service Name is existed";
				}
			}
		}
		$check_exist_permalink = $business_service_database->check_exist_permalink($permalink, $business_service_id);
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
		if ($is_validate) {
			$business_service_array = array();
			$business_service_array['business_service_name'] = $business_service_name;
			$business_service_array['permalink'] = $permalink;
			$business_service_array['is_active'] = $is_active;
			if (!isset($seo_title) || (isset($seo_title) && (strlen($seo_title) == 0))) $seo_title = $business_service_name;
			if (!isset($seo_description) || (isset($seo_description) && (strlen($seo_description) == 0))) $seo_description = $business_service_name;
			$business_service_array['seo_title'] = $seo_title;
			$business_service_array['seo_description'] = $seo_description;
			if ($business_service_id > 0) {
				$business_service_array['business_service_id'] = $business_service_id;
				$business_service_database->update_plgsoft_business_service($business_service_array);
				$task = "list";
				$msg_id = "The business service is edited successfully";
			} else {
				$business_service_database->insert_plgsoft_business_service($business_service_array);
				$task = "list";
				$msg_id = "The business service is added successfully";
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
	$total_business_service = $business_service_database->get_total_plgsoft_business_service($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_business_service = $business_service_database->get_list_plgsoft_business_service($array_keywords, $limit, $offset);
	$business_service_url = get_plgsoft_admin_url(array('page' => 'manage_business_service', 'task' => 'add'));
	?>
	<?php if ($total_business_service > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Business Service', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Business Service', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $business_service_url ); ?>"><?php _e( 'Add Business Service', 'plgsoft' ) ?></a>
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
								<th scope="col"><?php _e( 'Business Service Name', 'plgsoft' ) ?></th>
								<th scope="col"><?php _e( 'Permalink', 'plgsoft' ) ?></th>
								<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
								<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
							</tr>
							</thead>
							<tbody>
								<?php foreach ($list_business_service as $business_service_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_business_service', 'business_service_id' => $business_service_item['business_service_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_business_service', 'business_service_id' => $business_service_item['business_service_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $business_service_item['business_service_id']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>"><?php echo $business_service_item['business_service_name']; ?></a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>"><?php echo $business_service_item['permalink']; ?></a>
										</td>
										<td class="text-center">
											<?php
											if ($business_service_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_business_service', 'business_service_id' => $business_service_item['business_service_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_business_service', 'business_service_id' => $business_service_item['business_service_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($business_service_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
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
							$class_Pagings = new class_Pagings($start, $total_business_service, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any business service', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Business Service', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $business_service_url ); ?>"><?php _e( 'Add Business Service', 'plgsoft' ) ?></a>
							<?php
							$import_default_url = get_plgsoft_admin_url(array('page' => 'manage_business_service', 'task' => 'import_default_data'));
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
	$business_service_url = get_plgsoft_admin_url(array('page' => 'manage_business_service', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($business_service_id > 0) { ?>
			<h2><?php _e( 'Edit Business Service', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Business Service', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Business Service', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $business_service_url ); ?>"><?php _e( 'Add Business Service', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmBusinessService" name="frmBusinessService" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="business_service_id" name="business_service_id" value="<?php echo $business_service_id; ?>">
						<?php if ($business_service_id > 0) { ?>
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
						<div class="row<?php echo (strlen($business_service_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="business_service_name"><?php _e( 'Business Service Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="field-wrap col-10">
								<?php if (strlen($business_service_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $business_service_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="business_service_name" name="business_service_name" size="70" value="<?php echo esc_attr( $business_service_name ); ?>" />
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
