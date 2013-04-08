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
		'issue_id'  => $mysql->clean($_POST['issue_id']),
		'priority' 	=> $mysql->clean($_POST['priority']),
		'project' 	=> $mysql->clean($_POST['project']),
		'status' 	=> $mysql->clean($_POST['status']), 
		'assigned' 	=> $mysql->clean($_POST['assigned']),
		'username' 	=> $mysql->clean($_POST['username']), 
		'password' 	=> $mysql->clean($_POST['password']), 
		'comment'	=> $mysql->clean($_POST['comment']),
	);
	
	// Place a false comment if there isn't one submitted.
	if ($data['comment'] === '' || empty($data['comment'])) {
		$data['comment'] = 'This issue has been changed.';
	}
	 
	// Ok, check to see if the user is able to edit.
	$sql = 'SELECT * FROM `' . $db . '`.`users` WHERE `username` = "' . $data['username'] . '" LIMIT 1';
		$u = $mysql->search($sql);
		$user = $u[0];
		
		if (sha1($user['salt'] . $data['password']) === $user['password']) {
			
			// Ok, we have the correct data so check to see if the user is able to edit it.
			if ($user['access_level'] >= 80) {
				
				// Set up the query to update the row.
				$sql = "UPDATE  `$db`.`issues` SET  ";
				$sql .= "`priority` =  '{$data['priority']}', ";
				$sql .= "`project` =  '{$data['project']}', ";
				$sql .= "`status` =  '{$data['status']}', ";
				$sql .= "`assigned_to` =  '{$data['assigned']}'";
				$sql .= " WHERE  `issues`.`issue_id` = {$data['issue_id']} LIMIT 1 ;";
				
				// Update the record
				$mysql->query($sql);
				
				// Now, add a new comment with the note.
				// comment_id, issue_id, from, created, comment
				$sql = 'INSERT INTO `' . $db . '`.`comments` (`comment_id`, `issue_id`, `from`, `created`, `comment`) VALUES ';
				$sql .= "(0,'{$data['issue_id']}','{$user['user_id']}',CURRENT_TIMESTAMP,'{$data['comment']}');";
				
				// Insert the comment.
				$mysql->query($sql);
				
				header('Location: ../../issue.php?id=' . $data['issue_id']);
				
			} else {
				die('Your account doesn\'t have the access rights to edit issues.');
			}
			
		} else {
			die('The username/password are wrong, please try again.');
		}