<?php
require_once(wp_plugin_plgsoft_admin_dir . "/quotesmeta/quotesmeta_database.php");

global $table_name;
$quotesmeta_database = new quotesmeta_database();
$quotesmeta_database->set_table_name($table_name);

$array_quotes_status = get_array_quotes_status();
$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_quotesmeta';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$id = isset($_REQUEST["id"]) ? trim($_REQUEST["id"]) : 0;
$is_validate = false;
$content_error = ''; $estimate_error = ''; $attachment_error = '';
$quotes_id_error = ''; $status_error = '';

$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_quotesmeta', 'keyword' => $keyword));

if ($task == 'delete') {
	$quotesmeta_database->delete_plgsoft_quotesmeta($id);
	$task = "list";
	$msg_id = "The quotes meta is deleted successfully";
} else {
	if ($is_save==0) {
		if ($id == 0) {
			$id         = isset($_POST["id"]) ? trim($_POST["id"]) : 0;
			$estimate   = isset($_POST["estimate"]) ? trim($_POST["estimate"]) : "";
			$content    = isset($_POST["content"]) ? trim($_POST["content"]) : "";
			$attachment = isset($_POST["attachment"]) ? trim($_POST["attachment"]) : "";
			$quotes_id  = isset($_POST["quotes_id"]) ? trim($_POST["quotes_id"]) : 0;
			$from_user  = isset($_POST["from_user"]) ? trim($_POST["from_user"]) : 0;
			$to_user    = isset($_POST["to_user"]) ? trim($_POST["to_user"]) : 0;
			$status     = isset($_POST["status"]) ? trim($_POST["status"]) : "";
			$time       = isset($_POST["time"]) ? trim($_POST["time"]) : "";
		} else {
			$quotesmeta_obj = $quotesmeta_database->get_plgsoft_quotesmeta_by_id($id);
			$id         = $quotesmeta_obj['id'];
			$estimate   = $quotesmeta_obj['estimate'];
			$content    = $quotesmeta_obj['content'];
			$attachment = $quotesmeta_obj['attachment'];
			$quotes_id  = $quotesmeta_obj['quotes_id'];
			$from_user  = $quotesmeta_obj['from_user'];
			$to_user    = $quotesmeta_obj['to_user'];
			$status     = $quotesmeta_obj['status'];
			$time       = $quotesmeta_obj['time'];
		}
	} else {
		$estimate   = isset($_POST["estimate"]) ? trim($_POST["estimate"]) : "";
		$content    = isset($_POST["content"]) ? trim($_POST["content"]) : "";
		$attachment = isset($_POST["attachment"]) ? trim($_POST["attachment"]) : "";
		$quotes_id  = isset($_POST["quotes_id"]) ? trim($_POST["quotes_id"]) : 0;
		$from_user  = isset($_POST["from_user"]) ? trim($_POST["from_user"]) : 0;
		$to_user    = isset($_POST["to_user"]) ? trim($_POST["to_user"]) : 0;
		$status     = isset($_POST["status"]) ? trim($_POST["status"]) : "";
		$time       = isset($_POST["time"]) ? trim($_POST["time"]) : date('Y-m-d H:i:s');

		if (strlen($estimate) > 0) {
			$is_validate = true;
		} else {
			if (strlen($estimate) == 0) {
				$is_validate = false;
				$estimate_error = "Estimate is empty";
			}
		}
		if ((strlen($content) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			$is_validate = false;
			$content_error = "Content is empty";
		}
		if ($is_validate) {
			$quotesmeta_array = array();
			$quotesmeta_array['estimate']   = $estimate;
			$quotesmeta_array['content']    = $content;
			$quotesmeta_array['attachment'] = $attachment;
			$quotesmeta_array['quotes_id']  = $quotes_id;
			$quotesmeta_array['from_user']  = $from_user;
			$quotesmeta_array['to_user']    = $to_user;
			$quotesmeta_array['status']     = $status;
			$quotesmeta_array['time']       = (strlen($time) != 0) ? $time : date('Y-m-d H:i:s');
			if ($id > 0) {
				$quotesmeta_array['id'] = $id;
				$quotesmeta_database->update_plgsoft_quotesmeta($quotesmeta_array);
				$task = "list";
				$msg_id = "The quotes meta is edited successfully";
			} else {
				$quotesmeta_database->insert_plgsoft_quotesmeta($quotesmeta_array);
				$task = "list";
				$msg_id = "The quotes meta is added successfully";
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
	$total_quotesmeta = $quotesmeta_database->get_total_plgsoft_quotesmeta($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_quotesmeta = $quotesmeta_database->get_list_plgsoft_quotesmeta($array_keywords, $limit, $offset);
	$quotesmeta_url = get_plgsoft_admin_url(array('page' => 'manage_quotesmeta', 'task' => 'add'));
	$array_from_user = $quotesmeta_database->get_array_from_user();
	$array_to_user = $quotesmeta_database->get_array_to_user();
	$array_user_id = array_merge($array_from_user, $array_to_user);
	$users_array = get_users_by_array_user_id($array_user_id);
	?>
	<?php if ($total_quotesmeta > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Quotes Meta', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Quotes Meta', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $quotesmeta_url ); ?>"><?php _e( 'Add Quotes Meta', 'plgsoft' ) ?></a>
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
							<div class="message"><?php echo esc_html( $msg_id ); ?></div>
						<?php } ?>
						<table class="table sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Estimate', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Content', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Attachment', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'From User', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'To User', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Time', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_quotesmeta as $quotesmeta_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_quotesmeta', 'id' => $quotesmeta_item['id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_quotesmeta', 'id' => $quotesmeta_item['id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $quotesmeta_item['id'] ); ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $quotesmeta_item['estimate'] ); ?>
											</a>
										</td>
										<td class="text-justify"><?php echo esc_html( $quotesmeta_item['content'] ); ?></td>
										<td>
											<?php if(isset($quotesmeta_item['attachment']) && (strlen($quotesmeta_item['attachment']) > 0)){ ?>
												<a target="_blank" href="<?php echo esc_url( $quotesmeta_item['attachment'] ); ?>"><?php _e( 'Download Attachment', 'plgsoft' ) ?></a>
											<?php } ?>
										</td>
										<td class="text-right">
											<?php
											$user_login = isset($users_array[$quotesmeta_item['from_user']]['user_login']) ? $users_array[$quotesmeta_item['from_user']]['user_login'] : "";
											echo esc_html( $user_login );
											?>
										</td>
										<td class="text-right">
											<?php
											$user_login = isset($users_array[$quotesmeta_item['to_user']]['user_login']) ? $users_array[$quotesmeta_item['to_user']]['user_login'] : "";
											echo esc_html( $user_login );
											?>
										</td>
										<td class="text-right"><?php echo esc_html( $array_quotes_status[$quotesmeta_item['status']] ); ?></td>
										<td class="text-center"><?php echo esc_html( date("m-d-Y", strtotime($quotesmeta_item['time'])) ); ?></td>
										<td class="text-right">
											<a class="btn btn-primary" href="<?php echo esc_url( $edit_link ); ?>"><i class="fa fa-fw fa-edit"></i></a>
											<a class="btn btn-danger" href="<?php echo esc_url( $delete_link ); ?>"><i class="fa fa-fw fa-trash"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<div class="text-center">
							<?php
							$class_Pagings = new class_Pagings($start, $total_quotesmeta, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any quotes meta', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Quotes Meta', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $quotesmeta_url ); ?>"><?php _e( 'Add Quotes Meta', 'plgsoft' ) ?></a>
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
							<div style="margin-bottom: 10px; text-align: center; color: blue;"><?php echo esc_html( $msg_id ); ?></div>
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
	$quotesmeta_url = get_plgsoft_admin_url(array('page' => 'manage_quotesmeta', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($id > 0) { ?>
			<h2><?php _e( 'Edit Quotes Meta', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Quotes Meta', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Quotes Meta', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $quotesmeta_url ); ?>"><?php _e( 'Add Quotes Meta', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmQuotesMeta" name="frmQuotesMeta" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="id" name="id" value="<?php echo esc_attr( $id ); ?>">
						<?php if ($id > 0) { ?>
							<input type="hidden" id="task" name="task" value="edit">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } else { ?>
							<input type="hidden" id="task" name="task" value="add">
							<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<?php } ?>
						<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
						<input type="hidden" id="from_user" name="from_user" value="<?php echo esc_attr( $from_user ); ?>" />
						<input type="hidden" id="to_user" name="to_user" value="<?php echo esc_attr( $to_user ); ?>" />
						<input type="hidden" id="time" name="time" value="<?php echo esc_attr( $time ); ?>" />
						<input type="hidden" id="quotes_id" name="quotes_id" value="<?php echo esc_attr( $quotes_id ); ?>" />
						<div class="row">
							<label for="required"><?php _e( '* Required', 'plgsoft' ) ?></label>
						</div>
						<div class="row<?php echo (strlen($estimate_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="estimate"><?php _e( 'Estimate', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($estimate_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $estimate_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="estimate" name="estimate" size="70" value="<?php echo esc_attr( $estimate ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($content_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="content"><?php _e( 'Content', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($content_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $content_error; ?></label>
								<?php } ?>
								<textarea class="form-control textarea" id="content" name="content" rows="10" cols="70"><?php echo esc_attr( $content ); ?></textarea>
							</div>
						</div>
						<?php if(isset($attachment) && (strlen($attachment) > 0)){ ?>
							<div class="row<?php echo (strlen($attachment_error) > 0) ? ' has-error' : ''; ?>">
								<label class="col-2" for="attachment"><?php _e( 'Attachment', 'plgsoft' ) ?></label>
								<div class="col-10 field-wrap">
									<?php if (strlen($attachment_error) > 0) { ?>
										<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $attachment_error; ?></label>
									<?php } ?>
									<input type="hidden" id="attachment" name="attachment" size="70" value="<?php echo esc_attr( $attachment ); ?>" />
									<a target="_blank" href="<?php echo esc_url( $attachment ); ?>"><?php _e( 'Download Attachment', 'plgsoft' ) ?></a>
								</div>
							</div>
						<?php } ?>
						<div class="row<?php echo (strlen($status_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="status"><?php _e( 'Status', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($status_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $status_error ); ?></label>
								<?php } ?>
								<select id="status" name="status" class="is_active form-control select">
									<?php foreach ($array_quotes_status as $key => $value) { ?>
										<?php if($key == $status) { ?>
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
