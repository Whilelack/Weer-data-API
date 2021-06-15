<?php

class db
{
	public $db;

	function __construct()
	{
		$this->db_connect('192.168.178.92', 'database', 'L0c@alAdm!n', 'weather_data');
	}

	function db_connect($host, $user, $pass, $database)
	{
		$this->db = new mysqli($host, $user, $pass, $database);

		if ($this->db->connect_errno > 0) {
			print_r("Failed to connect");
			die();
		}
	}

	function select_query($query)
	{
		if ($result = $this->db->query($query)) {
			return $result;
		}
		return FALSE;
	}
}
