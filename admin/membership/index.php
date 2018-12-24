<?php
require_once(wp_plugin_plgsoft_admin_dir . "/membership/membership_database.php");
require_once(wp_plugin_plgsoft_admin_dir . "/package/package_database.php");
global $table_name;
$membership_database = new membership_database();
$membership_database->set_table_name($table_name);

$package_database = new package_database();
$package_database->set_table_name("plgsoft_package");
$list_package = $package_database->get_list_plgsoft_package();

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_membership';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$membership_id = isset($_REQUEST["membership_id"]) ? trim($_REQUEST["membership_id"]) : "";
$is_validate = false;
$membership_order_error = '';
$membership_price_error = '';
$membership_submissionamount_error = '';
$membership_name_error = '';
$membership_subtext_error = '';
$membership_description_error = '';
$membership_multiple_cats_error = '';
$membership_multiple_images_error = '';
$membership_image_error = '';
$membership_expires_error = '';
$frontpage_error = '';
$featured_error = '';
$html_error = '';
$visitorcounter_error = '';
$topcategory_error = '';
$showgooglemap_error = '';
$is_active_error = '';
$package_id_error = '';
$membership_position_error = '';
$membership_button_error = '';
$is_front_page_error = '';
$array_yes_no_property = get_array_yes_no_plgsoft_property();
$array_access_fields = get_array_access_fields();
$array_position = get_array_position();
$array_button = get_array_button();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_membership', 'keyword' => $keyword));

