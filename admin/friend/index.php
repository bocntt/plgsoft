<?php
require_once(wp_plugin_plgsoft_admin_dir . "/friend/friend_database.php");

global $table_name;
$friend_database = new friend_database();
$friend_database->set_table_name($table_name);

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_friend';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$friend_id = isset($_REQUEST["friend_id"]) ? trim($_REQUEST["friend_id"]) : 0;
$is_validate = false;
$user_id_error = ''; $user_friend_id_error = '';

$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_friend', 'keyword' => $keyword));

if ($task == 'delete') {
	$friend_database->delete_plgsoft_friend($friend_id);
	$task = "list";
	$msg_id = "The friend is deleted successfully";
} else {
	if ($is_save==0) {
		if ($friend_id == 0) {
			$friend_id = isset($_POST["friend_id"]) ? trim($_POST["friend_id"]) : 0;
			$user_id = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : 0;
			if (strlen($user_id) == 0) $user_id = 0;
			$user_friend_id = isset($_POST["user_friend_id"]) ? trim($_POST["user_friend_id"]) : 0;
			if (strlen($user_friend_id) == 0) $user_friend_id = 0;
		} else {
			$friend_obj = $friend_database->get_plgsoft_friend_by_friend_id($friend_id);
			$friend_id = $friend_obj['friend_id'];
			$user_id = $friend_obj['user_id'];
			$user_friend_id = $friend_obj['user_friend_id'];
		}
	} else {
		$user_id = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : 0;
		if (strlen($user_id) == 0) $user_id = 0;
		$user_friend_id = isset($_POST["user_friend_id"]) ? trim($_POST["user_friend_id"]) : 0;
		if (strlen($user_friend_id) == 0) $user_friend_id = 0;

		$check_user_id = check_number_order_listing($user_id);
		if ($check_user_id) {
			$is_validate = true;
		} else {
			if (!$check_user_id) {
				$is_validate = false;
				$user_id_error = "User ID is not number";
			}
		}
		$check_user_friend_id = check_number_order_listing($user_friend_id);
		if ($check_user_friend_id && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_user_friend_id) {
				$is_validate = false;
				$user_friend_id_error = "Friend ID is not number";
			}
		}
		if ($is_validate) {
			$friend_array = array();
			$friend_array['user_id'] = $user_id;
			$friend_array['user_friend_id'] = $user_friend_id;
			if ($friend_id > 0) {
				$friend_array['friend_id'] = $friend_id;
				$friend_database->update_plgsoft_friend($friend_array);
				$task = "list";
				$msg_id = "The friend is edited successfully";
			} else {
				$friend_database->insert_plgsoft_friend($friend_array);
				$task = "list";
				$msg_id = "The friend is added successfully";
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
	$total_friend = $friend_database->get_total_plgsoft_friend($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_friend = $friend_database->get_list_plgsoft_friend($array_keywords, $limit, $offset);
	$friend_url = get_plgsoft_admin_url(array('page' => 'manage_friend', 'task' => 'add'));

	$array_user_id = $friend_database->get_array_user_id();
	$array_user_friend_id = $friend_database->get_array_user_friend_id();
	$array_user_id = array_merge($array_user_id, $array_user_friend_id);
	$users_array = get_users_by_array_user_id($array_user_id);
	?>
	<?php if ($total_friend > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Friend', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Friend', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $friend_url ); ?>"><?php _e( 'Add Friend', 'plgsoft' ) ?></a>
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
							<div style="margin-bottom: 10px; text-align: center; color: blue;"><?php echo $msg_id; ?></div>
						<?php } ?>
						<table class="table sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'User ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Friend ID', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_friend as $friend_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_friend', 'friend_id' => $friend_item['friend_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_friend', 'friend_id' => $friend_item['friend_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $friend_item['friend_id'] ); ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php
												$user_login = isset($users_array[$friend_item['user_id']]['user_login']) ? $users_array[$friend_item['user_id']]['user_login'] : "";
												echo esc_html( $user_login );
												?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php
												$user_login = isset($users_array[$friend_item['user_friend_id']]['user_login']) ? $users_array[$friend_item['user_friend_id']]['user_login'] : "";
												echo esc_html( $user_login );
												?>
											</a>
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
							$class_Pagings = new class_Pagings($start, $total_friend, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any friend', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Friend', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $friend_url ); ?>"><?php _e( 'Add Friend', 'plgsoft' ) ?></a>
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
	$friend_url = get_plgsoft_admin_url(array('page' => 'manage_friend', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($friend_id > 0) { ?>
			<h2><?php _e( 'Edit Friend', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Friend', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Friend', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $friend_url ); ?>"><?php _e( 'Add Friend', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmFriend" name="frmFriend" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="friend_id" name="friend_id" value="<?php echo esc_attr( $friend_id ); ?>">
						<?php if ($friend_id > 0) { ?>
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
						<div class="row<?php echo (strlen($user_id_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="user_id"><?php _e( 'User ID', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($user_id_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $user_id_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="user_id" name="user_id" size="70" value="<?php echo esc_attr( $user_id ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($user_friend_id_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="user_friend_id"><?php _e( 'Friend ID', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($user_friend_id_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $user_friend_id_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="user_friend_id" name="user_friend_id" size="70" value="<?php echo esc_attr( $user_friend_id ); ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<input class="btn btn-primary" type="submit" style="padding: 4px 8px;" id="cmdSave" name="cmdSave" value="<?php _e( 'Save', 'plgsoft' ) ?>" />
								<input class="btn btn-default" type="reset" style="padding: 4px 8px;" id="cmdCancel" name="cmdCancel" value="<?php _e( 'Cancel', 'plgsoft' ) ?>" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
