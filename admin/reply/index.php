<?php
require_once(wp_plugin_plgsoft_admin_dir . "/reply/reply_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/question/question_database.php");

global $table_name;
$reply_database = new reply_database();
$reply_database->set_table_name($table_name);

$question_database = new question_database();

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_reply';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$reply_id = isset($_REQUEST["reply_id"]) ? trim($_REQUEST["reply_id"]) : 0;
$is_validate = false;
$reply_name_error = '';
$reply_description_error = '';
$order_listing_error = '';
$is_active_error = '';
$category_id_error = '';
$question_id_error = '';
$user_id_error = '';

$array_yes_no_property = get_array_yes_no_plgsoft_property();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_reply', 'keyword' => $keyword));

if ($task == 'delete') {
	$reply_database->delete_plgsoft_reply($reply_id);
	$task = "list";
	$msg_id = "The reply is deleted successfully";
} elseif ($task == 'active') {
	$reply_database->active_plgsoft_reply($reply_id);
	$task = "list";
	$msg_id = "The reply is actived";
} elseif ($task == 'deactive') {
	$reply_database->deactive_plgsoft_reply($reply_id);
	$task = "list";
	$msg_id = "The reply is deactived";
} else {
	if ($is_save==0) {
		if ($reply_id==0) {
			$reply_id = isset($_POST["reply_id"]) ? trim($_POST["reply_id"]) : 0;
			$reply_name = isset($_POST["reply_name"]) ? trim($_POST["reply_name"]) : "";
			$reply_description = isset($_POST["reply_description"]) ? trim($_POST["reply_description"]) : "";
			$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
			$category_id = isset($_POST["category_id"]) ? trim($_POST["category_id"]) : "";
			$question_id = isset($_POST["question_id"]) ? trim($_POST["question_id"]) : "";
			$user_id = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : "";
		} else {
			$reply_obj = $reply_database->get_plgsoft_reply_by_reply_id($reply_id);
			$reply_name = $reply_obj['reply_name'];
			$reply_description = $reply_obj['reply_description'];
			$order_listing = $reply_obj['order_listing'];
			$is_active = $reply_obj['is_active'];
			$category_id = $reply_obj['category_id'];
			$question_id = $reply_obj['question_id'];
			$user_id = $reply_obj['user_id'];
			$reply_id = $reply_obj['reply_id'];
		}
		$question_list = $question_database->get_list_plgsoft_question_by_category_id($category_id);
	} else {
		$reply_name = isset($_POST["reply_name"]) ? trim($_POST["reply_name"]) : "";
		$reply_description = isset($_POST["reply_description"]) ? trim($_POST["reply_description"]) : "";
		$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
		$is_active = isset($_POST["is_active"]) ? 1 : 0;
		$category_id = isset($_POST["category_id"]) ? trim($_POST["category_id"]) : "";
		$question_id = isset($_POST["question_id"]) ? trim($_POST["question_id"]) : "";
		$user_id = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : "";

		$question_list = $question_database->get_list_plgsoft_question_by_category_id($category_id);

		$check_exist = $reply_database->check_exist_reply_name($reply_name, $question_id, $category_id, $reply_id);
		if ((strlen($reply_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($reply_name) == 0) {
				$is_validate = false;
				$reply_name_error = "Reply Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$reply_name_error = "Reply Name is existed";
				}
			}
		}
		if ((strlen($category_id) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($category_id) == 0) {
				$is_validate = false;
				$category_id_error = "Category is empty";
			}
		}
		if ((strlen($question_id) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($question_id) == 0) {
				$is_validate = false;
				$question_id_error = "Question is empty";
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
		if ((strlen($is_active) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($is_active) == 0) {
				$is_validate = false;
				$is_active_error = "Status is empty";
			}
		}
		if ($is_validate) {
			$reply_array = array();
			$reply_array['reply_name'] = $reply_name;
			$reply_array['reply_description'] = $reply_description;
			$reply_array['order_listing'] = $order_listing;
			$reply_array['is_active'] = $is_active;
			$reply_array['category_id'] = $category_id;
			$reply_array['question_id'] = $question_id;
			$reply_array['user_id'] = $user_id;
			if ($reply_id > 0) {
				$reply_array['reply_id'] = $reply_id;
				$reply_database->update_plgsoft_reply($reply_array);
				$task = "list";
				$msg_id = "The reply is edited successfully";
			} else {
				$reply_database->insert_plgsoft_reply($reply_array);
				$task = "list";
				$msg_id = "The reply is added successfully";
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
	$total_reply = $reply_database->get_total_plgsoft_reply($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_reply = $reply_database->get_list_plgsoft_reply($array_keywords, $limit, $offset);
	$reply_url = get_plgsoft_admin_url(array('page' => 'manage_reply', 'task' => 'add'));

	$array_questions = $question_database->get_all_plgsoft_question_by_array_question_id($reply_database->get_array_question_id());
	$array_question_categories = get_array_question_categories();
	?>
	<?php if ($total_reply > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Reply', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Reply', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $reply_url ); ?>"><?php _e( 'Add Reply', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="post" action="<?php echo $manage_list_url; ?>" id="frmSearch" name="frmSearch">
								<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
								<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
								<input type="hidden" id="task" name="task" value="<?php echo $task; ?>">
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
						<table class="table sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Reply Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Question Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Business Category', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_reply as $reply_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_reply', 'reply_id' => $reply_item['reply_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_reply', 'reply_id' => $reply_item['reply_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $reply_item['reply_id']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $reply_item['reply_name']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php
												$question_name = isset($array_questions[$reply_item['question_id']]) ? $array_questions[$reply_item['question_id']] : "";
												echo $question_name;
												?>
											</a>
										</td>
										<td>
											<a href="<?php echo $edit_link; ?>">
												<?php
												$category_name = isset($array_question_categories[$reply_item['category_id']]) ? $array_question_categories[$reply_item['category_id']] : "";
												echo $category_name;
												?>
											</a>
										</td>
										<td class="text-center"><?php echo $reply_item['order_listing']; ?></td>
										<td class="text-center">
											<?php
											if ($reply_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_reply', 'reply_id' => $reply_item['reply_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_reply', 'reply_id' => $reply_item['reply_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($reply_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
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
							$class_Pagings = new class_Pagings($start, $total_reply, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any reply', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Reply', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $reply_url ); ?>"><?php _e( 'Add Reply', 'plgsoft' ) ?></a>
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
	$reply_url = get_plgsoft_admin_url(array('page' => 'manage_reply', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($reply_id > 0) { ?>
			<h2><?php _e( 'Edit Reply', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Reply', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Reply', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $reply_url ); ?>"><?php _e( 'Add Reply', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmReply" name="frmReply" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="reply_id" name="reply_id" value="<?php echo $reply_id; ?>">
						<?php if ($reply_id > 0) { ?>
							<input type="hidden" id="task" name="task" value="edit">
							<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
						<?php } else { ?>
							<input type="hidden" id="task" name="task" value="add">
							<input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
						<?php } ?>
						<input type="hidden" id="table_name" name="table_name" value="<?php echo $table_name; ?>">
						<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
						<div class="row">
							<label for="required"><?php _e( '* Required', 'plgsoft' ) ?></label>
						</div>
						<div class="row<?php echo (strlen($reply_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="reply_name"><?php _e( 'Reply Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($reply_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $reply_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="reply_name" name="reply_name" size="70" value="<?php echo esc_attr( $reply_name ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($reply_description_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="reply_description"><?php _e( 'Description', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($reply_description_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $reply_description_error; ?></label>
								<?php } ?>
								<textarea class="form-control textarea" id="reply_description" name="reply_description" rows="7" cols="70"><?php echo esc_html($reply_description); ?></textarea>
							</div>
						</div>
						<div class="row<?php echo (strlen($category_id_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="category_id"><?php _e( 'Business Category', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($category_id_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $category_id_error; ?></label>
								<?php } ?>
								<?php $business_categories = categories_checkbox_list(); ?>
								<select id="category_id" name="category_id" class="is_active form-control select">
									<option value=""><?php _e( 'Select Business Category', 'plgsoft' ) ?></option>
									<?php foreach ($business_categories as $category) { ?>
										<?php if ($category->parent == 0) { ?>
											<?php $check_category_id = ""; ?>
											<?php if (isset($category_id) && ($category->term_id == $category_id)) { ?>
												<?php $check_category_id = 'selected="selected"'; ?>
											<?php } ?>
											<option <?php echo $check_category_id; ?> value="<?php echo $category->term_id; ?>">
												<?php echo $category->name; ?>
											</option>
											<?php foreach ($business_categories as $category_child) { ?>
												<?php if ($category_child->parent == $category->term_id) { ?>
													<?php $check_category_id = ""; ?>
													<?php if (isset($category_id) && ($category_child->term_id == $category_id)) { ?>
														<?php $check_category_id = 'selected="selected"'; ?>
													<?php } ?>
													<option <?php echo $check_category_id; ?> value="<?php echo $category_child->term_id; ?>">
														<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;' .$category_child->name; ?>
													</option>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($question_id_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="question_id"><?php _e( 'Question', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($question_id_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $question_id_error; ?></label>
								<?php } ?>
								<select id="question_id" name="question_id" class="is_active form-control select">
									<option value=""><?php _e( 'Select Question', 'plgsoft' ) ?></option>
									<?php foreach ($question_list as $question_item) { ?>
										<?php if(isset($question_item['question_id']) && ($question_item['question_id'] == $question_id)) { ?>
											<option selected="selected" value="<?php echo $question_item['question_id']; ?>"><?php echo $question_item['question_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $question_item['question_id']; ?>"><?php echo $question_item['question_name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($order_listing_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="order_listing"><?php _e( 'Order Listing', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($order_listing_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $order_listing_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="order_listing" name="order_listing" size="35" value="<?php echo $order_listing; ?>" />
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
