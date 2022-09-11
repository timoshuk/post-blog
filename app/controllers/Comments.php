<?php

class Comments extends Controller
{


	public function __construct()
	{
		if (!isLoggedIn()) {
			redirect("users/login");
		}

		$this->commentModel = $this->model("Comment");
		$this->userModel = $this->model("User");
	}

	public function index()
	{


		$this->view("pages/404");
	}


	public function add($postId)
	{


		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// Sanitize $_POST Array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);



			$data = [
				"comments_body" => trim($_POST["comments_body"]),
				"user_id" => $_SESSION["user_id"],
				"post_id" => $postId,
				"comments_body_err" => ""
			];



			// Validate data

			if (empty($data["comments_body"])) {
				$data["comments_body_err"] = "Please enter comment body";
			}


			if (empty($data["comments_body_err"])) {

				if ($this->commentModel->addComment($data)) {
					redirect("posts/show/$postId");
				} else {
					die("Something went wrong");
				}
			} else {
				// Load view with errors 
				redirect("posts/show/$postId");
			}
		}
		redirect("posts/show/$postId");
	}


	public function edit($id)
	{

		// Get post
		$comment = $this->commentModel->getCommentById($id);
		$user = $this->userModel->getUserById($_SESSION["user_id"]);

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// Sanitize $_POST Array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


			$data = [
				"comments_body" => trim($_POST["comments_body"]),
				"comments_id" => $id,
				"comments_body_err" => ""
			];



			if (empty($data["comments_body"])) {
				$data["comments_body_err"] = "Please enter comment body";
			}


			if (empty($data["comments_body_err"])) {

				if ($this->commentModel->updateComment($data)) {
					redirect("posts/show/{$comment->post_id}");
				} else {
					die("Something went wrong");
				}
			} else {
				// Load view with errors 
				$this->view("comments/edit", $data);
			}
		} else {

			if ($comment->user_id = $_SESSION["user_id"] || $user->is_admin) {

				$data = [
					"comments_id" => $id,
					"user_id" => $comment->user_id,
					"post_id" => $comment->post_id,
					"comments_body" => $comment->comments_body,
					"comments_body_err" => ""
				];
			} else {
				redirect("posts/show/{$comment->post_id}");
			}
		}

		$this->view("comments/edit", $data);
	}

	public function delete($commentId)
	{

		// Get comment
		$comment = $this->commentModel->getCommentById($commentId);
		$user = $this->userModel->getUserById($_SESSION['user_id']);
		if ($_SERVER["REQUEST_METHOD"] == "POST") {



			if ($comment->user_id != $_SESSION["user_id"] || !$user->is_admin) {
				redirect("posts");
			}

			if ($this->commentModel->deleteComment($commentId)) {
				redirect("posts/show/{$comment->post_id}");
			} else {
				die("Something went wrong");
			}
		} else {
			redirect("posts/show/{$comment->post_id}");
		}
	}
}
