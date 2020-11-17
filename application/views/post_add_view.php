<div class="container mt-5">
	<form id="addPost" enctype="multipart/data">
		<table class="table table-bordered">
			<tr>
				<td>Title</td>
				<td>
					<input type="text" class="form-control" name="post_title">
					<span id="error_post_title"></span>
				</td>
			</tr>
			<tr>
				<td>Description</td>
				<td>
					<textarea class="form-control" name="post_description"></textarea>
					<span id="error_post_description"></span>
				</td>
			</tr>
			<tr>
				<td>Gambar</td>
				<td>
					<input type="file" class="form-control" name="post_image" />
					<span id="error_post_image"></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button type="submit" class="btn btn-info btn-sm btn-block">Save</button>
				</td>
			</tr>
		</table>
	</form>
</div>