if ($task == 'delete') {
	$membership_database->delete_plgsoft_membership($membership_id);
	$task = "list";
	$msg_id = "The membership is deleted successfully";
} elseif ($task == 'import_default_data') {
	$array_membership[] = array('membership_order' => '1',
							'membership_price' => '0',
							'membership_submissionamount' => '0',
							'membership_name' => 'Basic Membership',
							'membership_subtext' => 'Business Name, Address, Logo, Short Description, list of services provided,
								choice of 3 business categories. Can only be used for 60 days, after which time listing will expire.',
							'membership_description' => 'Business owner will receive an email 14 days before listing expires and has to login and
								renew listing before the 60 days by clicking on renew listing link or button.
								Business owner will be given choice to upgrade to a better listing package at that time.
								Emails will be sent out monthly by cron job explaining benefits of upgrading to a Standard business package
								and showing a list of all packages available to upgrade.',
							'membership_multiple_cats' => '3',
							'membership_multiple_images' => '1',
							'membership_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
							'membership_expires' => '30',
							'membership_position' => 'left',
							'membership_button' => 'subscribe-for-free',
							'is_front_page' => '1',
							'frontpage' => '1',
							'featured' => '1',
							'html' => '1',
							'visitorcounter' => '1',
							'topcategory' => '1',
							'showgooglemap' => '1',
							'is_active' => '1',
							'package_id' => '1');
	$array_membership[] = array('membership_order' => '2',
							'membership_price' => '9.95',
							'membership_submissionamount' => '9.95',
							'membership_name' => 'Standard Business - Monthly',
							'membership_subtext' => 'Business Name, Address, Logo, Google Map, Short Description, Long Description, Main photo,
								additional photos, Website address link, list of services provided, choice of 3 business categories.',
							'membership_description' => 'Emails will be sent out quarterly by cron job explaining benefits of upgrading to a
								Featured Business package and showing a list of all packages available to upgrade.',
							'membership_multiple_cats' => '3',
							'membership_multiple_images' => '1',
							'membership_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
							'membership_expires' => '30',
							'membership_position' => 'left',
							'membership_button' => 'sign-up-today',
							'is_front_page' => '1',
							'frontpage' => '1',
							'featured' => '1',
							'html' => '1',
							'visitorcounter' => '1',
							'topcategory' => '1',
							'showgooglemap' => '1',
							'is_active' => '1',
							'package_id' => '2');
	$array_membership[] = array('membership_order' => '3',
							'membership_price' => '99.95',
							'membership_submissionamount' => '99.95',
							'membership_name' => 'Standard Business - Yearly',
							'membership_subtext' => 'Business Name, Address, Logo, Google Map, Short Description, Long Description, Main photo,
								additional photos, Website address link, list of services provided, choice of 3 business categories.',
							'membership_description' => 'Emails will be sent out quarterly by cron job explaining benefits of upgrading to a
								Featured Business package and showing a list of all packages available to upgrade.',
							'membership_multiple_cats' => '3',
							'membership_multiple_images' => '1',
							'membership_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
							'membership_expires' => '365',
							'membership_position' => 'right',
							'membership_button' => 'upgrade-today',
							'is_front_page' => '1',
							'frontpage' => '1',
							'featured' => '1',
							'html' => '1',
							'visitorcounter' => '1',
							'topcategory' => '1',
							'showgooglemap' => '1',
							'is_active' => '1',
							'package_id' => '2');
	$array_membership[] = array('membership_order' => '4',
							'membership_price' => '29.95',
							'membership_submissionamount' => '29.95',
							'membership_name' => 'Featured Business - Monthly',
							'membership_subtext' => 'Listing Includes all items of Standard business: Business Name, Address, Logo, Google Map,
								Short Description, Long Description, Main photo, additional photos, Website address link, list of services provided,
								choice of 5 business categories.',
							'membership_description' => 'Plus includes: Videos uploading, Rotating featured listing on all categories selected
								in category pages, list pages and in any services searched as well as social sharing on business listing.<br>
								Emails will be sent out quarterly by cron job explaining benefits of upgrading to a Premium featured package
								and showing a list of all packages available to upgrade.',
							'membership_multiple_cats' => '5',
							'membership_multiple_images' => '1',
							'membership_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
							'membership_expires' => '30',
							'membership_position' => 'left',
							'membership_button' => 'upgrade-today',
							'is_front_page' => '1',
							'frontpage' => '1',
							'featured' => '1',
							'html' => '1',
							'visitorcounter' => '1',
							'topcategory' => '1',
							'showgooglemap' => '1',
							'is_active' => '1',
							'package_id' => '3');
	$array_membership[] = array('membership_order' => '5',
							'membership_price' => '329.95',
							'membership_submissionamount' => '329.95',
							'membership_name' => 'Featured Business - Yearly',
							'membership_subtext' => 'Listing Includes all items of Standard business: Business Name, Address, Logo, Google Map,
								Short Description, Long Description, Main photo, additional photos, Website address link, list of services provided,
								choice of 5 business categories.',
							'membership_description' => 'Plus includes: Videos uploading, Rotating featured listing on all categories selected
								in category pages, list pages and in any services searched as well as social sharing on business listing.<br>
								Emails will be sent out quarterly by cron job explaining benefits of upgrading to a Premium featured package
								and showing a list of all packages available to upgrade.',
							'membership_multiple_cats' => '5',
							'membership_multiple_images' => '1',
							'membership_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
							'membership_expires' => '365',
							'membership_position' => 'right',
							'membership_button' => 'upgrade-today',
							'is_front_page' => '1',
							'frontpage' => '1',
							'featured' => '1',
							'html' => '1',
							'visitorcounter' => '1',
							'topcategory' => '1',
							'showgooglemap' => '1',
							'is_active' => '1',
							'package_id' => '3');
	$array_membership[] = array('membership_order' => '6',
							'membership_price' => '99.95',
							'membership_submissionamount' => '99.95',
							'membership_name' => 'Premium Featured - Monthly',
							'membership_subtext' => 'Listing Includes: Business Name, Address, Logo, Google Map, Short Description, Long Description,
								videos uploading on listing, Main photo, additional photos, Website address link, list of services provided,
								choice of 5 business categories.',
							'membership_description' => 'Plus includes: Rotating featured listing on all categories selected in category pages,
								list pages and in any services searched, social sharing on business listing, featured placement on home page
								of website for your city, placement in monthly newsletters to consumers, placement on plg soft social media monthly.<br>
								Emails will be sent out quarterly by cron job explaining benefits of upgrading to a Get Noticed package.',
							'membership_multiple_cats' => '5',
							'membership_multiple_images' => '1',
							'membership_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
							'membership_expires' => '30',
							'membership_position' => 'left',
							'membership_button' => 'upgrade-today',
							'is_front_page' => '1',
							'frontpage' => '1',
							'featured' => '1',
							'html' => '1',
							'visitorcounter' => '1',
							'topcategory' => '1',
							'showgooglemap' => '1',
							'is_active' => '1',
							'package_id' => '4');
	$array_membership[] = array('membership_order' => '7',
							'membership_price' => '999.95',
							'membership_submissionamount' => '999.95',
							'membership_name' => 'Premium Featured - Yearly',
							'membership_subtext' => 'Listing Includes: Business Name, Address, Logo, Google Map, Short Description, Long Description,
								videos uploading on listing, Main photo, additional photos, Website address link, list of services provided,
								choice of 5 business categories.',
							'membership_description' => 'Plus includes: Rotating featured listing on all categories selected in category pages,
								list pages and in any services searched, social sharing on business listing, featured placement on home page
								of website for your city, placement in monthly newsletters to consumers, placement on plg soft social media monthly.<br>
								Emails will be sent out quarterly by cron job explaining benefits of upgrading to a Get Noticed package.',
							'membership_multiple_cats' => '5',
							'membership_multiple_images' => '1',
							'membership_image' => 'http://www.plgsoft.com/wp-content/themes/main/framework/img/img_package.jpg',
							'membership_expires' => '365',
							'membership_position' => 'right',
							'membership_button' => 'upgrade-today',
							'is_front_page' => '1',
							'frontpage' => '1',
							'featured' => '1',
							'html' => '1',
							'visitorcounter' => '1',
							'topcategory' => '1',
							'showgooglemap' => '1',
							'is_active' => '1',
							'package_id' => '4');

	$membership_array = array();
	for($i=0; $i<sizeof($array_membership); $i++) {
		$membership_array['membership_order'] = $i;
		$membership_array['membership_price'] = $array_membership[$i]['membership_price'];
		$membership_array['membership_submissionamount'] = $array_membership[$i]['membership_submissionamount'];
		$membership_array['membership_name'] = $array_membership[$i]['membership_name'];
		$membership_array['membership_subtext'] = $array_membership[$i]['membership_subtext'];
		$membership_array['membership_description'] = $array_membership[$i]['membership_description'];
		$membership_array['membership_multiple_cats'] = $array_membership[$i]['membership_multiple_cats'];
		$membership_array['membership_multiple_images'] = $array_membership[$i]['membership_multiple_images'];
		$membership_array['membership_image'] = $array_membership[$i]['membership_image'];
		$membership_array['membership_expires'] = $array_membership[$i]['membership_expires'];
		$membership_array['membership_position'] = $array_membership[$i]['membership_position'];
		$membership_array['membership_button'] = $array_membership[$i]['membership_button'];
		$membership_array['is_front_page'] = $array_membership[$i]['is_front_page'];
		$membership_array['frontpage'] = $array_membership[$i]['frontpage'];
		$membership_array['featured'] = $array_membership[$i]['featured'];
		$membership_array['html'] = $array_membership[$i]['html'];
		$membership_array['visitorcounter'] = $array_membership[$i]['visitorcounter'];
		$membership_array['topcategory'] = $array_membership[$i]['topcategory'];
		$membership_array['showgooglemap'] = $array_membership[$i]['showgooglemap'];
		$membership_array['is_active'] = $array_membership[$i]['is_active'];
		$membership_array['package_id'] = $array_membership[$i]['package_id'];
		$membership_database->insert_plgsoft_membership($membership_array);
	}
	$task = "list";
	$msg_id = "These membership are imported successfully";
} elseif ($task == 'active') {
	$membership_database->active_plgsoft_membership($membership_id);
	$task = "list";
	$msg_id = "The membership is actived";
} elseif ($task == 'deactive') {
	$membership_database->deactive_plgsoft_membership($membership_id);
	$task = "list";
	$msg_id = "The membership is deactived";
} else {
	if ($is_save==0) {
		if (strlen($membership_id)==0) {
			$membership_id               = isset($_POST["membership_id"]) ? trim($_POST["membership_id"]) : "";
			$membership_order            = isset($_POST["membership_order"]) ? trim($_POST["membership_order"]) : 0;
			$membership_price            = isset($_POST["membership_price"]) ? trim($_POST["membership_price"]) : 0;
			$membership_submissionamount = isset($_POST["membership_submissionamount"]) ? trim($_POST["membership_submissionamount"]) : 0;
			$membership_name             = isset($_POST["membership_name"]) ? trim($_POST["membership_name"]) : "";
			$membership_subtext          = isset($_POST["membership_subtext"]) ? trim($_POST["membership_subtext"]) : "";
			$membership_description      = isset($_POST["membership_description"]) ? trim($_POST["membership_description"]) : "";
			$membership_multiple_cats    = isset($_POST["membership_multiple_cats"]) ? trim($_POST["membership_multiple_cats"]) : "";
			$membership_multiple_images  = isset($_POST["membership_multiple_images"]) ? trim($_POST["membership_multiple_images"]) : "";
			$membership_image            = isset($_POST["membership_image"]) ? trim($_POST["membership_image"]) : "";
			$membership_expires          = isset($_POST["membership_expires"]) ? trim($_POST["membership_expires"]) : 0;
			$frontpage                   = isset($_POST["frontpage"]) ? trim($_POST["frontpage"]) : 0;
			$featured                    = isset($_POST["featured"]) ? trim($_POST["featured"]) : 0;
			$html                        = isset($_POST["html"]) ? trim($_POST["html"]) : 0;
			$visitorcounter              = isset($_POST["visitorcounter"]) ? trim($_POST["visitorcounter"]) : 0;
			$topcategory                 = isset($_POST["topcategory"]) ? trim($_POST["topcategory"]) : 0;
			$showgooglemap               = isset($_POST["showgooglemap"]) ? trim($_POST["showgooglemap"]) : 0;
			$is_active                   = isset($_POST["is_active"]) ? 1 : 0;
			$package_id                  = isset($_POST["package_id"]) ? trim($_POST["package_id"]) : 0;
			$membership_access_fields    = isset($_POST['membership_access_fields']) ? $_POST['membership_access_fields'] : array();
			$membership_position         = isset($_POST['membership_position']) ? $_POST['membership_position'] : "";
			$membership_button           = isset($_POST['membership_button']) ? $_POST['membership_button'] : "";
			$is_front_page               = isset($_POST['is_front_page']) ? $_POST['is_front_page'] : 0;
		} else {
			$membership_obj = $membership_database->get_plgsoft_membership_by_membership_id($membership_id);
			$membership_id               = $membership_obj['membership_id'];
			$membership_order            = $membership_obj['membership_order'];
			$membership_price            = $membership_obj['membership_price'];
			$membership_submissionamount = $membership_obj['membership_submissionamount'];
			$membership_name             = $membership_obj['membership_name'];
			$membership_subtext          = $membership_obj['membership_subtext'];
			$membership_description      = $membership_obj['membership_description'];
			$membership_multiple_cats    = $membership_obj['membership_multiple_cats'];
			$membership_multiple_images  = $membership_obj['membership_multiple_images'];
			$membership_image            = $membership_obj['membership_image'];
			$membership_expires          = $membership_obj['membership_expires'];
			$membership_access_fields    = $membership_obj['membership_access_fields'];
			$membership_position         = $membership_obj['membership_position'];
			$membership_button           = $membership_obj['membership_button'];
			$is_front_page               = $membership_obj['is_front_page'];
			$frontpage                   = $membership_obj['frontpage'];
			$featured                    = $membership_obj['featured'];
			$html                        = $membership_obj['html'];
			$visitorcounter              = $membership_obj['visitorcounter'];
			$topcategory                 = $membership_obj['topcategory'];
			$showgooglemap               = $membership_obj['showgooglemap'];
			$is_active                   = $membership_obj['is_active'];
			$package_id                  = $membership_obj['package_id'];
			if (strlen($membership_access_fields) > 0) {
				$membership_access_fields = explode(",", $membership_access_fields);
			} else {
				$membership_access_fields = array();
			}
		}
	} else {
		$membership_order            = isset($_POST["membership_order"]) ? trim($_POST["membership_order"]) : 0;
		$membership_price            = isset($_POST["membership_price"]) ? trim($_POST["membership_price"]) : 0;
		$membership_submissionamount = isset($_POST["membership_submissionamount"]) ? trim($_POST["membership_submissionamount"]) : 0;
		$membership_name             = isset($_POST["membership_name"]) ? trim($_POST["membership_name"]) : "";
		$membership_subtext          = isset($_POST["membership_subtext"]) ? trim($_POST["membership_subtext"]) : "";
		$membership_description      = isset($_POST["membership_description"]) ? trim($_POST["membership_description"]) : "";
		$membership_multiple_cats    = isset($_POST["membership_multiple_cats"]) ? trim($_POST["membership_multiple_cats"]) : "";
		$membership_multiple_images  = isset($_POST["membership_multiple_images"]) ? trim($_POST["membership_multiple_images"]) : "";
		$membership_image            = isset($_POST["membership_image"]) ? trim($_POST["membership_image"]) : "";
		$membership_expires          = isset($_POST["membership_expires"]) ? trim($_POST["membership_expires"]) : 0;
		$frontpage                   = isset($_POST["frontpage"]) ? trim($_POST["frontpage"]) : 0;
		$featured                    = isset($_POST["featured"]) ? trim($_POST["featured"]) : 0;
		$html                        = isset($_POST["html"]) ? trim($_POST["html"]) : 0;
		$visitorcounter              = isset($_POST["visitorcounter"]) ? trim($_POST["visitorcounter"]) : 0;
		$topcategory                 = isset($_POST["topcategory"]) ? trim($_POST["topcategory"]) : 0;
		$showgooglemap               = isset($_POST["showgooglemap"]) ? trim($_POST["showgooglemap"]) : 0;
		$is_active                   = isset($_POST["is_active"]) ? 1 : 0;
		$package_id                  = isset($_POST["package_id"]) ? trim($_POST["package_id"]) : 0;
		$membership_access_fields    = isset($_POST['membership_access_fields']) ? $_POST['membership_access_fields'] : array();
		$membership_position         = isset($_POST['membership_position']) ? $_POST['membership_position'] : "";
		$membership_button           = isset($_POST['membership_button']) ? $_POST['membership_button'] : "";
		$is_front_page               = isset($_POST['is_front_page']) ? $_POST['is_front_page'] : 0;

		$check_exist = $membership_database->check_exist_membership_name($membership_name, $membership_id);
		if ((strlen($membership_name) > 0) && !$check_exist) {
			$is_validate = true;
		} else {
			if (strlen($membership_name) == 0) {
				$is_validate = false;
				$membership_name_error = "Membership Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$membership_name_error = "Membership Name is existed";
				}
			}
		}

		$check_membership_order = check_number_order_listing($membership_order);
		if ($check_membership_order && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_membership_order) {
				$is_validate = false;
				$membership_order_error = "Order Listing is not number";
			}
		}

		$check_membership_price = check_number_price($membership_price);
		if ($check_membership_price && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_membership_price) {
				$is_validate = false;
				$membership_price_error = "Price is not number";
			}
		}

		$check_membership_submissionamount = check_number_price($membership_submissionamount);
		if ($check_membership_submissionamount && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_membership_submissionamount) {
				$is_validate = false;
				$membership_submissionamount_error = "Submission Amount is not number";
			}
		}

		$check_membership_multiple_cats = check_number_order_listing($membership_multiple_cats);
		if ($check_membership_multiple_cats && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_membership_multiple_cats) {
				$is_validate = false;
				$membership_multiple_cats_error = "Multiple Categories is not number";
			}
		}

		$check_membership_multiple_images = check_number_order_listing($membership_multiple_images);
		if ($check_membership_multiple_images && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_membership_multiple_images) {
				$is_validate = false;
				$membership_multiple_images_error = "Multiple Images is not number";
			}
		}

		$check_membership_expires = check_number_order_listing($membership_expires);
		if ($check_membership_expires && $is_validate) {
			$is_validate = true;
		} else {
			if (!$check_membership_expires) {
				$is_validate = false;
				$membership_expires_error = "Multiple Images is not number";
			}
		}

		if ((strlen($frontpage) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($frontpage) == 0) {
				$is_validate = false;
				$frontpage_error = "Front Page Exposure is empty";
			}
		}
		if ((strlen($featured) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($featured) == 0) {
				$is_validate = false;
				$featured_error = "Highlighted Listing is empty";
			}
		}
		if ((strlen($html) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($html) == 0) {
				$is_validate = false;
				$html_error = "HTML Listing Content is empty";
			}
		}
		if ((strlen($visitorcounter) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($visitorcounter) == 0) {
				$is_validate = false;
				$visitorcounter_error = "Visitor Counter is empty";
			}
		}
		if ((strlen($topcategory) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($topcategory) == 0) {
				$is_validate = false;
				$topcategory_error = "Top of Category Results Page is empty";
			}
		}
		if ((strlen($showgooglemap) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($showgooglemap) == 0) {
				$is_validate = false;
				$showgooglemap_error = "Google Map is empty";
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
		if ((strlen($package_id) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($package_id) == 0) {
				$is_validate = false;
				$package_id_error = "Package is empty";
			}
		}

		if ((strlen($membership_position) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($membership_position) == 0) {
				$is_validate = false;
				$membership_position_error = "Position is empty";
			}
		}
		if ((strlen($membership_button) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($membership_button) == 0) {
				$is_validate = false;
				$membership_button_error = "Button is empty";
			}
		}
		if ((strlen($is_front_page) > 0) && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($is_front_page) == 0) {
				$is_validate = false;
				$is_front_page_error = "Front Page is empty";
			}
		}
		if ($is_validate) {
			$membership_array = array();
			$membership_array['membership_order'] = $membership_order;
			$membership_array['membership_price'] = $membership_price;
			$membership_array['membership_submissionamount'] = $membership_submissionamount;
			$membership_array['membership_name'] = $membership_name;
			$membership_array['membership_subtext'] = $membership_subtext;
			$membership_array['membership_description'] = $membership_description;
			$membership_array['membership_multiple_cats'] = $membership_multiple_cats;
			$membership_array['membership_multiple_images'] = $membership_multiple_images;
			$membership_array['membership_image'] = $membership_image;
			$membership_array['membership_expires'] = $membership_expires;
			$membership_access_fields = implode(",", $membership_access_fields);
			$membership_array['membership_access_fields'] = $membership_access_fields;
			$membership_array['membership_position'] = $membership_position;
			$membership_array['membership_button'] = $membership_button;
			$membership_array['is_front_page'] = $is_front_page;
			$membership_array['frontpage'] = $frontpage;
			$membership_array['featured'] = $featured;
			$membership_array['html'] = $html;
			$membership_array['visitorcounter'] = $visitorcounter;
			$membership_array['topcategory'] = $topcategory;
			$membership_array['showgooglemap'] = $showgooglemap;
			$membership_array['is_active'] = $is_active;
			$membership_array['package_id'] = $package_id;
			if ($membership_id > 0) {
				$membership_array['membership_id'] = $membership_id;
				$membership_database->update_plgsoft_membership($membership_array);
				$task = "list";
				$msg_id = "The membership is edited successfully";
			} else {
				$membership_database->insert_plgsoft_membership($membership_array);
				$task = "list";
				$msg_id = "The membership is added successfully";
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
	$total_membership = $membership_database->get_total_plgsoft_membership($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;
	$list_membership = $membership_database->get_list_plgsoft_membership($array_keywords, $limit, $offset);
	$membership_url = get_plgsoft_admin_url(array('page' => 'manage_membership', 'task' => 'add'));
	?>
	<?php if ($total_membership > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Membership', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Membership', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $membership_url ); ?>"><?php _e( 'Add Membership', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="get" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
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
							<div style="margin-bottom: 10px; text-align: center; color: blue;"><?php echo $msg_id; ?></div>
						<?php } ?>
						<table class="table sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Membership Name', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Price', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Position', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Button', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Front Page', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_membership as $membership_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_membership', 'membership_id' => $membership_item['membership_id'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_membership', 'membership_id' => $membership_item['membership_id'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $membership_item['membership_id']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $membership_item['membership_name']; ?>
											</a>
										</td>
										<td class="text-right">$<?php echo $membership_item['membership_price']; ?></td>
										<td class="text-center">
											<?php
											if ($membership_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_membership', 'membership_id' => $membership_item['membership_id'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_membership', 'membership_id' => $membership_item['membership_id'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($membership_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center"><?php echo $array_position[$membership_item['membership_position']]; ?></td>
										<td class="text-center"><?php echo $array_button[$membership_item['membership_button']]; ?></td>
										<td class="text-center"><?php echo $array_yes_no_property[$membership_item['is_front_page']]; ?></td>
										<td class="text-center"><?php echo $membership_item['membership_order']; ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_membership, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any membership', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Membership', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $membership_url ); ?>"><?php _e( 'Add Membership', 'plgsoft' ) ?></a>
							<?php $membership_import_data_url = get_plgsoft_admin_url(array('page' => 'manage_membership', 'task' => 'import_default_data')); ?>
							<a style="padding-left: 10px;" href="<?php echo esc_url( $membership_import_data_url ); ?>"><?php _e( 'Import Default Data', 'plgsoft' ) ?></a>
						</div>
						<div style="float: right;">
							<form class="form-inline" method="get" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmSearch" name="frmSearch">
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
	$membership_url = get_plgsoft_admin_url(array('page' => 'manage_membership', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if (strlen($membership_id) > 0) { ?>
			<h2><?php _e( 'Edit Membership', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Membership', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Membership', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $membership_url ); ?>"><?php _e( 'Add Membership', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmMembership" name="frmMembership" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="membership_id" name="membership_id" value="<?php echo $membership_id; ?>">
						<?php if (strlen($membership_id) > 0) { ?>
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
						<div class="row<?php echo (strlen($membership_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_name"><?php _e( 'Membership Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="membership_name" name="membership_name" size="70" value="<?php echo esc_attr($membership_name); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_order_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="order_listing"><?php _e( 'Order Listing', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_order_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_order_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="membership_order" name="membership_order" size="35" value="<?php echo esc_attr( $membership_order ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_price_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_price"><?php _e( 'Price', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_price_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_price_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="membership_price" name="membership_price" size="35" value="<?php echo esc_attr( $membership_price ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_submissionamount_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_submissionamout"><?php _e( 'Submission Amount', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_submissionamount_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_submissionamount_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="membership_submissionamount" name="membership_submissionamount" size="35" value="<?php echo esc_attr( $membership_submissionamount ); ?>" />
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="membership_subtext"><?php _e( 'Sub Text', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<textarea class="form-control textarea" id="membership_subtext" name="membership_subtext" rows="5" cols="70"><?php echo esc_html($membership_subtext); ?></textarea>
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="membership_description"><?php _e( 'Description', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<textarea class="form-control textarea" id="membership_description" name="membership_description" rows="5" cols="70"><?php echo esc_html($membership_description); ?></textarea>
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_multiple_cats_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_multiple_cats"><?php _e( 'Multiple Categories', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_multiple_cats_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_multiple_cats_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="membership_multiple_cats" name="membership_multiple_cats" size="70" value="<?php echo esc_attr($membership_multiple_cats); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_multiple_images_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_multiple_images"><?php _e( 'Multiple Images', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_multiple_images_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_multiple_images_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="membership_multiple_images" name="membership_multiple_images" size="70" value="<?php echo esc_attr($membership_multiple_images); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_image_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_images"><?php _e( 'Image', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_image_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_image_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="membership_image" name="membership_image" size="70" value="<?php echo esc_attr($membership_image); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_expires_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_expires"><?php _e( 'Expires', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_expires_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_expires_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="membership_expires" name="membership_expires" size="70" value="<?php echo esc_attr($membership_expires); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($frontpage_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="frontpage"><?php _e( 'Front Page Exposure', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($frontpage_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $frontpage_error; ?></label>
								<?php } ?>
								<select id="frontpage" name="frontpage" class="frontpage form-control select">
									<?php foreach ($array_yes_no_property as $key => $value) { ?>
										<?php if($key == $frontpage) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($featured_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="featured"><?php _e( 'Highlighted Listing', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($featured_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $featured_error; ?></label>
								<?php } ?>
								<select id="featured" name="featured" class="featured form-control select">
									<?php foreach ($array_yes_no_property as $key => $value) { ?>
										<?php if($key == $featured) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($html_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="html"><?php _e( 'HTML Listing Content', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($html_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $html_error; ?></label>
								<?php } ?>
								<select id="html" name="html" class="html form-control select">
									<?php foreach ($array_yes_no_property as $key => $value) { ?>
										<?php if($key == $html) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($visitorcounter_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="visitorcounter"><?php _e( 'Visitor Counter', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($visitorcounter_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $visitorcounter_error; ?></label>
								<?php } ?>
								<select id="visitorcounter" name="visitorcounter" class="visitorcounter form-control select">
									<?php foreach ($array_yes_no_property as $key => $value) { ?>
										<?php if($key == $visitorcounter) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($topcategory_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="topcategory"><?php _e( 'Top of Category Results Page', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($topcategory_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $topcategory_error; ?></label>
								<?php } ?>
								<select id="topcategory" name="topcategory" class="topcategory form-control select">
									<?php foreach ($array_yes_no_property as $key => $value) { ?>
										<?php if($key == $topcategory) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($showgooglemap_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="showgooglemap"><?php _e( 'Google Map', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($showgooglemap_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $showgooglemap_error; ?></label>
								<?php } ?>
								<select id="showgooglemap" name="showgooglemap" class="showgooglemap form-control select">
									<?php foreach ($array_yes_no_property as $key => $value) { ?>
										<?php if($key == $showgooglemap) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
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
						<div class="row<?php echo (strlen($package_id_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="package_id"><?php _e( 'Package', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($package_id_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $package_id_error; ?></label>
								<?php } ?>
								<select id="package_id" name="package_id" class="package_id form-control select">
									<option value=""><?php _e( 'Select Package', 'plgsoft' ) ?></option>
									<?php foreach ($list_package as $item_package) { ?>
										<?php if($item_package['package_id'] == $package_id) { ?>
											<option selected="selected" value="<?php echo $item_package['package_id']; ?>"><?php echo $item_package['package_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $item_package['package_id']; ?>"><?php echo $item_package['package_name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row">
							<label class="col-2" for="membership_access_field"><?php _e( 'Access Fields', 'plgsoft' ) ?></label>
							<div class="col-10 field-wrap">
								<div class="row">
									<?php $index_access_field = 0; ?>
									<?php foreach ($array_access_fields as $key_access_field => $value_access_field) { ?>
										<?php $index_access_field++; ?>
										<div class="col-4" style="/*float: left; width: 33%;*/">
											<input type="checkbox" id="membership_access_fields<?php echo $key_access_field; ?>" name="membership_access_fields[]"
												value="<?php echo $key_access_field; ?>"
												<?php if ((sizeof($membership_access_fields) > 0) && in_array($key_access_field, $membership_access_fields)) { ?> checked="checked" <?php } ?> />
											<label><?php echo stripslashes($value_access_field); ?></label>
										</div>
										<?php if ($index_access_field % 3 == 0) { ?><div style="clear: both;"></div><?php } ?>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_position_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_position"><?php _e( 'Position', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_position_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_position_error; ?></label>
								<?php } ?>
								<select id="membership_position" name="membership_position" class="membership_position form-control select">
									<?php foreach ($array_position as $key => $value) { ?>
										<?php if($key == $membership_position) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($membership_button_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="membership_button"><?php _e( 'Button', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($membership_button_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $membership_button_error; ?></label>
								<?php } ?>
								<select id="membership_button" name="membership_button" class="membership_button form-control select">
									<?php foreach ($array_button as $key => $value) { ?>
										<?php if($key == $membership_button) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row<?php echo (strlen($is_front_page_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="is_front_page"><?php _e( 'Front Page', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($is_front_page_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $is_front_page_error; ?></label>
								<?php } ?>
								<select id="is_front_page" name="is_front_page" class="is_front_page form-control select">
									<?php foreach ($array_yes_no_property as $key => $value) { ?>
										<?php if($key == $is_front_page) { ?>
											<option selected="selected" value="<?php echo $key; ?>"><?php echo $value; ?></option>
										<?php } else { ?>
											<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
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
