<?php require APPROOT . "/views/inc/header.php"; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>

<h1><?php echo $data['post']->title; ?></h1>

<div class="bg-secondary text-white p-2 mb-3">
	Written by <?php echo $data['user']->name . " on " . $data['post']->created_at; ?>
</div>
<div class="row mb-3">
	<div class="col-5 mx-auto">
		<img class="img-fluid rounded" src="<?php echo $data['post']->image ? URLROOT . '/uploads/img/' . $data['post']->image : URLROOT . '/uploads/img/default-image.jpg'; ?>" alt="Post image">
	</div>
</div>
<p><?php echo $data['post']->body; ?></p>


<?php if ($data['post']->user_id == $_SESSION['user_id'] || $data['current_user'] && $data['current_user']->is_admin) : ?>
	<hr>
	<a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit</a>
	<form class="float-end" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
		<input type="submit" value="Delete" class="btn btn-danger">
	</form>
<?php endif; ?>


<?php if ($_SESSION['user_id']) : ?>
	<form class="mt-3" action="<?php echo URLROOT; ?>/comments/add/<?php echo $data['post']->id; ?>" method="post">
		<textarea class="form-control form-control-lg" name="comments_body">Add comment</textarea>
		<input class="btn btn-dark mt-3" type="submit" value="Submit">
	</form>
<?php endif; ?>


<?php foreach ($data['comments'] as $comment) : ?>

	<div class="card card-body mb-3 mt-3">
		<p class="lead"><?php echo $comment->comments_body; ?></p>

		<?php if ($comment->user_id == $_SESSION['user_id'] || $data['current_user'] && $data['current_user']->is_admin) : ?>
			<div class="row">
				<div class="col-6"><a href="<?php echo URLROOT; ?>/comments/edit/<?php echo $comment->comments_id; ?>" class="btn btn-dark">Edit</a></div>
				<div class="col-6">
					<form class="float-end" action="<?php echo URLROOT; ?>/comments/delete/<?php echo $comment->comments_id; ?>" method="post">
						<input type="submit" value="Delete" class="btn btn-danger">
					</form>
				</div>
			</div>


		<?php endif; ?>

	</div>

<?php endforeach; ?>


<?php require APPROOT . "/views/inc/footer.php";
