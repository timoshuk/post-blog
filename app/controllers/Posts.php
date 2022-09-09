<?php

class Posts extends Controller
{


	public function __construct()
	{
		if (!isLoggedIn()) {
			redirect("users/login");
		}

		$this->postModel = $this->model("Post");
		$this->userModel = $this->model("User");
	}

	public function index()
	{
		//Get all post

		$posts = $this->postModel->getPosts();

		$data = [
			"posts" => $posts
		];

		$this->view("posts/index", $data);
	}


	public function add()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// Sanitize $_POST Array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


			$data = [
				"title" => trim($_POST["title"]),
				"body" => trim($_POST["body"]),
				"user_id" => $_SESSION["user_id"],
				"title_err" => "",
				"body_err" => ""
			];

			// Validate data

			if (empty($data["title"])) {
				$data["title_err"] = "Please enter title";
			}


			if (empty($data["body"])) {
				$data["body_err"] = "Please enter body";
			}


			if (empty($data["title_err"]) && empty($data["body_err"])) {

				if ($this->postModel->addPost($data)) {
					flash("post_message", "Post Added");
					redirect('post');
				} else {
					die('Something went wrong');
				}
			} else {
				// Load view with errors 
				$this->view("posts/add", $data);
			}
		} else {
			$data = [
				"title" => "",
				"body" => ""
			];
		}

		$this->view("posts/add", $data);
	}


	public function edit($id)
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// Sanitize $_POST Array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


			$data = [
				'id' => $id,
				"title" => trim($_POST["title"]),
				"body" => trim($_POST["body"]),
				"user_id" => $_SESSION["user_id"],
				"title_err" => "",
				"body_err" => ""
			];

			// Validate data

			if (empty($data["title"])) {
				$data["title_err"] = "Please enter title";
			}


			if (empty($data["body"])) {
				$data["body_err"] = "Please enter body";
			}


			if (empty($data["title_err"]) && empty($data["body_err"])) {

				if ($this->postModel->updatePost($data)) {
					flash("post_message", "Post Updated");
					redirect('post');
				} else {
					die('Something went wrong');
				}
			} else {
				// Load view with errors 
				$this->view("posts/edit", $data);
			}
		} else {

			// Get post
			$post = $this->postModel->getPostById($id);
			$user = $this->userModel->getUserById($_SESSION['user_id']);




			if ($post->user_id = $_SESSION["user_id"] || $user->is_admin ) {
				
			$data = [
				"id" => $id,
				"title" => $post->title,
				"body" => $post->body
			];			
			}else{
				redirect("posts");
			}

		}

		$this->view("posts/edit", $data);
	}

	public function show($id)
	{
		$post = $this->postModel->getPostById($id);
		$user = $this->userModel->getUserById($post->user_id);
		$current_user = $this->userModel->getUserById($_SESSION["user_id"]);

		$data = [
			"post" => $post,
			"user" => $user,
			"current_user"=> $current_user
		];

		$this->view("posts/show", $data);
	}

	public function delete($id)
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// Get post
			$post = $this->postModel->getPostById($id);
			$user = $this->userModel->getUserById($_SESSION['user_id']);


			if ($post->user_id != $_SESSION["user_id"] || $user->is_admin) {
				redirect("posts");
			}

			if ($this->postModel->deletePost($id)) {
				flash("post_message", "Post Removed");
				redirect("posts");
			} else {
				die("Something went wrong");
			}
		} else {
			redirect("posts");
		}
	}
}
