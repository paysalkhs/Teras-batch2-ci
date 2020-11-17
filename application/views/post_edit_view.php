<div class="container mt-5">
	<form id="editPost">
        <input type="hidden" name="id" id="id" value="<?=$data->row()->post_id;?>" />
		<table class="table table-bordered">
			<tr>
				<td>Title</td>
				<td><input type="text" class="form-control" name="post_title" value="<?=$data->row()->post_title;?>"></td>
			</tr>
			<tr>
				<td>Description</td>
				<td>
					<textarea class="form-control" name="post_description"><?=$data->row()->post_description;?></textarea>
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