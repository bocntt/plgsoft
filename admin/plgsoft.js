function plgsoftChangeStatus(el, url = null) {
	var input = jQuery(el);
	if (input.is(":checked")) {
		jQuery(input).attr("checked", true);
	} else {
		jQuery(input).attr("checked", false);
	}
	if (url != null) {
		window.location.href = url;
	}
}
jQuery(document).ready(function() {
	jQuery("#country_key").change(function (){
		jQuery.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/admin/states.ajax.php",
			data: "country_key="+jQuery(this).val(),
			success: function(msg){
				jQuery("#state_id").html(msg);
			}
		});
	});

	jQuery("#state_id").change(function (){
		jQuery.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/admin/cities.ajax.php",
			data: "state_id="+jQuery(this).val(),
			success: function(msg){
				jQuery("#city_id").html(msg);
			}
		});
	});

	jQuery("#main_category_id").change(function (){
		jQuery.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/admin/categories.ajax.php",
			data: "main_category_id="+jQuery(this).val(),
			success: function(msg){
				jQuery("#category_id").html(msg);
			}
		});
	});

	jQuery("#category_id").change(function (){
		jQuery.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/admin/question.ajax.php",
			data: "category_id="+jQuery(this).val(),
			success: function(msg){
				jQuery("#question_id").html(msg);
			}
		});
	});
});
