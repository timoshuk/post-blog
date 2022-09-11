<?php require APPROOT . "/views/inc/header.php"; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>

<div class="card card-body bg-light mt-5">
	<h2>Edit Post</h2>
	<form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="image">Post image:</label>
			<input type="file" name="image" class="form-control form-control-lg 
					<?php echo (!empty($data['image_err']) ? 'is-invalid' : ''); ?>">
			<span class="invalid-feedback"><?php echo $data['image_err']; ?></span>
		</div>
		<!-- form-group -->
		<div class="form-group">
			<label for="title">Title: <sup>*</sup></label>
			<input type="text" name="title" class="form-control form-control-lg 
					<?php echo (!empty($data['title_err']) ? "is-invalid" : ""); ?>" value="<?php echo $data['title']; ?>">
			<span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
		</div>
		<!-- form-group -->
		<div class="form-group">
			<label for="body">Content: <sup>*</sup></label>
			<textarea name="body" rows="10" class="form-control form-control-lg 
					<?php echo (!empty($data['body_err']) ? "is-invalid" : ""); ?>"><?php echo $data['body']; ?></textarea>
			<span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
		</div>
		<!-- form-group -->

		<input type="submit" class="btn btn-success mt-3" value="Submit">
	</form>
</div>


<?php require APPROOT . "/views/inc/footer.php"; ?>