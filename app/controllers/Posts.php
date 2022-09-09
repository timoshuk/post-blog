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
				"image" =>"",
				"title" => trim($_POST["title"]),
				"body" => trim($_POST["body"]),
				"user_id" => $_SESSION["user_id"],
				"image_err" => "",
				"title_err" => "",
				"body_err" => ""
			];
			
			
			// Validate data
			
			// Validate image 



			if($_FILES["image"]["name"]){
				$target_dir = __DIR__ . "/../../public/uploads/img/";
				$image_name = date("Y_m_d").basename($_FILES["image"]["name"]);
				$target_file = $target_dir . $image_name;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				$check = getimagesize($_FILES["image"]["tmp_name"]);

				if($check == false) {
					$data['image_err'] .= "File is not an image. ";
				}

				// Check if file already exists
				if (file_exists($target_file)) {
					$data['image_err'] .= "Sorry, file already exists. ";
				}

				// Check file size
				if ($_FILES["image"]["size"] > 900000) {
					$data['image_err'] .= "Your file is too large. ";
				}

				if($imageFileType != "jpg" && $imageFileType != "png" 
					&& $imageFileType != "jpeg" && $imageFileType != "gif" ) {
						$data['image_err'] .= "Only JPG, JPEG, PNG & GIF files are allowed. ";
  
				}
				
				if(strlen($data['image_err']) == 0){
				//   Stop here

		
					
					if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		
						$data['image_err'] .= "Sorry, there was an error uploading your file.";
					  }
					else{
						$data["image"] =  $image_name;
					}
				}

			}

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
