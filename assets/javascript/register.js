$(document).ready(function(){
	//Post Data Ke Controller
	$("#form").submit(function(e){
		e.preventDefault();
		var form = $(this).serialize();

		$.ajax({
			url: base_url+'welcome/register_process',
			type: 'POST',
			data: form,
			success: function(data){
				var json = JSON.parse(data);
				alert(json.message);
			},error: function(err){
				console.log(err);
			}
		})
	})
});