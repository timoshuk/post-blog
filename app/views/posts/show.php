<?php require APPROOT . "/views/inc/header.php"; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>

<h1><?php echo $data["post"]->title; ?></h1>

<div class="bg-secondary text-white p-2 mb-3">
	Written by <?php echo $data["user"]->name . " on " . $data["post"]->created_at; ?>
</div>
<div class="row">
	<div class="col-8 mx-auto">
		<img class="img-fluid" src="<?php echo $data["post"]->image ? URLROOT."/uploads/img/" .$data['post']->image :''; ?>" alt="Post image">
	</div>
</div>
<p><?php echo $data["post"]->body; ?></p>


<?php if ($data["post"]->user_id == $_SESSION["user_id"] || $data["current_user"] && $data["current_user"]->is_admin) : ?>
	<hr>
	<a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit</a>
	<form class="float-end" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
		<input type="submit" value="Delete" class="btn btn-danger">
	</form>
<?php endif; ?>

<?php require APPROOT . "/views/inc/footer.php";
