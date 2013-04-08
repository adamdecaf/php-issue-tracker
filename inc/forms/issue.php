<?php
/**
 * Comment Form 
 * Adam Shannon
 * 2009-12-21
 */
 
// Load some things.
require '../../config/config.php';
require '../frameworks/mysql.class.php';

// Load the mysql settings
	$mysql = new mysql_class;
	$mysql->set_vars(
		$config['mysql']['hostname'],
		$config['mysql']['username'],
		$config['mysql']['password']
	);
	
	// Clean the data
	$data = array(
		'username' => $mysql->clean($_POST['username']),
		'password' => $_POST['password'],
		'issue' => $mysql->clean($_POST['issue']),
		'comment' => $mysql->clean($_POST['comment']),
	);
	
	// Now store the database in a easy variable to access
	$db = $config['mysql']['database'];
	
	// The data from the POST request.
	$data = array(
		'priority' => $mysql->clean($_POST['priority']),
		'project' => $mysql->clean($_POST['project']),
		'status' => $mysql->clean($_POST['status']),
		'title' => $mysql->clean($_POST['title']),
		'summary' => $mysql->clean($_POST['summary']),
	);
	
	// Build the SQL
	$sql = 'INSERT INTO `' . $db . '`.`issues` (`issue_id`,`priority`,`project`,`status`,`public`,`created`,`assigned_to`,`title`,`summary`) VALUES ';
	$sql .= "(0,{$data['priority']},{$data['project']},{$data['status']},1,CURRENT_TIMESTAMP,-1,'{$data['title']}','{$data['summary']}');";
	
	$mysql->query($sql);
	
	header('Location: ../../index.php');
	
	