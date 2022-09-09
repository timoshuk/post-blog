<?php

/*
 * Base Controller
 * Loads the models and views
*/

class Controller
{
	// Load model
	public function model($model)
	{
		// Require model file

		if (file_exists("../app/models/" . $model . ".php")) {
			require_once "../app/models/" . $model . ".php";
		} else {
			die("Model does not exist");
		}
		return new $model();


		// Instantiate model
	}

	//Load view
	public function view($view, $data = [])
	{
		if (file_exists("../app/views/" . $view . ".php")) {
			require_once "../app/views/" . $view . ".php";
		} else {
			die("View does not exist");
		}
	}
}
