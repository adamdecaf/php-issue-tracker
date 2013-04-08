<?php
/**
 * MySQL Framework
 * Copyright (C)  2009  Adam Shannon
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * [:] This license applies to all subpages and directories, unless
 * [:] otherwise stated.
 */


class mysql_class {

	// Set some vars (these are used 
	// to connect with the server).
	private $hostname;
	private $username;
	private $password;
	private $connection;
	
	
	/**
	 * @name: set_vars
	 * This function will set the private variables to the specified connection.
	 *
	 * @parm: $hostname <- The URI** orIP** to connect to.
	 * @parm: $username <- The username** to connect with.
	 * @parm: $password <- The password** to connect with.
	 * @return: null
	 */
	// Notes:
	// ** - You should use my "validation.class.php" script to check the 
	//       validity of the strings before you use them to connect with.
	public function set_vars($hostname, $username, $password) {
		// Set the vars.
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		
		// Set the connection.
		$this->connection = $this->connect($this->hostname, $this->username, $this->password);
		
		return;
	}
	
	
	/**
	 * @name: clean
	 * This function will (in effect) run mysql_real_escape_string() on the string
	 *  that is submitted.
	 * 
	 * @parm: $string <- The string to clean
	 * @return: string
	 */
	public function clean($string) {
		// Clean the string
		return mysql_real_escape_string($string);
	}
	
	
	/**
	 * @name: connect
	 * This function will connect and return a mysql connection
	 *
	 * @parm: null <- They should be stored locally
	 * @return: MySQL Object [Or string on error]
	 */
	public function connect() {
		// Connect to a mysql DB and return said connection
		if ($this->hostname == '' || $this->username == '' || $this->password == '') {
			
			// Send a string back with the error
			// return "Error: You need to run set_vars!";
			return mysql_error();
			
		} else {
		
			// Connect
			$tmp = mysql_connect($this->hostname, $this->username, $this->password);
			
			// Check to see if it worked
			if (!$tmp) {
				
				// Send back an error message
				unset($tmp);
				return "Error: Your MySQL connection failed.";
				
			} else {
				
				// Send the connection back
				return $tmp;
				
			}
			
		}
	}
	
	
	/**
	 * @name: close
	 * This function will (alought not really needed) close a MySQL connection.
	 *
	 * @parm: null
	 * @return: bool
	 */
	public function close() {
		// Close out the connection
		if (mysql_close($this->connection)) {
		
			// Return true
			return true;
		
		} else {
			
			// Retrurn false
			return false;
			
		}
	}
	
	
	/**
	 * @name: affected_rows
	 * This function will return the (int) number of rows that were changed.
	 *
	 * @parm: null
	 * @return: int
	 */
	public function affected_rows() {
		// Find out how many rows were affected.
		return (int) @mysql_affected_rows($this->connection);
	}
	
	
	/**
	 * @name: assoc
	 * This function will grab a MYSQL_ASSOC array for the specified query result.
	 *
	 * @parm: $query
	 * @return: array
	 */
	public function assoc($query) {
		// Send the array back
		$data = array();
		$n = 0;
		
		while ($row = mysql_fetch_assoc($query)) {
			$data[$n++] = $row;
		}
		
		return $data;
	}
	
	
	/**
	 * @name: encoding_type
	 * This function will return the encoding for the current connection
	 *
	 * @parm: null
	 * @return: string
	 */
	public function encoding_type() {
		// Send back the encoding type
		return mysql_client_encoding($this->connection) || mysql_error();
	}
	
	
	/**
	 * @name: info
	 * This function will return some basic information about the mysql server.
	 *
	 * @parm: null
	 * @return: array
	 */
	public function info() {
		// Send some data back...
		return array(
			0 => 'Client Info' 	. mysql_get_client_info(),
			1 => 'Host Info' 	. mysql_get_host_info(),
			2 => 'Proto Info' 	. mysql_get_proto_info(),
			3 => 'Server Info' 	. mysql_get_server_info(),
			4 => 'Processes' 	. mysql_list_processes(),
			5 => 'General Info' . mysql_info(),
		);
	}
	
	/**
	 * @name: query
	 * This function will perform the all famous mysql_query() function.
	 *
	 * @parm: $sql
	 * @return: mysql_object
	 */
	public function query($sql) {
		// Send the query back
		return mysql_query($sql, $this->connection);
	}
	
	
	/**
	 * @name: search
	 * This function will perform a mysql search query.
	 *
	 * @parm: $sql
	 * @return: array
	 */
	public function search($sql) {
		
		// Perform the query
		$tmp_query = $this->query($sql);
		
		// Now grab the array.
		return $this->assoc($tmp_query);
		
	}
}