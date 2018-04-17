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
		
}
?>