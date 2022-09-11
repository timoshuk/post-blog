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



	public function getCommentsByPostId($postId)
	{
		$this->db->query("SELECT * FROM comments WHERE post_id = :post_id");
		$this->db->bind(":post_id", $postId);

		$row = $this->db->resultSet();

		return $row;
	}

	public function getCommentById($commentId)
	{
		$this->db->query("SELECT * FROM comments WHERE comments_id = :comment_id ");
		$this->db->bind(":comment_id", $commentId);

		$row = $this->db->single();

		return $row;
	}


	public function updateComment($data)
	{

		$this->db->query("UPDATE comments SET , comments_body = :comments_body WHERE comments_id = :id");

		//Bind values
		$this->db->bind(":comments_id", $data["id"]);
		$this->db->bind(":comments_body", $data["comments_body"]);


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
