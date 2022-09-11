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

		//Bind values
		$this->db->bind(":post_id", $postId);
		$comments = $this->db->resultSet();

		return $comments;
	}

	public function getCommentById($commentId)
	{
		$this->db->query("SELECT * FROM comments WHERE comments_id = :comment_id ");

		//Bind values
		$this->db->bind(":comment_id", $commentId);
		$row = $this->db->single();

		return $row;
	}


	public function updateComment($data)
	{


		$this->db->query("UPDATE comments SET comments_body = :comments_body WHERE comments_id = :comments_id");

		//Bind values
		$this->db->bind(":comments_id", $data["comments_id"]);
		$this->db->bind(":comments_body", $data["comments_body"]);

		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteComment($commentId)
	{
		$this->db->query("DELETE FROM comments WHERE comments_id = :comment_id");

		//Bind values
		$this->db->bind(":comment_id", $commentId);

		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	// Delete all post comments by post id
	public function deleteCommentsByPostId($postId)
	{
		$this->db->query("DELETE FROM comments WHERE post_id = :post_id");

		//Bind values
		$this->db->bind(":post_id", $postId);

		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}
}
