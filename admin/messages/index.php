<?php
require_once(wp_plugin_plgsoft_admin_dir . "/messages/messages_database.php");

global $table_name;
$messages_database = new messages_database();
$messages_database->set_table_name($table_name);

$array_messages_status = get_array_messages_status();
$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_messages';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$messages_id = isset($_REQUEST["messages_id"]) ? trim($_REQUEST["messages_id"]) : 0;
$is_validate = false;
$messages_name_error = ''; $username_error = ''; $messages_title_error = ''; $email_error = ''; $phone_error = '';
$message_error = ''; $status_error = ''; $user_id_error = ''; $to_user_id_error = ''; $post_id_error = ''; $ref_error = '';

$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_messages', 'keyword' => $keyword));

if ($task == 'delete') {
	$messages_database->delete_plgsoft_messages($messages_id);
	$task = "list";
	$msg_id = "The messages is deleted successfully";
} else {
	if ($is_save==0) {
		if ($messages_id == 0) {
			$messages_id    = isset($_POST["messages_id"]) ? trim($_POST["messages_id"]) : 0;
			$messages_title = isset($_POST["messages_title"]) ? trim($_POST["messages_title"]) : "";
			$messages_name  = isset($_POST["messages_name"]) ? trim($_POST["messages_name"]) : "";
			$username       = isset($_POST["username"]) ? trim($_POST["username"]) : "";
			$email          = isset($_POST["email"]) ? trim($_POST["email"]) : "";
			$phone          = isset($_POST["phone"]) ? trim($_POST["phone"]) : 0;
			if (strlen($phone) == 0) $phone = 0;
			$message = isset($_POST["message"]) ? trim($_POST["message"]) : "";
			$status  = isset($_POST["status"]) ? trim($_POST["status"]) : "";
			$user_id = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : 0;
			if (strlen($user_id) == 0) $user_id = 0;
			$to_user_id = isset($_POST["to_user_id"]) ? trim($_POST["to_user_id"]) : 0;
			if (strlen($to_user_id) == 0) $to_user_id = 0;
			$post_id = isset($_POST["post_id"]) ? trim($_POST["post_id"]) : 0;
			if (strlen($post_id) == 0) $post_id = 0;
			$ref = isset($_POST["ref"]) ? trim($_POST["ref"]) : "";
		} else {
			$messages_obj = $messages_database->get_plgsoft_messages_by_messages_id($messages_id);
			$messages_id    = $messages_obj['messages_id'];
			$messages_title = $messages_obj['messages_title'];
			$messages_name  = $messages_obj['messages_name'];
			$username       = $messages_obj['username'];
			$email          = $messages_obj['email'];
			$phone          = $messages_obj['phone'];
			$message        = $messages_obj['message'];
			$status         = $messages_obj['status'];
			$user_id        = $messages_obj['user_id'];
			$to_user_id     = $messages_obj['to_user_id'];
			$post_id        = $messages_obj['post_id'];
			$ref            = $messages_obj['ref'];
		}
	} else {
		$messages_title = isset($_POST["messages_title"]) ? trim($_POST["messages_title"]) : "";
		$messages_name  = isset($_POST["messages_name"]) ? trim($_POST["messages_name"]) : "";
		$username       = isset($_POST["username"]) ? trim($_POST["username"]) : "";
		$email          = isset($_POST["email"]) ? trim($_POST["email"]) : "";
		$phone          = isset($_POST["phone"]) ? trim($_POST["phone"]) : 0;
		if (strlen($phone) == 0) $phone = 0;
		$message = isset($_POST["message"]) ? trim($_POST["message"]) : "";
		$status  = isset($_POST["status"]) ? trim($_POST["status"]) : "";
		$user_id = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : 0;
		if (strlen($user_id) == 0) $user_id = 0;
		$to_user_id = isset($_POST["to_user_id"]) ? trim($_POST["to_user_id"]) : 0;
		if (strlen($to_user_id) == 0) $to_user_id = 0;
		$post_id = isset($_POST["post_id"]) ? trim($_POST["post_id"]) : 0;
		if (strlen($post_id) == 0) $post_id = 0;
		$ref = isset($_POST["ref"]) ? trim($_POST["ref"]) : "";

		if (strlen($messages_title) > 0) {
			$is_validate = true;
		} else {
			$is_validate = false;
			$messages_title_error = "Messages Title is empty";
		}
		if ((strlen($messages_name) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($messages_name) == 0) {
				$is_validate = false;
				$messages_name_error = "Messages Name is empty";
			}
		}
		if ((strlen($phone) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($phone) == 0) {
				$is_validate = false;
				$phone_error = "Phone is empty";
			}
		}
		if ((strlen($message) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($message) == 0) {
				$is_validate = false;
				$message_error = "Messages is empty";
			}
		}
		if ((strlen($status) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($status) == 0) {
				$is_validate = false;
				$status_error = "Status is empty";
			}
		}
		if ($is_validate) {
			$messages_array = array();
			$messages_array['messages_title'] = $messages_title;
			$messages_array['messages_name']  = $messages_name;
			$messages_array['username']       = $username;
			$messages_array['email']          = $email;
			$messages_array['phone']          = $phone;
			$messages_array['message']        = $message;
			$messages_array['status']         = $status;
			$messages_array['user_id']        = $user_id;
			$messages_array['to_user_id']     = $to_user_id;
			$messages_array['post_id']        = $post_id;
			$messages_array['ref']            = $ref;
			if ($messages_id > 0) {
				$messages_array['messages_id'] = $messages_id;
				$messages_database->update_plgsoft_messages($messages_array);
				$task = "list";
				$msg_id = "The messages is edited successfully";
			} else {
				$messages_database->insert_plgsoft_messages($messages_array);
				$task = "list";
				$msg_id = "The messages is added successfully";
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
	$total_messages = $messages_database->get_total_plgsoft_messages($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_messages = $messages_database->get_list_plgsoft_messages($array_keywords, $limit, $offset);
	$messages_url = get_plgsoft_admin_url(array('page' => 'manage_messages', 'task' => 'add'));

	$posts_array = get_post_listings_by_array_post_id($messages_database->get_array_post_id());
	?>
	<?php if ($total_messages > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Messages', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Messages', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $messages_url ); ?>"><?php _e( 'Add Messages', 'plgsoft' ) ?></a>
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
									<th scope="col"><?php _e( 'Messages Title', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Messages Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Email', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Phone', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_messages as $messages_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_messages', 'messages_id' => $messages_item['messages_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_messages', 'messages_id' => $messages_item['messages_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $messages_item['messages_id'] ); ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $messages_item['messages_title'] ); ?>
											</a>
										</td>
										<td><?php echo esc_html( $messages_item['messages_name'] ); ?></td>
										<td><?php echo esc_html( $messages_item['email'] ); ?></td>
										<td class="text-right"><?php echo esc_html( $messages_item['phone'] ); ?></td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php
												$post_title = isset($posts_array[$messages_item['post_id']]['post_title']) ? $posts_array[$messages_item['post_id']]['post_title'] : "";
												echo esc_html( $post_title );
												?>
											</a>
										</td>
										<td class="text-right"><?php echo esc_html( $messages_item['status'] ); ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_messages, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any messages', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Messages', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $messages_url ); ?>"><?php _e( 'Add Messages', 'plgsoft' ) ?></a>
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
	$messages_url = get_plgsoft_admin_url(array('page' => 'manage_messages', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($messages_id > 0) { ?>
			<h2><?php _e( 'Edit Messages', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Messages', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Messages', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $messages_url ); ?>"><?php _e( 'Add Messages', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmMessages" name="frmMessages" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="messages_id" name="messages_id" value="<?php echo esc_attr( $messages_id ); ?>">
						<?php if ($messages_id > 0) { ?>
							<input type="hidden" id="task" name="task" value="edit">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } else { ?>
							<input type="hidden" id="task" name="task" value="add">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } ?>
						<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
						<input type="hidden" id="username" name="username" value="<?php echo esc_attr( $username ); ?>">
						<input type="hidden" id="user_id" name="user_id" size="35" value="<?php echo esc_attr( $user_id ); ?>" />
						<input type="hidden" id="to_user_id" name="to_user_id" value="<?php echo esc_attr( $to_user_id ); ?>">
						<input type="hidden" id="post_id" name="post_id" size="70" value="<?php echo esc_attr( $post_id ); ?>" />
						<div class="row">
							<label for="required"><?php _e( '* Required', 'plgsoft' ) ?></label>
						</div>
						<div class="row<?php echo (strlen($messages_title_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="messages_title"><?php _e( 'Messages Title', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($messages_title_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $messages_title_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="messages_title" name="messages_title" size="70" value="<?php echo esc_attr( $messages_title ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($messages_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="message_name"><?php _e( 'Messages Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($messages_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $messages_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="messages_name" name="messages_name" size="70" value="<?php echo esc_attr( $messages_name ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($email_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="email"><?php _e( 'Email', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($email_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $email_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="email" name="email" size="70" value="<?php echo esc_attr( $email ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($phone_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="phone"><?php _e( 'Phone', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($phone_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $phone_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="phone" name="phone" size="70" value="<?php echo esc_attr( $phone ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($message_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="message"><?php _e( 'Message', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($message_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $message_error; ?></label>
								<?php } ?>
								<textarea class="form-control textarea" id="message" name="message" rows="5" cols="70"><?php echo esc_attr( $message ); ?></textarea>
							</div>
						</div>
						<div class="row<?php echo (strlen($status_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="status"><?php _e( 'Status', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($status_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $status_error; ?></label>
								<?php } ?>
								<select id="status" name="status" class="is_active form-control select">
									<option value=""><?php _e( 'Select Status', 'plgsoft' ) ?></option>
									<?php foreach ($array_messages_status as $key => $value) { ?>
										<?php if($key == $status) { ?>
											<option selected="selected" value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
										<?php } else { ?>
											<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($ref_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="ref"><?php _e( 'Ref Link', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($ref_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $ref_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="ref" name="ref" size="70" value="<?php echo esc_attr( $ref ); ?>" />
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
