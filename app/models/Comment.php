<?php

class Comment
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}



	public function addComment($data)
	{
		$this->db->query("INSERT INTO comments (user_id, post_id, comments_body) VALUES(:user_id, :post_id, :comments_body)");



		//Bind values
		$this->db->bind(":user_id", $data["user_id"]);
		$this->db->bind(":post_id", $data["post_id"]);
		$this->db->bind(":comments_body", $data["comments_body"]);



		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}



	public function getCommentsById($id)
	{
		$this->db->query("SELECT * FROM posts WHERE id = :id");
		$this->db->bind(":id", $id);

		$row = $this->db->single();

		return $row;
	}


	public function updateComments($data)
	{

		$this->db->query("UPDATE posts SET image = :image, title = :title, body = :body WHERE id = :id");

		//Bind values
		$this->db->bind(":id", $data["id"]);
		$this->db->bind(":image", $data["image"]);
		$this->db->bind(":title", $data["title"]);
		$this->db->bind(":body", $data["body"]);


		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteComments($id)
	{
		$this->db->query("DELETE FROM posts WHERE id = :id");

		//Bind values
		$this->db->bind(":id", $id);


		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}
}
