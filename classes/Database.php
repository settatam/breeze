<?php
/*
*/
class Database {
	private $connection;
	private static $_instance;
	private $host = "localhost";
	private $username = "root";
	private $password = "root";
	private $database = "breeze";
	private $port = 3306;
	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function connect()
	{
		try {
			$this->pdo = new PDO('mysql:dbname=' . $this->database . ';host=' . $this->host . ';port=' . $this->port . ';charset=utf8', 
				$this->user, 
				$this->password,
				array(
					//For PHP 5.3.6 or lower
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
					PDO::ATTR_EMULATE_PREPARES => false,
					//长连接
					//PDO::ATTR_PERSISTENT => true,
					
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
				)
			);
			/*
			//For PHP 5.3.6 or lower
			$this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
			$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$this->pdo->setAttribute(PDO::ATTR_PERSISTENT, true);//长连接
			$this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
			*/
			$this->bConnected = true;
			
		}
		catch (PDOException $e) {
			echo $this->ExceptionLog($e->getMessage());
			die();
		}
	}

	private function Init($query, $parameters = "")
	{
		if (!$this->bConnected) {
			$this->Connect();
		}
		try {
			$this->parameters = $parameters;
			$this->sQuery     = $this->pdo->prepare($this->BuildParams($query, $this->parameters));
			
			if (!empty($this->parameters)) {
				if (array_key_exists(0, $parameters)) {
					$parametersType = true;
					array_unshift($this->parameters, "");
					unset($this->parameters[0]);
				} else {
					$parametersType = false;
				}
				foreach ($this->parameters as $column => $value) {
					$this->sQuery->bindParam($parametersType ? intval($column) : ":" . $column, $this->parameters[$column]); //It would be query after loop end(before 'sQuery->execute()').It is wrong to use $value.
				}
			}
			
			$this->succes = $this->sQuery->execute();
			$this->querycount++;
		}
		catch (PDOException $e) {
			echo $this->ExceptionLog($e->getMessage(), $this->BuildParams($query));
			die();
		}
		
		$this->parameters = array();
	}

	public function CloseConnection()
	{
		$this->pdo = null;
	}

	public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
	{
		$query        = trim($query);
		$rawStatement = explode(" ", $query);
		$this->Init($query, $params);
		$statement = strtolower($rawStatement[0]);
		if ($statement === 'select' || $statement === 'show') {
			return $this->sQuery->fetchAll($fetchmode);
		} elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
			return $this->sQuery->rowCount();
		} else {
			return NULL;
		}
	}
	
	
	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
	
	// Constructor
	// private function __construct() {
	// 	$this->_connection = new mysqli($this->host, $this->username, $this->password, $this->database);
	
	// 	// Error handling
	// 	if(mysqli_connect_error()) {
	// 		trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
	// 			 E_USER_ERROR);
	// 	}
	// }
	
	// // Magic method clone is empty to prevent duplication of connection
	// private function __clone() { }
	
	// // Get mysqli connection
	// public function getConnection() {
	// 	return $this->connection;
	// }
}
?>