<?php
class EasySQL
{
	public $conn;
	public $result;
	public $rowCount=0;
	public $row;

	function __construct($h, $u, $p, $d)
	{
		$host = $h;
		$user = $u;
		$pass = $p;
		$dbnm = $d;

		$this->conn = mysqli_connect($host, $user, $pass, $dbnm)
			or die("Error connecting to SQL: " . mysqli_error($this->conn));
	}

	function __destruct()
	{
		mysqli_free_result($this->result);
		mysqli_close($this->conn);
	}

	function query($sqlCmd)
	{
		mysqli_free_result($this->result);
		$this->result = mysqli_query($this->conn, $sqlCmd)
			or die("Query failed: " . mysqli_error($this->conn));
		$this->rowCount = mysqli_num_rows($this->result);
	}

	function get()
	{
		$this->row = mysqli_fetch_assoc($this->result);
		return $this->row;
	}

	function getRowCount(){return $this->rowCount;}

	function getResult(){return $this->result;}

	function getTableRowCount($tableName, $databaseName)
	{
		$tmpRslt = $mysqli_query($this->conn,
				"SELECT table_rows FROM information_schema.tables
				WHERE table_name='" . $tableName . "' AND table_schema='" . $databaseName . "'");

		return mysqli_fetch_row($tmpRslt);
	}
}

/*
$res = $mysqli->query("SELECT table_rows 'Rows Count'
	FROM information_schema.tables
	WHERE table_name='tableName' AND table_schema='databaseName';");

then the row count is the first index of the array from
	$res->fetch_row();
*/
?>