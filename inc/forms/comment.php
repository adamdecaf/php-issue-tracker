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
 
// First check to see if the user is correct.
	$sql = 'SELECT * FROM `' . $db . '`.`users` WHERE `username` = "' . $data['username'] . '"';
		$user_return = $mysql->search($sql);
		$user = $user_return[0];
	
	// Ok, now compare the user against the stored data.
	if (sha1($user['salt'] . $data['password']) === $user['password']) {
		
		// Insert the comment
		$sql = 'INSERT INTO `' . $db . '`.`comments` (`comment_id`, `issue_id`, `from`, `created`, `comment`) VALUES ';
		$sql .= "('0','{$data['issue']}','{$user['user_id']}',CURRENT_TIMESTAMP,'{$data['comment']}');";
		
			// Insert the row
			$mysql->query($sql);
			
			// Send the user back.
			header('Location: ../../issue.php?id=' . $data['issue']);
		
	} else {
		
		echo 'Your userdata seems to be incorrect, please try again.';
		
	}
	