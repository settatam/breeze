<?php

abstract class ListItem implements arrayaccess{

	// protected $db_table;
	protected $id;
	// protected $result;

	public function __construct($memberArray =array(), $load=false) {
		if(is_array($memberArray)) {
			foreach($this as $key => $value) {
				if($key == 'db_table') continue;
				if($key == 'result') continue;
				if($key == 'id_alias') continue;
				if( !isset( $memberArray[$key] ) ) continue;
				$this->$key = $memberArray[$key];
			}
		}else{
			$this->id = $memberArray;
		}

		if($load && isset($this->id)) {
			$this->load();
		}
	}

	//reloads all class object fields wtih values from database
    public function reload(){
        $this->load();
    }

	public function load($id_only = false){
  
        $query = "SELECT * FROM $this->db_table where {$this->id_alias} = ?";
        $dbh = Database::Init();
        $sth = $dbh->pdo->prepare($query);
        $sth->execute([$this->id]);
        $result = $sth->fetchAll();
		if ( count( $result ) === 1 ) {
			if($id_only) return true;
            foreach($this as $key=>$value){
                if( isset($result[0][$key]) ){
                    $this->$key = $result[0][$key];
                }
            }
           
            return true;
        }
        return false;
    }

    public function findOrNew() {
    	if($this->load(true)) {
    		$this->Update(true);
    	}else{
    		$this->Add();
    	}
    }

    //inserts a new row into the database
	public function Add() {
	
		$param_count = 0;
		$prepared_params = array();
		$query = "INSERT INTO $this->db_table( ";
		foreach( $this as $key => $value ) {
			if( ($key == 'db_table') || 
				($key == 'id_alias') ||
				($key == 'result')) {continue;}
			$query .= "$key, ";
		}
		//remove trailing comma from query
		$query = substr( $query, -0, (strlen( $query ) -2 ) );

		$query .= ") VALUES ( ";
		foreach( $this as $key => $value ) {
			if( ($key == 'db_table') || 
				($key == 'id_alias') ||
				($key == 'result')) {continue;}

			$query .= '?' . ', ';
			$prepared_params[] = $value;
		}

		//remove trailing comma from query
		$query = substr( $query, -0, (strlen( $query ) -2 ) );
		$query .= ")";
		
        $dbh = Database::Init();
        $sth = $dbh->pdo->prepare($query);
        $sth->execute($prepared_params);
        
	}

	//updates a row in the database
	public function Update($reload=false) {
		$param_count = 0;
		$prepared_params = array();
		$query = "UPDATE $this->db_table SET ";
		foreach( $this as $key=> $value ) {
			if( ($key == 'db_table') || 
				($key == 'id_alias') ||
				($key == 'id') ||
				($key == 'result')) {continue;}

			if( isset($value) ) {
				if( $value == '' ) {
					$query .= "$key = NULL, ";
				} else {
					$query .= $key . ' = ?' . ', ';
					$prepared_params[] = $value;
				}
			}
		}

		//remove trailing comma from query
		$query = substr( $query, -0, (strlen( $query ) -2 ) );
		$query .= ' WHERE id = ?';
		$prepared_params[] = $this->id;
		$dbh = Database::Init();
		$sth = $dbh->pdo->prepare($query);
		if( $sth->execute($prepared_params) ){
            if($reload){
                $this->reload();
            }
			return true;
		}
		return false;
	}



	  //array syntax sugar for accessing attributes
    public function offsetSet($offset, $value) {
        $this->$offset = $value;
    }
    public function offsetExists($offset) {
        return isset($this->$offset);
    }
    public function offsetUnset($offset) {
        unset($this->$offset);
    }
    public function offsetGet($offset) {
        return isset($this->$offset) ? $this->$offset : null;
    }


}
