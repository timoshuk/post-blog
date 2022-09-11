<?php require APPROOT . "/views/inc/header.php"; ?>

<h1 class="display-3">Edit comment</h1>



<form action="<?php echo URLROOT; ?>/comments/edit/<?php echo $data['comments_id'] ?>" method="post">
	<div class="form-group">
		<textarea class="form-control form-control-lg <?php echo (!empty($data['comments_body_err']) ? 'is-invalid' : ''); ?>" name="comments_body"><?php echo $data['comments_body'] ?></textarea>
		<span class="text-danger"><?php echo $data['comments_body_err']; ?></span>
	</div>
	<input class="btn btn-dark mt-3" type="submit" value="Submit">
</form>



<?php require APPROOT . "/views/inc/footer.php"; ?>