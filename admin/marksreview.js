$(document).ready(function() {
	$("#country_key").change(function (){
		$.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/admin/states.ajax.php",
			data: "country_key="+$(this).val(),
			success: function(msg){
				$("#state_id").html(msg);
			}
		});
	});
	
	$("#state_id").change(function (){
		$.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/admin/cities.ajax.php",
			data: "state_id="+$(this).val(),
			success: function(msg){
				$("#city_id").html(msg);
			}
		});
	});
	
	$("#main_category_id").change(function (){
		$.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/admin/categories.ajax.php",
			data: "main_category_id="+$(this).val(),
			success: function(msg){
				$("#category_id").html(msg);
			}
		});
	});
	
	$("#category_id").change(function (){		
		$.ajax({
			type: "POST",
			url: url_site + "/wp-content/plugins/plgsoft/admin/question.ajax.php",
			data: "category_id="+$(this).val(),
			success: function(msg){
				$("#question_id").html(msg);
			}
		});
	});
});