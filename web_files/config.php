<?php
	$sqlconfig = array(
		'Host' => 'localhost',
		'User' => 'root',
		'Pass' => 'pass',
		'Data' => 'Database_name',  //Obviously the 
		'Ttbl' => 'Tickets_Table',  //This is the table for all the stored tickets.
		'Ptbl' => 'Player_Table',   //Used for logging in and assigning tickets to individuals.
		'Mtbl' => 'Messager_Table'  //This table stores all the messages between the different tickets.
	);
	
	$init_setup = true;  //Change this to false after you run it for the first time to save on loading.
	
class ticketdb {

	global $sqlconfig;
	var $db_connect_id = '';
	var $host = '';
	var $sql_user = '';
	var $dbname = '';
	var $result = '';
	var $rows = array();
	var $row = '';
	var $sql_error = '';
	var $sql_success = true;
	
	
	function connect($sqlhost = "localhost", $sqluser = "root", $sqlpass = "pass", $port = false) {
	
		$this->host = $sqlhost;
		$this->sql_user = $sqluser;
		$this->db_connect_id = @mysql_connect($sqlhost, $sqluser, $sqlpass);
		if($this->db_connect_id == false){
			echo "Failed to connect to server: " . mysql_error();
		}
		
	}
	
	
	function query($query) {
	
		if(($this->result = @mysql_query($query, $this->db_connect_id)) === false) {
		
			$this->sql_success = false;
			
		} else {
		
			$this->sql_success = true;
			
		}
		
		return $this->result;
	}
	
	function select_db($dbn){
		if(@mysql_select_db($dbn, $this->db_connect_id) == false){
			echo "Failed to select database, did you type in in right?<br>" . mysql_error();
		}
	}
	
	function num_rows() {
	
		return mysql_num_rows($this->result);
		
	}
	
	function escape_insert($table = '', $fields = array(), $insert = array()) {
		if($table == '' && empty($insert) && empty($fields)){
			
			return false;
			
		} else if(empty($fields)) {
        	$tinsert = array();
            for($i = 0; $i < count($insert); $i++) {
				$tinsert[$i] = "'" . mysql_real_escape_string($insert[$i]) . "'";
			}
            
            $this_insert = implode(', ', $tinsert);
		
			$query = "INSERT INTO " . $table . " VALUES ( " . $this_insert . " );";
			
			return $this->query($query);
			//return $query;
			
		} else if(count($insert) == count($fields)) {
			$tinsert = array();
			$tfields = array();
			for($i = 0; $i < count($insert); $i++) {
				$tinsert[$i] = "'" . mysql_real_escape_string($insert[$i]) . "'";
			}
			
			for($i = 0; $i < count($fields); $i++){
				$tfields[$i] =  mysql_real_escape_string($fields[$i]);
			}
			
			$this_insert = implode(', ', $tinsert);
			$this_fields = implode(', ', $tfields);
			
			$query = "INSERT INTO " . $table . " ( " . $this_fields . " ) VALUES ( " . $this_insert . " );";
			
			return $this->query($query);
			//return $query;

		} else {
		
			return false;
			
		}

	}
	
	function escape_string($string) {
	
		return @mysql_real_escape_string($string);
		
	}
	
	function rt_array() {
	
		return @mysql_fetch_array($this->result);
		
	}
	
	function rt_row($field) {
		if($this->num_rows() != 1) {
			
			return 0;
			
		} else {
			
			$row = array();
			$row = @mysql_fetch_array($this->result);
			
			return $row[$field];
		}
		
	}
	
	function claim_ticket($id, $helper){
		$query = "";
	}
	
	function delete_ticket($id){
	
	}
	
	function ticket_post($id, $player, $message, $helper=false){
	
	}
	
	function claim_ticket($id, $helper){
	
	}
	
	function close_ticket($id){
	
	}
}

$gendb = new ticketdb();
$gendb->connect($sqlconfig['Host'], $sqlconfig['User'], $sqlconfig['Pass']);
$gendb->select_db($sqlconfig['Data']);
?>