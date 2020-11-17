$(document).ready(function(){
	
	//Pemanggilan Function GetAll
	getAll();
	
	$("#addPost").submit(function(e){
		e.preventDefault();
		var postData = new FormData(this);
		addPost(postData);
	});
	$("#posts").delegate('button[name=delete]','click',function(){
		var id = $(this).attr('id');
		deletePost(id);
	});
	$("#editPost").submit(function(e){
		e.preventDefault();
		var postData = $(this).serialize();
		updatePost(postData);
	});

	function updatePost(data){
		$.ajax({
			url: base_url+'add-post/edit/submit',
			type: 'POST',
			data: data,
			success: function(data){
				var json = JSON.parse(data);
				if(json.status === true){
					alert(json.message);
					window.location.href = base_url+'/add-post';
				}else{
					alert(json.message);
				}
			}
		})
	}
	function getAll(){
		$.ajax({
			url: base_url+'/add-post/getAll',
			type: 'GET',
			success: function(res){
				var json = JSON.parse(res);
				$.each(json.data,function(index,val){
					$("#posts").append(`<tr>
						<td>${val.no}</td>
						<td>${val.title}</td>
						<td>${val.description}</td>
						<td>${val.user}</td>
						<td>
							<a href="${base_url+'/add-post/edit/'+val.id}" class="btn btn-info btn-xs">Edit</a>
							<button class="btn btn-danger btn-xs" id="${val.id}" name="delete">Delete</button>
						</td>
						</tr>`);
				});
			},error: function(err){
				console.log(err);
			}
		})
	}
	function deletePost(id){
		$.ajax({
			url: base_url+'/add-post/delete/'+id,
			type: 'GET',
			success: function(data){
				var json = JSON.parse(data);
				if(json.status === true){
					$("#posts").html('');
					getAll();
				}else{
					alert('Gagal Menghapus');
				}
			},error: function(error){
				console.log(err);
			}
		})
	}
	function addPost(data){
		$.ajax({
			url: base_url+'/add-post/submit',
			type: 'POST',
			data: data,
			contentType: false,
		    cache: false,
		   	processData:false,
			success: function(res){
				var json = JSON.parse(res);
				if(json.status === true){
					alert(json.message);
					window.location.href = base_url+'/add-post';
				}else{
					if(json.type === 'validation'){
						$.each(json.data,function(index,val){
							$("#error_"+index).html(val);
						});
					}
				}
			},error: function(err){
				console.log(err);
			}
		})
	}
});