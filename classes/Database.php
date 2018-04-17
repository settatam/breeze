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
	protected $bConnected = false;
	public $pdo;
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
				$this->username, 
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

	public function prepare() {
		//$this->pdo->prepare();
	}

	public static function Init()
	{
		$dbh = new static;
		if (!$dbh->bConnected) {
			$dbh->Connect();
		}

		return $dbh;

	}

	public function CloseConnection()
	{
		$this->pdo = null;
	}

	public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
	{
		$query = trim($query);
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

	public function column($query, $params = null)
	{
		$this->Init($query, $params);
		$resultColumn = $this->sQuery->fetchAll(PDO::FETCH_COLUMN);
		$this->rowCount = $this->sQuery->rowCount();
		$this->columnCount = $this->sQuery->columnCount();
		$this->sQuery->closeCursor();
		return $resultColumn;
	}
	public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
	{
		$this->Init($query, $params);
		$resultRow = $this->sQuery->fetch($fetchmode);
		$this->rowCount = $this->sQuery->rowCount();
		$this->columnCount = $this->sQuery->columnCount();
		$this->sQuery->closeCursor();
		return $resultRow;
	}
	

}
?>