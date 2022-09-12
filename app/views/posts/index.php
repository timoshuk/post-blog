<?php require APPROOT . "/views/inc/header.php"; ?>
<?php flash('post_message'); ?>
<div class="row">
	<div class="col-md-6">
		<h1>Posts</h1>
	</div>
	<div class="col-md-6">
		<a href="<?php echo URLROOT ?>/posts/add" class="btn btn-primary pull-right">
			<i class="fa fa-pencil"></i> Add Post
		</a>
	</div>
</div>
<div class="row">

	<?php foreach ($data['posts'] as $post) : ?>
		<div class="col-6">

			<div class="card card-body mb-3">

				<div class="row mb-3">
					<div class="col-10 mx-auto">
						<img class="img-fluid rounded" src="<?php echo $post->image ? URLROOT . '/uploads/img/' . $post->image : URLROOT . '/uploads/img/default-image.jpg'; ?>" alt="Post image">
					</div>
				</div>
				<h4 class="card-title">
					<?php echo $post->title; ?>
				</h4>
				<div class="bg-light p-2 mb-3">
					Written by user <?php echo $post->name . " on " . $post->postCreated; ?>
				</div>
				<p class="card-text"><?php echo trimStr($post->body, 300); ?></p>
				<a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark">More</a>
			</div>
		</div>
		<!-- End col-6 -->

	<?php endforeach; ?>
</div>
<!-- End row -->

<?php require APPROOT . "/views/inc/footer.php"; ?>