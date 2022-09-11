<?php require APPROOT . "/views/inc/header.php"; ?>

<h1 class="display-3">Edit comment</h1>



<form action="<?php echo URLROOT; ?>/comments/edit/<?php echo $data['comments_id'] ?>" method="post">
	<textarea class="form-control form-control-lg" name="comments_body"><?php echo $data['comments_body'] ?></textarea>
	<span class="invalid-feedback"><?php echo $data['comments_body_err']; ?></span>
	<input class="btn btn-dark mt-3" type="submit" value="Submit">
</form>



<?php require APPROOT . "/views/inc/footer.php"; ?>