<?php

class DBController
{
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "egg";
	private static $conn;

	function __construct()
	{
		//Connecting to DB
		$this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
		
		//IF DB Connection fails (Most probably DB is not created yet)
		if(!$this->conn){
			//Connecting to MYSQLi
			$this->conn = mysqli_connect($this->host, $this->user, $this->password);

			//Create DB
			$query = 'CREATE DATABASE egg';
			mysqli_query($this->conn, $query);

			//Selecting DB
			mysqli_select_db($this->conn,$this->database);
				
			//SQL Source file
			$sqlSource = file_get_contents('egg_with_data.sql');
			mysqli_multi_query($this->conn, $sqlSource);

			$msg = "Database not found, but we created it for you!";
			echo "<script type='text/javascript'>
            alert('$msg');
            window.location.href='index.php';
            </script>";
		}
	}

	function getDBResult($query, $params = array())
	{
		$sql_statement = $this->conn->prepare($query);
		if (!empty($params)) {
			$this->bindParams($sql_statement, $params);
		}
		$sql_statement->execute();
		$result = $sql_statement->get_result();

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$resultset[] = $row;
			}
		}

		if (!empty($resultset)) {
			return $resultset;
		}
	}

	function updateDB($query, $params = array())
	{
		$sql_statement = $this->conn->prepare($query);
		if (!empty($params)) {
			$this->bindParams($sql_statement, $params);
		}
		$sql_statement->execute();
	}

	function bindParams($sql_statement, $params)
	{
		$param_type = "";
		foreach ($params as $query_param) {
			$param_type .= $query_param["param_type"];
		}

		$bind_params[] = &$param_type;
		foreach ($params as $k => $query_param) {
			$bind_params[] = &$params[$k]["param_value"];
		}

		call_user_func_array(array(
			$sql_statement,
			'bind_param'
		), $bind_params);
	}
}
