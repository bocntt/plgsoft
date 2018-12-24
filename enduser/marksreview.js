$(document).ready(function() {
	$("#country_key").change(function (){
		$.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/enduser/states.ajax.php",
			data: "country_key="+$(this).val(),
			success: function(msg){
				$("#state_id").html(msg);
			}
		});
	});
	
	$("#state_id").change(function (){
		$.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/enduser/cities.ajax.php",
			data: "state_id="+$(this).val(),
			success: function(msg){
				$("#city_id").html(msg);
			}
		});
	});
	
	$("#main_category_id").change(function (){
		$.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/enduser/categories.ajax.php",
			data: "main_category_id="+$(this).val(),
			success: function(msg){
				$("#category_id").html(msg);
			}
		});
	});
});