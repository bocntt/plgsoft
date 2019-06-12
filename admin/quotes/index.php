<?php
require_once(wp_plugin_plgsoft_admin_dir . "/quotes/quotes_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/quotesdetails/quotesdetails_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/question/question_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/answer/answer_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/reply/reply_database.php");

global $table_name;
$quotes_database = new quotes_database();
$quotes_database->set_table_name($table_name);

$array_yes_no_property = get_array_yes_no_plgsoft_property();
$array_quotes_status = get_array_quotes_status();
$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_quotes';
}
$task                 = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save              = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$id                   = isset($_REQUEST["id"]) ? trim($_REQUEST["id"]) : 0;
$is_validate          = false;
$message_error        = ''; $image_error = ''; $status_error = ''; $anything_else_error = '';
$about_yourself_error = '';
$zip_code_error       = '';
$email_address_error  = '';
$phone_number_error   = '';
$full_name_error      = '';
$category_id_error    = '';
$send_date_error      = '';

$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_quotes', 'keyword' => $keyword));

if ($task == 'delete') {
	$quotes_database->delete_plgsoft_quotes($id);
	$quotesdetails_database = new quotesdetails_database();
	$quotesdetails_database->delete_plgsoft_quotesdetails_by_quotes_id($id);
	$task = "list";
	$msg_id = "The quotes is deleted successfully";
} elseif ($task == 'view') {
	$quotes_obj     = $quotes_database->get_plgsoft_quotes_by_id($id);
	$id             = isset($quotes_obj['id']) ? $quotes_obj['id'] : "";
	$from_user      = isset($quotes_obj['from_user']) ? $quotes_obj['from_user'] : "";
	$to_user        = isset($quotes_obj['to_user']) ? $quotes_obj['to_user'] : "";
	$message        = isset($quotes_obj['message']) ? $quotes_obj['message'] : "";
	$image          = isset($quotes_obj['image']) ? $quotes_obj['image'] : "";
	$status         = isset($quotes_obj['status']) ? $quotes_obj['status'] : "";
	$anything_else  = isset($quotes_obj['anything_else']) ? $quotes_obj['anything_else'] : "";
	$about_yourself = isset($quotes_obj['about_yourself']) ? $quotes_obj['about_yourself'] : "";
	$zip_code       = isset($quotes_obj['zip_code']) ? $quotes_obj['zip_code'] : "";
	$email_address  = isset($quotes_obj['email_address']) ? $quotes_obj['email_address'] : "";
	$phone_number   = isset($quotes_obj['phone_number']) ? $quotes_obj['phone_number'] : "";
	$full_name      = isset($quotes_obj['full_name']) ? $quotes_obj['full_name'] : "";
	$category_id    = isset($quotes_obj['category_id']) ? $quotes_obj['category_id'] : 0;
	$send_date      = isset($quotes_obj['send_date']) ? $quotes_obj['send_date'] : "";
	$content      = isset($quotes_obj['content']) ? $quotes_obj['content'] : "";

	if ($category_id == 0) {
		$category_name      = "";
		$total_question     = 0;
		$list_question      = array();
		$array_question_id  = array();
		$list_answer        = array();
		$total_answer       = 0;
		$array_reply        = array();
		$list_quotesdetails = array();
		$array_answer_id    = array();
	} else {
		$category_array = get_term_by('id', $category_id, THEME_TAXONOMY);
		$category_name  = isset($category_array->name) ? $category_array->name : "";

		$quotesdetails_database = new quotesdetails_database();
		$question_database      = new question_database();
		$answer_database        = new answer_database();
		$reply_database         = new reply_database();
		$array_keywords['category_id'] = $category_id;
		$total_question    = $question_database->get_total_plgsoft_question($array_keywords);
		$list_question     = $question_database->get_list_plgsoft_question($array_keywords);
		$array_question_id = $question_database->get_array_question_id();
		$list_answer       = $answer_database->get_all_plgsoft_answer_by_array_question_id($array_question_id);
		$total_answer = sizeof($list_answer);

		$array_reply        = $reply_database->get_all_plgsoft_reply_by_array_question_id($array_question_id);
		$list_quotesdetails = $quotesdetails_database->get_list_plgsoft_quotesdetails(array('quotes_id' => $id));
		$array_answer_id    = $quotesdetails_database->get_array_answer_id();
	}
} else {
	if ($is_save==0) {
		if ($id == 0) {
			$id             = isset($_POST["id"]) ? trim($_POST["id"]) : 0;
			$from_user      = isset($_POST["from_user"]) ? trim($_POST["from_user"]) : 0;
			$to_user        = isset($_POST["to_user"]) ? trim($_POST["to_user"]) : 0;
			$message        = isset($_POST["message"]) ? trim($_POST["message"]) : "";
			$image          = isset($_POST["image"]) ? trim($_POST["image"]) : "";
			$status         = isset($_POST["status"]) ? trim($_POST["status"]) : "";
			$anything_else  = isset($_POST["anything_else"]) ? 1 : 0;
			$about_yourself = isset($_POST["about_yourself"]) ? 1 : 0;
			$zip_code       = isset($_POST["zip_code"]) ? trim($_POST["zip_code"]) : "";
			$email_address  = isset($_POST["email_address"]) ? trim($_POST["email_address"]) : "";
			$phone_number   = isset($_POST["phone_number"]) ? trim($_POST["phone_number"]) : "";
			$full_name      = isset($_POST["full_name"]) ? trim($_POST["full_name"]) : "";
			$category_id    = isset($_POST["category_id"]) ? trim($_POST["category_id"]) : 0;
			$send_date      = isset($_POST["send_date"]) ? trim($_POST["send_date"]) : "";
		} else {
			$quotes_obj     = $quotes_database->get_plgsoft_quotes_by_id($id);
			$id             = $quotes_obj['id'];
			$from_user      = $quotes_obj['from_user'];
			$to_user        = $quotes_obj['to_user'];
			$message        = $quotes_obj['message'];
			$image          = $quotes_obj['image'];
			$status         = $quotes_obj['status'];
			$anything_else  = $quotes_obj['anything_else'];
			$about_yourself = $quotes_obj['about_yourself'];
			$zip_code       = $quotes_obj['zip_code'];
			$email_address  = $quotes_obj['email_address'];
			$phone_number   = $quotes_obj['phone_number'];
			$full_name      = $quotes_obj['full_name'];
			$category_id    = $quotes_obj['category_id'];
			$send_date      = $quotes_obj['send_date'];
		}
	} else {
		$from_user      = isset($_POST["from_user"]) ? trim($_POST["from_user"]) : 0;
		$to_user        = isset($_POST["to_user"]) ? trim($_POST["to_user"]) : 0;
		$message        = isset($_POST["message"]) ? trim($_POST["message"]) : "";
		$image          = isset($_POST["image"]) ? trim($_POST["image"]) : "";
		$status         = isset($_POST["status"]) ? trim($_POST["status"]) : "";
		$anything_else  = isset($_POST["anything_else"]) ? 1 : 0;
		$about_yourself = isset($_POST["about_yourself"]) ? 1 : 0;
		$zip_code       = isset($_POST["zip_code"]) ? trim($_POST["zip_code"]) : "";
		$email_address  = isset($_POST["email_address"]) ? trim($_POST["email_address"]) : "";
		$phone_number   = isset($_POST["phone_number"]) ? trim($_POST["phone_number"]) : "";
		$full_name      = isset($_POST["full_name"]) ? trim($_POST["full_name"]) : "";
		$category_id    = isset($_POST["category_id"]) ? trim($_POST["category_id"]) : 0;
		$send_date      = isset($_POST["send_date"]) ? trim($_POST["send_date"]) : date('Y-m-d');

		if (strlen($full_name) > 0) {
			$is_validate = true;
		} else {
			$is_validate = false;
			$full_name_error = "Full Name is empty";
		}
		if ((strlen($email_address) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($email_address) == 0) {
				$is_validate = false;
				$email_address_error = "Email Address is empty";
			}
		}
		if ((strlen($phone_number) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($phone_number) == 0) {
				$is_validate = false;
				$phone_number_error = "Phone Number is empty";
			}
		}
		if ((strlen($zip_code) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($zip_code) == 0) {
				$is_validate = false;
				$zip_code_error = "Zip Code is empty";
			}
		}
		if ((strlen($message) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($message) == 0) {
				$is_validate = false;
				$message_error = "Status is empty";
			}
		}
		if ($is_validate) {
			$quotes_array     = array();
			$quotes_array['from_user']      = $from_user;
			$quotes_array['to_user']        = $to_user;
			$quotes_array['message']        = $message;
			$quotes_array['image']          = $image;
			$quotes_array['status']         = $status;
			$quotes_array['anything_else']  = $anything_else;
			$quotes_array['about_yourself'] = $about_yourself;
			$quotes_array['zip_code']       = $zip_code;
			$quotes_array['email_address']  = $email_address;
			$quotes_array['phone_number']   = $phone_number;
			$quotes_array['full_name']      = $full_name;
			$quotes_array['category_id']    = $category_id;
			$quotes_array['send_date']      = $send_date;
			if ($id > 0) {
				$quotes_array['id'] = $id;
				$quotes_database->update_plgsoft_quotes($quotes_array);
				$task = "list";
				$msg_id = "The quotes is edited successfully";
			} else {
				$quotes_database->insert_plgsoft_quotes($quotes_array);
				$task = "list";
				$msg_id = "The quotes is added successfully";
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
	$total_quotes = $quotes_database->get_total_plgsoft_quotes($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;

	$list_quotes     = $quotes_database->get_list_plgsoft_quotes($array_keywords, $limit, $offset);
	$quotes_url      = get_plgsoft_admin_url(array('page' => 'manage_quotes', 'task' => 'add'));
	$array_from_user = $quotes_database->get_array_from_user();
	$array_to_user   = $quotes_database->get_array_to_user();
	$array_user_id   = array_merge($array_from_user, $array_to_user);
	$users_array     = get_users_by_array_user_id($array_user_id);
	?>
	<?php if ($total_quotes > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Quotes', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Quotes', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $quotes_url ); ?>"><?php _e( 'Add Quotes', 'plgsoft' ) ?></a>
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
									<th scope="col"><?php _e( 'From User', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'To User', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Message', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Download Attachment', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Send Date', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_quotes as $quotes_item) { ?>
									<?php
									$view_link = get_plgsoft_admin_url(array('page' => 'manage_quotes', 'id' => $quotes_item['id'], 'task' => 'view', 'keyword' => $keyword, 'start' => $start));
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_quotes', 'id' => $quotes_item['id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_quotes', 'id' => $quotes_item['id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo esc_html( $quotes_item['id'] ); ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php
												$user_login = isset($users_array[$quotes_item['from_user']]['user_login']) ? $users_array[$quotes_item['from_user']]['user_login'] : "";
												echo esc_html( $user_login );
												?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php
												$user_login = isset($users_array[$quotes_item['to_user']]['user_login']) ? $users_array[$quotes_item['to_user']]['user_login'] : "";
												echo esc_html( $user_login );
												?>
											</a>
										</td>
										<td class="text-justify"><?php echo esc_html( $quotes_item['message'] ); ?></td>
										<td class="text-right">
											<?php if(isset($quotes_item['image']) && (strlen($quotes_item['image']) > 0)) { ?>
												<a target="_blank" href="<?php echo esc_url( $quotes_item['image'] ); ?>"><?php _e( 'Download Attachment', 'plgsoft' ) ?></a>
											<?php } ?>
										</td>
										<td class="text-right"><?php echo esc_html( $array_quotes_status[$quotes_item['status']] ); ?></td>
										<td class="text-center"><?php if (strlen($quotes_item['send_date']) > 0) : echo esc_html( date('Y-m-d', strtotime($quotes_item['send_date'])) ); else: echo esc_html( date('Y-m-d') ); endif;?></td>
										<td class="text-right">
											<a class="btn btn-success" href="<?php echo esc_url( $view_link ); ?>"><i class="fa fa-fw fa-eye"></i></a>
											<a class="btn btn-primary" href="<?php echo esc_url( $edit_link ); ?>"><i class="fa fa-fw fa-edit"></i></a>
											<a class="btn btn-danger" href="<?php echo esc_url( $delete_link ); ?>"><i class="fa fa-fw fa-trash"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<div class="row text-center">
							<?php
							$class_Pagings = new class_Pagings($start, $total_quotes, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any quotes', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Quotes', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $quotes_url ); ?>"><?php _e( 'Add Quotes', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
								<input type="hidden" id="page" name="page" value="<?php echo esc_attr( $page ); ?>">
								<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
								<input type="hidden" id="task" name="task" value="<?php echo esc_attr( $task ); ?>">
								<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
								<input class="form-control" type="text" id="keyword" name="keyword" size="40" value="<?php echo esc_attr($keyword); ?>" />
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
<?php } elseif ($task=='view') {
	$quotes_url      = get_plgsoft_admin_url(array('page' => 'manage_quotes', 'task' => 'add'));
	?>
	<div class="wrap">
		<h2><?php _e( 'View Quotes', 'plgsoft' ) ?></h2>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Quotes', 'plgsoft' ) ?></a>
					<a href="<?php echo esc_url( $quotes_url ); ?>"><?php _e( 'Add Quotes', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmQuotes" name="frmQuotes" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="id" name="id" value="<?php echo esc_attr( $id ); ?>">
						<input type="hidden" id="task" name="task" value="view">
						<input type="hidden" id="start" name="start" value="<?php echo esc_attr( $start ); ?>">
						<input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
						<table class="table" width="100%">
							<tbody>
								<tr>
									<td width="15%"><b><?php _e( 'ID', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html($id); ?></td>
								</tr>
								<tr>
									<td width="15%"><b><?php _e( 'From User', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html($from_user); ?></td>
								</tr>
								<tr>
									<td width="15%"><b><?php _e( 'To User', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html($to_user); ?></td>
								</tr>
								<tr>
									<td width="15%"><b><?php _e( 'Full Name', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html($full_name); ?></td>
								</tr>
								<tr>
									<td width="15%"><b><?php _e( 'Email Address', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html($email_address); ?></td>
								</tr>
								<tr>
									<td width="15%"><b><?php _e( 'Phone Number', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html($phone_number); ?></td>
								</tr>
								<tr>
									<td width="15%"><b><?php _e( 'Zip Code', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html($zip_code); ?></td>
								</tr>
								<tr>
									<td valign="top"><b><?php _e( 'Message', 'plgsoft' ) ?></b></td>
									<td valign="top"><?php echo esc_html($message); ?></td>
								</tr>
								<tr>
									<td valign="top"><b><?php _e( 'Content', 'plgsoft' ) ?></b></td>
									<td valign="top"><?php echo esc_html($content); ?></td>
								</tr>
								<tr>
									<td><b><?php _e( 'Download Attachment', 'plgsoft' ) ?></b></td>
									<td>
										<?php if(isset($image) && (strlen($image) > 0)) { ?>
											<a target="_blank" href="<?php echo esc_url( $image ); ?>"><?php _e( 'Download Attachment', 'plgsoft' ) ?></a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td><b><?php _e( 'Is there anything else the business should know?', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html( $array_yes_no_property[$anything_else] ); ?></td>
								</tr>
								<tr>
									<td><b><?php _e( 'Your information', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html( $array_yes_no_property[$about_yourself] ); ?></td>
								</tr>
								<tr>
									<td><b><?php _e( 'Status', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html( $array_quotes_status[$status] ); ?></td>
								</tr>
								<tr>
									<td><b><?php _e( 'Send Date', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html( $send_date ); ?></td>
								</tr>
								<tr>
									<td><b><?php _e( 'Category', 'plgsoft' ) ?></b></td>
									<td><?php echo esc_html( $category_name ); ?></td>
								</tr>
								<tr>
									<td style="vertical-align: top;"><b><?php _e( 'Question/Answer', 'plgsoft' ) ?></b></td>
									<td>
										<?php $quotes_string = get_view_quotes($total_question, $list_question, $list_answer, $array_answer_id, $array_reply, $quotes_obj, $category_name); ?>
										<?php echo $quotes_string; ?>
										<?php
										// Testing send emails
										$emailTo = 'bocntt01@gmail.com';
										$subject = 'Get Quotes';
										$message = $quotes_string;
										$emailID = "admin";
										$wlt_emails = get_option("wlt_emails");
										$headers[] = "Content-Type: text/html; charset=\"" .get_option('blog_charset') . "\"\n";
										// $headers[] = 'From: '.$from_name.' <'.$wlt_emails[$emailID]['from_email'].'>';
										// $headers[] .= 'Bcc: '.$bbc_name.' <'.$wlt_emails[$emailID]['bcc_email'].'>';
										wp_mail($emailTo, stripslashes($subject), stripslashes(wpautop($message)), $headers);
										?>
									</td>
								</tr>
								<tr>
									<td align="right"></td>
									<td><a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Back', 'plgsoft' ) ?></a></td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } else {
	$quotes_url      = get_plgsoft_admin_url(array('page' => 'manage_quotes', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if ($id > 0) { ?>
			<h2><?php _e( 'Edit Quotes', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Quotes', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Quotes', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $quotes_url ); ?>"><?php _e( 'Add Quotes', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmQuotes" name="frmQuotes" enctype="multipart/form-data">
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
						<div class="row">
							<label for="required"><?php _e( '* Required', 'plgsoft' ) ?></label>
						</div>
						<div class="row<?php echo (strlen($full_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="full_name"><?php _e( 'Full Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($full_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $full_name_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="full_name" name="full_name" size="70" value="<?php echo esc_attr($full_name); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($email_address_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="email_address"><?php _e( 'Email Address', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($email_address_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $email_address_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="email_address" name="email_address" size="70" value="<?php echo esc_attr($email_address); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($phone_number_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="phone_number"><?php _e( 'Phone Number', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($phone_number_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $phone_number_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="phone_number" name="phone_number" size="70" value="<?php echo esc_attr( $phone_number ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($zip_code_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="zip_code"><?php _e( 'Zip Code', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($zip_code_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $zip_code_error ); ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="zip_code" name="zip_code" size="30" value="<?php echo esc_attr( $zip_code ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($message_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="message"><?php _e( 'Message', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($message_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $message_error ); ?></label>
								<?php } ?>
								<textarea class="form-control textarea" id="message" name="message" rows="10" cols="70"><?php echo esc_html( $message ); ?></textarea>
							</div>
						</div>
						<?php if(isset($image) && (strlen($image) > 0)) { ?>
							<div class="row<?php echo (strlen($image_error) > 0) ? ' has-error' : ''; ?>">
								<label class="col-2" for="images"><?php _e( 'Download Attachment', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
								<div class="col-10 field-wrap">
									<?php if (strlen($image_error) > 0) { ?>
										<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $image_error ); ?></label>
									<?php } ?>
									<input type="hidden" id="image" name="image" size="70" value="<?php echo esc_attr( $image ); ?>" />
									<a target="_blank" href="<?php echo esc_url( $image ); ?>"><?php _e( 'Download Attachment', 'plgsoft' ) ?></a>
								</div>
							</div>
						<?php } ?>
						<div class="row<?php echo (strlen($anything_else_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="anything_else"><?php _e( 'Is there anything else the business should know?', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($anything_else_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $anything_else_error ); ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="anything_else" id="anything_else" <?php echo ($anything_else == 1) ? 'checked="checked"' : ''; ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="row<?php echo (strlen($about_yourself_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="about_yourself"><?php _e( 'Your information', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($about_yourself_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo esc_html( $about_yourself_error ); ?></label>
								<?php } ?>
								<label class="field-switch">
									<input type="checkbox" onchange="plgsoftChangeStatus(this);" name="about_yourself" id="about_yourself" <?php echo ($about_yourself == 1) ? 'checked="checked"' : ''; ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
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
