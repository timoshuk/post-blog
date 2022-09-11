<?php
class Pages extends Controller
{
	public function __construct()
	{
	}

	public function index()
	{
		if (isLoggedIn()) {
			redirect('/posts');
		}

		$data = [
			"title" => "PostBlog",
			"description" => "Simple social network"
		];


		$this->view("pages/index", $data);
	}

	public function about()
	{
		$data = [
			"title" => "About Us",
			"description" => "App to share posts"
		];
		$this->view("pages/about", $data);
	}

	public function not_found()
	{
		$this->view("pages/404");
	}
}
