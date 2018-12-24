<?php
require_once(wp_plugin_plgsoft_admin_dir . "/question/question_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/answer/answer_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/reply/reply_database.php");

global $table_name;
$question_database = new question_database();
$question_database->set_table_name($table_name);

$answer_database = new answer_database();
$reply_database = new reply_database();

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_question';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$question_id = isset($_REQUEST["question_id"]) ? trim($_REQUEST["question_id"]) : 0;
$is_validate = false;
$question_name_error = '';
$question_description_error = '';
$question_type_error = '';
$have_other_answer_error = '';
$order_listing_error = '';
$is_optional_error = '';
$is_active_error = '';
$category_id_error = '';

$array_yes_no_property = get_array_yes_no_plgsoft_property();
$array_question_type = get_array_question_type();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_question', 'keyword' => $keyword));

if ($task == 'delete') {
	$question_database->delete_plgsoft_question($question_id);
	$answer_database->delete_plgsoft_answer_by_question_id($question_id);
	$reply_database->delete_plgsoft_reply_by_question_id($question_id);
	$task = "list";
	$msg_id = "The question is deleted successfully";
} elseif ($task == 'active') {
	$question_database->active_plgsoft_question($question_id);
	$task = "list";
	$msg_id = "The question is actived";
} elseif ($task == 'deactive') {
	$question_database->deactive_plgsoft_question($question_id);
	$task = "list";
	$msg_id = "The question is deactived";
} else {
	if ($is_save==0) {
		if ($question_id==0) {
			$question_id          = isset($_POST["question_id"]) ? trim($_POST["question_id"]) : 0;
			$question_name        = isset($_POST["question_name"]) ? trim($_POST["question_name"]) : "";
			$question_description = isset($_POST["question_description"]) ? trim($_POST["question_description"]) : "";
			$question_type        = isset($_POST["question_type"]) ? trim($_POST["question_type"]) : "";
			$have_other_answer    = isset($_POST["have_other_answer"]) ? 1 : 0;
			$order_listing        = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
			if (strlen($order_listing) == 0) $order_listing = 0;
			$is_optional = isset($_POST["is_optional"]) ? 1 : 0;
			$is_active   = isset($_POST["is_active"]) ? 1 : 0;
			$category_id = isset($_POST["category_id"]) ? trim($_POST["category_id"]) : "";
		} else {
			$question_obj = $question_database->get_plgsoft_question_by_question_id($question_id);
			$question_name        = $question_obj['question_name'];
			$question_description = $question_obj['question_description'];
			$question_type        = $question_obj['question_type'];
			$have_other_answer    = $question_obj['have_other_answer'];
			$order_listing        = $question_obj['order_listing'];
			$is_optional          = $question_obj['is_optional'];
			$is_active            = $question_obj['is_active'];
			$category_id          = $question_obj['category_id'];
			$question_id          = $question_obj['question_id'];
		}
	} else {
		$question_name        = isset($_POST["question_name"]) ? trim($_POST["question_name"]) : "";
		$question_description = isset($_POST["question_description"]) ? trim($_POST["question_description"]) : "";
		$question_type        = isset($_POST["question_type"]) ? trim($_POST["question_type"]) : "";
		$have_other_answer    = isset($_POST["have_other_answer"]) ? 1 : 0;
		$order_listing        = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
		if (strlen($order_listing) == 0) $order_listing = 0;
		$is_optional = isset($_POST["is_optional"]) ? 1 : 0;
		$is_active   = isset($_POST["is_active"]) ? 1 : 0;
		$category_id = isset($_POST["category_id"]) ? trim($_POST["category_id"]) : "";

		$check_exist = $question_database->check_exist_question_name($question_name, $category_id, $question_id);
		if ((strlen($question_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($question_name) == 0) {
				$is_validate = false;
				$question_name_error = "Question Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$question_name_error = "Question Name is existed";
				}
			}
		}
		if ((strlen($question_type) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($question_type) == 0) {
				$is_validate = false;
				$question_type_error = "Question Type is empty";
			}
		}
		if ((strlen($have_other_answer) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($have_other_answer) == 0) {
				$is_validate = false;
				$have_other_answer_error = "Other Answer is empty";
			}
		}
		if ((strlen($category_id) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($category_id) == 0) {
				$is_validate = false;
				$category_id_error = "Business Category is empty";
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
		if ((strlen($is_optional) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($is_optional) == 0) {
				$is_validate = false;
				$is_optional_error = "Optional is empty";
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
			$question_array = array();
			$question_array['question_name']        = $question_name;
			$question_array['question_description'] = $question_description;
			$question_array['question_type']        = $question_type;
			$question_array['have_other_answer']    = $have_other_answer;
			$question_array['order_listing']        = $order_listing;
			$question_array['is_optional']          = $is_optional;
			$question_array['is_active']            = $is_active;
			$question_array['category_id']          = $category_id;
			if ($question_id > 0) {
				$question_array['question_id'] = $question_id;
				$question_database->update_plgsoft_question($question_array);
				$task = "list";
				$msg_id = "The question is edited successfully";
			} else {
				$question_database->insert_plgsoft_question($question_array);
				$task = "list";
				$msg_id = "The question is added successfully";
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
	$total_question = $question_database->get_total_plgsoft_question($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_question = $question_database->get_list_plgsoft_question($array_keywords, $limit, $offset);
	$question_url = get_plgsoft_admin_url(array('page' => 'manage_question', 'task' => 'add'));

	$list_answer = $answer_database->get_all_plgsoft_answer_by_array_question_id($question_database->get_array_question_id());
	$array_question_categories = get_array_question_categories();
	?>
	<?php if ($total_question > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Question', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Question', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $question_url ); ?>"><?php _e( 'Add Question', 'plgsoft' ) ?></a>
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
						<table class="table sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Question Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Business Category', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Optional', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_question as $question_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_question', 'question_id' => $question_item['question_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_question', 'question_id' => $question_item['question_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $question_item['question_id'] ); ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">Q: <?php echo esc_html( $question_item['question_name'] ); ?></a>
											<?php
											$question_id = $question_item['question_id'];
											$list_each_answer = isset($list_answer[$question_id]) ? $list_answer[$question_id] : array();
											$total_each_answer = sizeof($list_each_answer);
											?>
											<?php $add_answer_link = get_plgsoft_admin_url(array('page' => 'manage_answer', 'question_id' => $question_id, 'task' => 'add', 'keyword' => $keyword, 'start' => $start)); ?>
											<div style="margin-left: 15px;">
												<a href="<?php echo esc_url( $add_answer_link ); ?>"><?php _e( 'Add Answer', 'plgsoft' ) ?></a>
											</div>
											<?php foreach ($list_each_answer as $item_each_answer) { ?>
												<?php $edit_answer_link = get_plgsoft_admin_url(array('page' => 'manage_answer', 'answer_id' => $item_each_answer['answer_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start)); ?>
												<div style="margin-left: 15px;">
													<a href="<?php echo esc_url( $edit_answer_link ); ?>">
														A: <?php echo esc_html( $item_each_answer['answer_name'] ); ?>
													</a>
												</div>
											<?php } ?>
										</td>
										<td>
											<?php
											$category_name = isset($array_question_categories[$question_item['category_id']]) ? $array_question_categories[$question_item['category_id']] : "";
											echo esc_html( $category_name );
											?>
										</td>
										<td class="text-center"><?php echo esc_html( $question_item['order_listing'] ); ?></td>
										<td class="text-center"><?php echo esc_html( $array_yes_no_property[$question_item['is_optional']] ); ?></td>
										<td class="text-center">
											<?php
											if ($question_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_question', 'question_id' => $question_item['question_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_question', 'question_id' => $question_item['question_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($question_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
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
							$class_Pagings = new class_Pagings($start, $total_question, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any question', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Question', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $question_url ); ?>"><?php _e( 'Add Question', 'plgsoft' ) ?></a>
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
	$question_url = get_plgsoft_admin_url(array('page' => 'manage_question', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($question_id > 0) { ?>
			<h2><?php _e( 'Edit Question', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Question', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Question', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $question_url ); ?>"><?php _e( 'Add Question', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmQuestion" name="frmQuestion" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="question_id" name="question_id" value="<?php echo esc_attr( $question_id ); ?>">
						<?php if ($question_id > 0) { ?>
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
						<div class="row<?php echo (strlen($question_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="question_name"><?php _e( 'Question Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($question_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $question_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="question_name" name="question_name" size="70" value="<?php echo esc_attr( $question_name ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($question_description_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="question_description"><?php _e( 'Description', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($question_description_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $question_description_error; ?></label>
								<?php } ?>
								<textarea class="form-control textarea" id="question_description" name="question_description" rows="7" cols="70"><?php echo esc_attr( $question_description ); ?></textarea>
							</div>
						</div>
						<div class="row<?php echo (strlen($question_type_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="question_type"><?php _e( 'Question Type', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($question_type_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $question_type_error; ?></label>
								<?php } ?>
								<select id="question_type" name="question_type" class="is_active form-control select">
									<?php foreach ($array_question_type as $key => $value) { ?>
										<?php if($key == $question_type) { ?>
											<option selected="selected" value="<?php echo esc_attr( $key ); ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo esc_attr( $key ); ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($have_other_answer_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="have_other_answer"><?php _e( 'Other Answer', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($have_other_answer_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $have_other_answer_error; ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="have_other_answer" id="have_other_answer" <?php echo ($have_other_answer == 1) ? 'checked="checked"' : ''; ?>>
									<span class="slider round"></span>
								</label>
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
						<div class="row<?php echo (strlen($order_listing_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="order_listing"><?php _e( 'Order Listing', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($order_listing_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $order_listing_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="order_listing" name="order_listing" size="35" value="<?php echo $order_listing; ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($is_optional_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="is_option"><?php _e( 'Optional', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($is_optional_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $is_optional_error; ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="is_optional" id="is_optional" <?php echo ($is_optional == 1) ? 'checked="checked"' : ''; ?>>
									<span class="slider round"></span>
								</label>
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
