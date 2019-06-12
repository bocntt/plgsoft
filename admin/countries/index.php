<?php
require_once(wp_plugin_plgsoft_admin_dir . "/countries/countries_database.php");
global $table_name;
$countries_database = new countries_database();
$countries_database->set_table_name($table_name);

$page = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$start = isset($_REQUEST["start"]) ? trim($_REQUEST["start"]) : 1;
if (strlen($page) > 0) {
	$page = 'manage_countries';
}
$task = isset($_REQUEST["task"]) ? trim($_REQUEST["task"]) : "list";
$is_save = isset($_REQUEST["is_save"]) ? trim($_REQUEST["is_save"]) : 0;
$country_id = isset($_REQUEST["country_id"]) ? trim($_REQUEST["country_id"]) : 0;
$country_key = isset($_REQUEST["country_key"]) ? trim($_REQUEST["country_key"]) : "";
$is_validate = false;
$country_name_error = ''; $is_active_error = ''; $country_icon_error = ''; $order_listing_error = ''; $country_key_error = '';
$array_yes_no_property = get_array_yes_no_plgsoft_property();
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$msg_id = "";
$manage_list_url = get_plgsoft_admin_url(array('page' => 'manage_countries', 'keyword' => $keyword));

if ($task == 'delete') {
	$countries_database->delete_plgsoft_countries($country_key);
	$task = "list";
	$msg_id = "The country is deleted successfully";
} elseif ($task == 'import_default_data') {
	$array_countries[] = array('country_key' => 'US', 'country_name' => 'United States');
	$array_countries[] = array('country_key' => 'AL', 'country_name' => 'Albania');
	$array_countries[] = array('country_key' => 'DZ', 'country_name' => 'Algeria');
	$array_countries[] = array('country_key' => 'AS', 'country_name' => 'American Samoa');
	$array_countries[] = array('country_key' => 'AD', 'country_name' => 'Andorra');
	$array_countries[] = array('country_key' => 'AO', 'country_name' => 'Angola');
	$array_countries[] = array('country_key' => 'AI', 'country_name' => 'Anguilla');
	$array_countries[] = array('country_key' => 'AQ', 'country_name' => 'Antarctica');
	$array_countries[] = array('country_key' => 'AG', 'country_name' => 'Antigua and Barbuda');
	$array_countries[] = array('country_key' => 'AR', 'country_name' => 'Argentina');
	$array_countries[] = array('country_key' => 'AM', 'country_name' => 'Armenia');
	$array_countries[] = array('country_key' => 'AW', 'country_name' => 'Aruba');
	$array_countries[] = array('country_key' => 'AU', 'country_name' => 'Australia');
	$array_countries[] = array('country_key' => 'AT', 'country_name' => 'Austria');
	$array_countries[] = array('country_key' => 'AZ', 'country_name' => 'Azerbaijan');
	$array_countries[] = array('country_key' => 'BS', 'country_name' => 'Bahamas');
	$array_countries[] = array('country_key' => 'BH', 'country_name' => 'Bahrain');
	$array_countries[] = array('country_key' => 'BD', 'country_name' => 'Bangladesh');
	$array_countries[] = array('country_key' => 'BB', 'country_name' => 'Barbados');
	$array_countries[] = array('country_key' => 'BY', 'country_name' => 'Belarus');
	$array_countries[] = array('country_key' => 'BE', 'country_name' => 'Belgium');
	$array_countries[] = array('country_key' => 'BZ', 'country_name' => 'Belize');
	$array_countries[] = array('country_key' => 'BJ', 'country_name' => 'Benin');
	$array_countries[] = array('country_key' => 'BM', 'country_name' => 'Bermuda');
	$array_countries[] = array('country_key' => 'BT', 'country_name' => 'Bhutan');
	$array_countries[] = array('country_key' => 'BO', 'country_name' => 'Bolivia');
	$array_countries[] = array('country_key' => 'BA', 'country_name' => 'Bosnia and Herzegowina');
	$array_countries[] = array('country_key' => 'BW', 'country_name' => 'Botswana');
	$array_countries[] = array('country_key' => 'BV', 'country_name' => 'Bouvet Island');
	$array_countries[] = array('country_key' => 'BR', 'country_name' => 'Brazil');
	$array_countries[] = array('country_key' => 'IO', 'country_name' => 'British Indian Ocean Territory');
	$array_countries[] = array('country_key' => 'BN', 'country_name' => 'Brunei Darussalam');
	$array_countries[] = array('country_key' => 'BG', 'country_name' => 'Bulgaria');
	$array_countries[] = array('country_key' => 'BF', 'country_name' => 'Burkina Faso');
	$array_countries[] = array('country_key' => 'BI', 'country_name' => 'Burundi');
	$array_countries[] = array('country_key' => 'KH', 'country_name' => 'Cambodia');
	$array_countries[] = array('country_key' => 'CM', 'country_name' => 'Cameroon');
	$array_countries[] = array('country_key' => 'CA', 'country_name' => 'Canada');
	$array_countries[] = array('country_key' => 'CV', 'country_name' => 'Cape Verde');
	$array_countries[] = array('country_key' => 'KY', 'country_name' => 'Cayman Islands');
	$array_countries[] = array('country_key' => 'CF', 'country_name' => 'Central African Republic');
	$array_countries[] = array('country_key' => 'TD', 'country_name' => 'Chad');
	$array_countries[] = array('country_key' => 'CL', 'country_name' => 'Chile');
	$array_countries[] = array('country_key' => 'CN', 'country_name' => 'China');
	$array_countries[] = array('country_key' => 'CX', 'country_name' => 'Christmas Island');
	$array_countries[] = array('country_key' => 'CC', 'country_name' => 'Cocos (Keeling) Islands');
	$array_countries[] = array('country_key' => 'CO', 'country_name' => 'Colombia');
	$array_countries[] = array('country_key' => 'KM', 'country_name' => 'Comoros');
	$array_countries[] = array('country_key' => 'CG', 'country_name' => 'Congo');
	$array_countries[] = array('country_key' => 'CK', 'country_name' => 'Cook Islands');
	$array_countries[] = array('country_key' => 'CR', 'country_name' => 'Costa Rica');
	$array_countries[] = array('country_key' => 'HR', 'country_name' => 'Croatia');
	$array_countries[] = array('country_key' => 'CU', 'country_name' => 'Cuba');
	$array_countries[] = array('country_key' => 'CY', 'country_name' => 'Cyprus');
	$array_countries[] = array('country_key' => 'CZ', 'country_name' => 'Czech Republic');
	$array_countries[] = array('country_key' => 'DK', 'country_name' => 'Denmark');
	$array_countries[] = array('country_key' => 'DJ', 'country_name' => 'Djibouti');
	$array_countries[] = array('country_key' => 'DM', 'country_name' => 'Dominica');
	$array_countries[] = array('country_key' => 'DO', 'country_name' => 'Dominican Republic');
	$array_countries[] = array('country_key' => 'TP', 'country_name' => 'East Timor');
	$array_countries[] = array('country_key' => 'EC', 'country_name' => 'Ecuador');
	$array_countries[] = array('country_key' => 'EG', 'country_name' => 'Egypt');
	$array_countries[] = array('country_key' => 'SV', 'country_name' => 'El Salvador');
	$array_countries[] = array('country_key' => 'GQ', 'country_name' => 'Equatorial Guinea');
	$array_countries[] = array('country_key' => 'ER', 'country_name' => 'Eritrea');
	$array_countries[] = array('country_key' => 'EE', 'country_name' => 'Estonia');
	$array_countries[] = array('country_key' => 'ET', 'country_name' => 'Ethiopia');
	$array_countries[] = array('country_key' => 'FK', 'country_name' => 'Falkland Islands (Malvinas)');
	$array_countries[] = array('country_key' => 'FO', 'country_name' => 'Faroe Islands');
	$array_countries[] = array('country_key' => 'FJ', 'country_name' => 'Fiji');
	$array_countries[] = array('country_key' => 'FI', 'country_name' => 'Finland');
	$array_countries[] = array('country_key' => 'FR', 'country_name' => 'France');
	$array_countries[] = array('country_key' => 'GF', 'country_name' => 'French Guiana');
	$array_countries[] = array('country_key' => 'PF', 'country_name' => 'French Polynesia');
	$array_countries[] = array('country_key' => 'TF', 'country_name' => 'French Southern Territories');
	$array_countries[] = array('country_key' => 'GA', 'country_name' => 'Gabon');
	$array_countries[] = array('country_key' => 'GM', 'country_name' => 'Gambia');
	$array_countries[] = array('country_key' => 'GE', 'country_name' => 'Georgia');
	$array_countries[] = array('country_key' => 'DE', 'country_name' => 'Germany');
	$array_countries[] = array('country_key' => 'GH', 'country_name' => 'Ghana');
	$array_countries[] = array('country_key' => 'GI', 'country_name' => 'Gibraltar');
	$array_countries[] = array('country_key' => 'GR', 'country_name' => 'Greece');
	$array_countries[] = array('country_key' => 'GL', 'country_name' => 'Greenland');
	$array_countries[] = array('country_key' => 'GD', 'country_name' => 'Grenada');
	$array_countries[] = array('country_key' => 'GP', 'country_name' => 'Guadeloupe');
	$array_countries[] = array('country_key' => 'GU', 'country_name' => 'Guam');
	$array_countries[] = array('country_key' => 'GT', 'country_name' => 'Guatemala');
	$array_countries[] = array('country_key' => 'GN', 'country_name' => 'Guinea');
	$array_countries[] = array('country_key' => 'GW', 'country_name' => 'Guinea-bissau');
	$array_countries[] = array('country_key' => 'GY', 'country_name' => 'Guyana');
	$array_countries[] = array('country_key' => 'HT', 'country_name' => 'Haiti');
	$array_countries[] = array('country_key' => 'HM', 'country_name' => 'Heard and Mc Donald Islands');
	$array_countries[] = array('country_key' => 'HN', 'country_name' => 'Honduras');
	$array_countries[] = array('country_key' => 'HK', 'country_name' => 'Hong Kong');
	$array_countries[] = array('country_key' => 'HU', 'country_name' => 'Hungary');
	$array_countries[] = array('country_key' => 'IS', 'country_name' => 'Iceland');
	$array_countries[] = array('country_key' => 'IN', 'country_name' => 'India');
	$array_countries[] = array('country_key' => 'ID', 'country_name' => 'Indonesia');
	$array_countries[] = array('country_key' => 'IR', 'country_name' => 'Iran');
	$array_countries[] = array('country_key' => 'IQ', 'country_name' => 'Iraq');
	$array_countries[] = array('country_key' => 'IE', 'country_name' => 'Ireland');
	$array_countries[] = array('country_key' => 'IL', 'country_name' => 'Israel');
	$array_countries[] = array('country_key' => 'IT', 'country_name' => 'Italy');
	$array_countries[] = array('country_key' => 'JM', 'country_name' => 'Jamaica');
	$array_countries[] = array('country_key' => 'JP', 'country_name' => 'Japan');
	$array_countries[] = array('country_key' => 'JO', 'country_name' => 'Jordan');
	$array_countries[] = array('country_key' => 'KZ', 'country_name' => 'Kazakhstan');
	$array_countries[] = array('country_key' => 'KE', 'country_name' => 'Kenya');
	$array_countries[] = array('country_key' => 'KI', 'country_name' => 'Kiribati');
	$array_countries[] = array('country_key' => 'KR', 'country_name' => 'Korea');
	$array_countries[] = array('country_key' => 'KW', 'country_name' => 'Kuwait');
	$array_countries[] = array('country_key' => 'KG', 'country_name' => 'Kyrgyzstan');
	$array_countries[] = array('country_key' => 'LV', 'country_name' => 'Latvia');
	$array_countries[] = array('country_key' => 'LB', 'country_name' => 'Lebanon');
	$array_countries[] = array('country_key' => 'LS', 'country_name' => 'Lesotho');
	$array_countries[] = array('country_key' => 'LR', 'country_name' => 'Liberia');
	$array_countries[] = array('country_key' => 'LY', 'country_name' => 'Libyan Arab Jamahiriya');
	$array_countries[] = array('country_key' => 'LI', 'country_name' => 'Liechtenstein');
	$array_countries[] = array('country_key' => 'LT', 'country_name' => 'Lithuania');
	$array_countries[] = array('country_key' => 'LU', 'country_name' => 'Luxembourg');
	$array_countries[] = array('country_key' => 'MO', 'country_name' => 'Macau');
	$array_countries[] = array('country_key' => 'TH', 'country_name' => 'Macedonia');
	$array_countries[] = array('country_key' => 'MG', 'country_name' => 'Madagascar');
	$array_countries[] = array('country_key' => 'MW', 'country_name' => 'Malawi');
	$array_countries[] = array('country_key' => 'MY', 'country_name' => 'Malaysia');
	$array_countries[] = array('country_key' => 'MV', 'country_name' => 'Maldives');
	$array_countries[] = array('country_key' => 'ML', 'country_name' => 'Mali');
	$array_countries[] = array('country_key' => 'MT', 'country_name' => 'Malta');
	$array_countries[] = array('country_key' => 'MH', 'country_name' => 'Marshall Islands');
	$array_countries[] = array('country_key' => 'MQ', 'country_name' => 'Martinique');
	$array_countries[] = array('country_key' => 'MR', 'country_name' => 'Mauritania');
	$array_countries[] = array('country_key' => 'MU', 'country_name' => 'Mauritius');
	$array_countries[] = array('country_key' => 'YT', 'country_name' => 'Mayotte');
	$array_countries[] = array('country_key' => 'MX', 'country_name' => 'Mexico');
	$array_countries[] = array('country_key' => 'FE', 'country_name' => 'Micronesia');
	$array_countries[] = array('country_key' => 'RE', 'country_name' => 'Moldova');
	$array_countries[] = array('country_key' => 'MC', 'country_name' => 'Monaco');
	$array_countries[] = array('country_key' => 'MN', 'country_name' => 'Mongolia');
	$array_countries[] = array('country_key' => 'MS', 'country_name' => 'Montserrat');
	$array_countries[] = array('country_key' => 'MA', 'country_name' => 'Morocco');
	$array_countries[] = array('country_key' => 'MZ', 'country_name' => 'Mozambique');
	$array_countries[] = array('country_key' => 'MM', 'country_name' => 'Myanmar');
	$array_countries[] = array('country_key' => 'NA', 'country_name' => 'Namibia');
	$array_countries[] = array('country_key' => 'NR', 'country_name' => 'Nauru');
	$array_countries[] = array('country_key' => 'NP', 'country_name' => 'Nepal');
	$array_countries[] = array('country_key' => 'NL', 'country_name' => 'Netherlands');
	$array_countries[] = array('country_key' => 'AN', 'country_name' => 'Netherlands Antilles');
	$array_countries[] = array('country_key' => 'NC', 'country_name' => 'New Caledonia');
	$array_countries[] = array('country_key' => 'NZ', 'country_name' => 'New Zealand');
	$array_countries[] = array('country_key' => 'NI', 'country_name' => 'Nicaragua');
	$array_countries[] = array('country_key' => 'NE', 'country_name' => 'Niger');
	$array_countries[] = array('country_key' => 'NG', 'country_name' => 'Nigeria');
	$array_countries[] = array('country_key' => 'NU', 'country_name' => 'Niue');
	$array_countries[] = array('country_key' => 'NF', 'country_name' => 'Norfolk Island');
	$array_countries[] = array('country_key' => 'MP', 'country_name' => 'Northern Mariana Islands');
	$array_countries[] = array('country_key' => 'NO', 'country_name' => 'Norway');
	$array_countries[] = array('country_key' => 'OM', 'country_name' => 'Oman');
	$array_countries[] = array('country_key' => 'PK', 'country_name' => 'Pakistan');
	$array_countries[] = array('country_key' => 'PW', 'country_name' => 'Palau');
	$array_countries[] = array('country_key' => 'PA', 'country_name' => 'Panama');
	$array_countries[] = array('country_key' => 'PG', 'country_name' => 'Papua New Guinea');
	$array_countries[] = array('country_key' => 'PY', 'country_name' => 'Paraguay');
	$array_countries[] = array('country_key' => 'PE', 'country_name' => 'Peru');
	$array_countries[] = array('country_key' => 'PH', 'country_name' => 'Philippines');
	$array_countries[] = array('country_key' => 'PN', 'country_name' => 'Pitcairn');
	$array_countries[] = array('country_key' => 'PL', 'country_name' => 'Poland');
	$array_countries[] = array('country_key' => 'PT', 'country_name' => 'Portugal');
	$array_countries[] = array('country_key' => 'PR', 'country_name' => 'Puerto Rico');
	$array_countries[] = array('country_key' => 'QA', 'country_name' => 'Qatar');
	$array_countries[] = array('country_key' => 'RE', 'country_name' => 'Reunion');
	$array_countries[] = array('country_key' => 'RO', 'country_name' => 'Romania');
	$array_countries[] = array('country_key' => 'RU', 'country_name' => 'Russian Federation');
	$array_countries[] = array('country_key' => 'RW', 'country_name' => 'Rwanda');
	$array_countries[] = array('country_key' => 'KN', 'country_name' => 'Saint Kitts and Nevis');
	$array_countries[] = array('country_key' => 'LC', 'country_name' => 'Saint Lucia');
	$array_countries[] = array('country_key' => 'VC', 'country_name' => 'Saint Vincent and the Grenadines');
	$array_countries[] = array('country_key' => 'WS', 'country_name' => 'Samoa');
	$array_countries[] = array('country_key' => 'SM', 'country_name' => 'San Marino');
	$array_countries[] = array('country_key' => 'ST', 'country_name' => 'Sao Tome and Principe');
	$array_countries[] = array('country_key' => 'SA', 'country_name' => 'Saudi Arabia');
	$array_countries[] = array('country_key' => 'SN', 'country_name' => 'Senegal');
	$array_countries[] = array('country_key' => 'SC', 'country_name' => 'Seychelles');
	$array_countries[] = array('country_key' => 'SL', 'country_name' => 'Sierra Leone');
	$array_countries[] = array('country_key' => 'SG', 'country_name' => 'Singapore');
	$array_countries[] = array('country_key' => 'SK', 'country_name' => 'Slovakia (Slovak Republic)');
	$array_countries[] = array('country_key' => 'SI', 'country_name' => 'Slovenia');
	$array_countries[] = array('country_key' => 'SB', 'country_name' => 'Solomon Islands');
	$array_countries[] = array('country_key' => 'SO', 'country_name' => 'Somalia');
	$array_countries[] = array('country_key' => 'ZA', 'country_name' => 'South Africa');
	$array_countries[] = array('country_key' => 'GS', 'country_name' => 'South Georgia and the South Sandwich Islands');
	$array_countries[] = array('country_key' => 'ES', 'country_name' => 'Spain');
	$array_countries[] = array('country_key' => 'LK', 'country_name' => 'Sri Lanka');
	$array_countries[] = array('country_key' => 'SH', 'country_name' => 'St. Helena');
	$array_countries[] = array('country_key' => 'PM', 'country_name' => 'St. Pierre and Miquelon');
	$array_countries[] = array('country_key' => 'SD', 'country_name' => 'Sudan');
	$array_countries[] = array('country_key' => 'SR', 'country_name' => 'Suriname');
	$array_countries[] = array('country_key' => 'SJ', 'country_name' => 'Svalbard and Jan Mayen Islands');
	$array_countries[] = array('country_key' => 'SZ', 'country_name' => 'Swaziland');
	$array_countries[] = array('country_key' => 'SE', 'country_name' => 'Sweden');
	$array_countries[] = array('country_key' => 'CH', 'country_name' => 'Switzerland');
	$array_countries[] = array('country_key' => 'SY', 'country_name' => 'Syrian Arab Republic');
	$array_countries[] = array('country_key' => 'TW', 'country_name' => 'Taiwan');
	$array_countries[] = array('country_key' => 'TJ', 'country_name' => 'Tajikistan');
	$array_countries[] = array('country_key' => 'UN', 'country_name' => 'Tanzania');
	$array_countries[] = array('country_key' => 'TH', 'country_name' => 'Thailand');
	$array_countries[] = array('country_key' => 'TG', 'country_name' => 'Togo');
	$array_countries[] = array('country_key' => 'TK', 'country_name' => 'Tokelau');
	$array_countries[] = array('country_key' => 'TO', 'country_name' => 'Tonga');
	$array_countries[] = array('country_key' => 'TT', 'country_name' => 'Trinidad and Tobago');
	$array_countries[] = array('country_key' => 'TN', 'country_name' => 'Tunisia');
	$array_countries[] = array('country_key' => 'TR', 'country_name' => 'Turkey');
	$array_countries[] = array('country_key' => 'TM', 'country_name' => 'Turkmenistan');
	$array_countries[] = array('country_key' => 'TC', 'country_name' => 'Turks and Caicos Islands');
	$array_countries[] = array('country_key' => 'TV', 'country_name' => 'Tuvalu');
	$array_countries[] = array('country_key' => 'UG', 'country_name' => 'Uganda');
	$array_countries[] = array('country_key' => 'UA', 'country_name' => 'Ukraine');
	$array_countries[] = array('country_key' => 'AE', 'country_name' => 'United Arab Emirates');
	$array_countries[] = array('country_key' => 'GB', 'country_name' => 'United Kingdom');
	$array_countries[] = array('country_key' => 'UY', 'country_name' => 'Uruguay');
	$array_countries[] = array('country_key' => 'UZ', 'country_name' => 'Uzbekistan');
	$array_countries[] = array('country_key' => 'VU', 'country_name' => 'Vanuatu');
	$array_countries[] = array('country_key' => 'VA', 'country_name' => 'Vatican City State (Holy See)');
	$array_countries[] = array('country_key' => 'VE', 'country_name' => 'Venezuela');
	$array_countries[] = array('country_key' => 'VN', 'country_name' => 'Viet Nam');
	$array_countries[] = array('country_key' => 'VG', 'country_name' => 'Virgin Islands (British)');
	$array_countries[] = array('country_key' => 'VI', 'country_name' => 'Virgin Islands');
	$array_countries[] = array('country_key' => 'WF', 'country_name' => 'Wallis and Futuna Islands');
	$array_countries[] = array('country_key' => 'EH', 'country_name' => 'Western Sahara');
	$array_countries[] = array('country_key' => 'YE', 'country_name' => 'Yemen');
	$array_countries[] = array('country_key' => 'YE', 'country_name' => 'Yugoslavia');
	$array_countries[] = array('country_key' => 'ZR', 'country_name' => 'Zaire');
	$array_countries[] = array('country_key' => 'ZM', 'country_name' => 'Zambia');
	$array_countries[] = array('country_key' => 'ZW', 'country_name' => 'Zimbabwe');
	$country_array = array();
	for($i=0; $i<sizeof($array_countries); $i++) {
		$country_array['country_key'] = strtolower($array_countries[$i]['country_key']);
		$country_array['country_name'] = $array_countries[$i]['country_name'];
		$country_array['seo_title'] = $array_countries[$i]['country_name'];
		$country_array['seo_description'] = $array_countries[$i]['country_name'];
		$country_array['permalink'] = get_plgsoft_permalink($array_countries[$i]['country_name']);
		$country_array['order_listing'] = $i;
		$country_array['is_active'] = 1;
		$check_exist_country = $countries_database->check_exist_country_key($array_countries[$i]['country_key']);
		if (!$check_exist_country) $countries_database->insert_plgsoft_countries($country_array);
	}
	$task = "list";
	$msg_id = "These countries are imported successfully";
} elseif ($task == 'active') {
	$countries_database->active_plgsoft_countries($country_key);
	$task = "list";
	$msg_id = "The country is actived";
} elseif ($task == 'deactive') {
	$countries_database->deactive_plgsoft_countries($country_key);
	$task = "list";
	$msg_id = "The country is deactived";
} else {
	if ($is_save==0) {
		if ($country_key=="") {
			$country_key = isset($_POST["country_key"]) ? trim($_POST["country_key"]) : "";
			$country_name = isset($_POST["country_name"]) ? trim($_POST["country_name"]) : "";
			$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
			$is_active = isset($_POST["is_active"]) ? 1 : 0;
			$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
			$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";
		} else {
			$country_obj = $countries_database->get_plgsoft_countries_by_country_key($country_key);
			$country_name = $country_obj['country_name'];
			$order_listing = $country_obj['order_listing'];
			$is_active = $country_obj['is_active'];
			$country_key = $country_obj['country_key'];
			$seo_title = $country_obj['seo_title'];
			$seo_description = $country_obj['seo_description'];
		}
	} else {
		$country_id = isset($_POST["country_id"]) ? trim($_POST["country_id"]) : 0;
		$country_key = isset($_POST["country_key"]) ? trim($_POST["country_key"]) : "";
		$country_name = isset($_POST["country_name"]) ? trim($_POST["country_name"]) : "";
		$order_listing = isset($_POST["order_listing"]) ? trim($_POST["order_listing"]) : 0;
		$is_active = isset($_POST["is_active"]) ? 1 : 0;
		$seo_title = isset($_POST["seo_title"]) ? trim($_POST["seo_title"]) : "";
		$seo_description = isset($_POST["seo_description"]) ? trim($_POST["seo_description"]) : "";

		$check_exist_country_key = $countries_database->check_exist_country_key($country_key);
		if ((strlen($country_key) > 0) && !$check_exist_country_key) {
			$is_validate = true;
		} else {
			if (strlen($country_key) == 0) {
				$is_validate = false;
				$country_key_error = "Country Key is empty";
			} else {
				if ($check_exist_country_key) {
					$is_validate = false;
					$country_key_error = "Country Key is existed";
				}
			}
		}
		$check_exist = $countries_database->check_exist_country_name($country_name, $country_key);
		if ((strlen($country_name) > 0) && !$check_exist && $is_validate) {
			$is_validate = true;
		} else {
			if (strlen($country_name) == 0) {
				$is_validate = false;
				$country_name_error = "Country Name is empty";
			} else {
				if ($check_exist) {
					$is_validate = false;
					$country_name_error = "Country Name is existed";
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
			$country_array = array();
			$country_array['country_name'] = $country_name;
			$country_array['order_listing'] = $order_listing;
			$country_array['is_active'] = $is_active;
			if (!isset($seo_title) || (isset($seo_title) && (strlen($seo_title) == 0))) $seo_title = $country_name;
			if (!isset($seo_description) || (isset($seo_description) && (strlen($seo_description) == 0))) $seo_description = $country_name;
			$country_array['seo_title'] = $seo_title;
			$country_array['seo_description'] = $seo_description;
			$country_array['country_key'] = strtolower($country_key);

			if (strlen($country_key) > 0) {
				$country_array['country_key'] = $country_key;
				$countries_database->update_plgsoft_countries($country_array);
				$task = "list";
				$msg_id = "The country is edited successfully";
			} else {
				$countries_database->insert_plgsoft_countries($country_array);
				$task = "list";
				$msg_id = "The country is added successfully";
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
	$total_countries = $countries_database->get_total_plgsoft_countries($array_keywords);
	$limit = 20;
	$offset = ($start-1)*$limit;
	if ($offset < 0) $offset = 0;
	$list_countries = $countries_database->get_list_plgsoft_countries($array_keywords, $limit, $offset);
	$country_url = get_plgsoft_admin_url(array('page' => 'manage_countries', 'task' => 'add'));
	?>
	<?php if ($total_countries > 0) { ?>
		<div class="wrap">
			<h2><?php _e( 'List Countries', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Country', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $country_url ); ?>"><?php _e( 'Add Country', 'plgsoft' ) ?></a>
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
							<div class="message"><?php echo $msg_id; ?></div>
						<?php } ?>
						<table class="table table-striped table-hovered table-responsive sortable widefat" cellspacing="0">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'Country Key', 'plgsoft' ) ?></th>
									<th scope="col"><?php _e( 'Country Name', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Status', 'plgsoft' ) ?></th>
									<th scope="col" class="text-center"><?php _e( 'Order Listing', 'plgsoft' ) ?></th>
									<th scope="col" class="text-right"><?php _e( 'Action', 'plgsoft' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_countries as $country_item) { ?>
									<?php
									$edit_link = get_plgsoft_admin_url(array('page' => 'manage_countries', 'country_key' => $country_item['country_key'], 'task' => 'edit', 'keyword' => $keyword, 'start' => $start));
									$delete_link = get_plgsoft_admin_url(array('page' => 'manage_countries', 'country_key' => $country_item['country_key'], 'task' => 'delete', 'keyword' => $keyword, 'start' => $start));
									?>
									<tr onmouseover="this.style.backgroundColor='#f1f1f1';" onmouseout="this.style.backgroundColor='white';">
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>">
												<?php echo $country_item['country_key']; ?>
											</a>
										</td>
										<td>
											<a href="<?php echo esc_url( $edit_link ); ?>"><?php echo $country_item['country_name']; ?></a>
										</td>
										<td class="text-center">
											<?php
											if ($country_item['is_active'] == 1) {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_countries', 'country_key' => $country_item['country_key'], 'task' => 'deactive', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Active', 'plgsoft' );
											} else {
												$status_link = get_plgsoft_admin_url(array('page' => 'manage_countries', 'country_key' => $country_item['country_key'], 'task' => 'active', 'keyword' => $keyword, 'start' => $start));
												$status_lable = __( 'Deactive', 'plgsoft' );
											}
											?>
											<label class="field-switch">
												<input type="checkbox" onchange="plgsoftChangeStatus(this, '<?php echo $status_link; ?>');" name="is_active" id="is_active" <?php echo ($country_item['is_active'] == 1) ? 'checked="checked"' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td class="text-center"><?php echo $country_item['order_listing']; ?></td>
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
							$class_Pagings = new class_Pagings($start, $total_countries, $limit);
							$class_Pagings->printPagings("frmSearch", "start");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="wrap">
			<h2><?php _e( 'There is not any country', 'plgsoft' ) ?></h2>
			<?php print_tabs_menus(); ?>
			<div class="plgsoft-tabs-content">
				<div class="plgsoft-tab">
					<div class="plgsoft-sub-tab-nav">
						<div style="float: left;">
							<a class="active" href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Country', 'plgsoft' ) ?></a>
							<a href="<?php echo esc_url( $country_url ); ?>"><?php _e( 'Add Country', 'plgsoft' ) ?></a>
							<?php $country_import_data_url = get_plgsoft_admin_url(array('page' => 'manage_countries', 'task' => 'import_default_data')); ?>
							<a style="padding-left: 10px;" href="<?php echo esc_url( $country_import_data_url ); ?>"><?php _e( 'Import Default Data', 'plgsoft' ) ?></a>
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
	$country_url = get_plgsoft_admin_url(array('page' => 'manage_countries', 'task' => 'add'));
	?>
	<div class="wrap">
		<?php if (strlen($country_key) > 0) { ?>
			<h2><?php _e( 'Edit Country', 'plgsoft' ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Country', 'plgsoft' ) ?></h2>
		<?php } ?>
		<?php print_tabs_menus(); ?>
		<div class="plgsoft-tabs-content">
			<div class="plgsoft-tab">
				<div class="plgsoft-sub-tab-nav">
					<a href="<?php echo esc_url( $manage_list_url ); ?>"><?php _e( 'Manage Country', 'plgsoft' ) ?></a>
					<a class="active" href="<?php echo esc_url( $country_url ); ?>"><?php _e( 'Add Country', 'plgsoft' ) ?></a>
				</div>
				<div class="plgsoft-sub-tab-content">
					<form class="form" method="post" action="<?php echo esc_url( $manage_list_url ); ?>" id="frmCountry" name="frmCountry" enctype="multipart/form-data">
						<input type="hidden" id="is_save" name="is_save" value="1">
						<input type="hidden" id="country_key" name="country_key" value="<?php echo $country_key; ?>">
						<?php if (strlen($country_key) > 0) { ?>
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
						<div class="row<?php echo (strlen($country_key_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="country_key"><?php _e( 'Country Key', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($country_key_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $country_key_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="country_key" name="country_key" size="70" value="<?php echo esc_attr( $country_key ); ?>" />
							</div>
						</div>
						<div class="row<?php echo (strlen($country_name_error) > 0) ? ' has-error' : ''; ?>">
							<label class="col-2" for="country_name"><?php _e( 'Country Name', 'plgsoft' ) ?><span class="required_key_field required"> *</span></label>
							<div class="col-10 field-wrap">
								<?php if (strlen($country_name_error) > 0) { ?>
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> <?php echo $country_name_error; ?></label>
								<?php } ?>
								<input class="form-control" type="text" id="country_name" name="country_name" size="70" value="<?php echo esc_attr( $country_name ); ?>" />
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
