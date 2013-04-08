<?php
/**
 * Issue Tracker
 * Adam Shannon
 * 2009-12-23
 */
 
// Load and connect to the db.
include 'inc/frameworks/mysql.class.php';
	$mysql = new mysql_class;
	$mysql->set_vars(
		$config['mysql']['hostname'],
		$config['mysql']['username'],
		$config['mysql']['password']
	);
	
	// Now store the database in a easy variable to access
	$db = $config['mysql']['database'];
