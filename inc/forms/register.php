<?php
/**
 * Issue Tracker
 * Adam Shannon
 * 2009-12-24
 */
 
// Load some things.
require '../../config/config.php';
require '../frameworks/mysql.class.php';
require '../frameworks/rand_string.class.php';
	$string = new rand_string_class;

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
		'password' => $mysql->clean($_POST['password']),
		'email' => $mysql->clean($_POST['email']),
	);
	
	$dynamic = array(
		'access_level' => 50,
		'salt' => $string->generate(rand(8,16)),
		'cookie' => sha1($data['email']),
	);
	
	$pass = sha1($dynamic['salt'] . $data['password']);
	
	echo $dynamic['salt'] . '<br />';
	echo $data['password'] . '<br />';
	echo $pass;
	
	// Now store the database in a easy variable to access
	$db = $config['mysql']['database'];
	
	// Check to see if the email exists or not.
	$sql = 'SELECT `username` FROM `' . $db . '`.`users` WHERE `username` = "' . $data['username'] . '" LIMIT 1';
		$result['username'] = $mysql->search($sql);
		
	$sql = 'SELECT `email` FROM `' . $db . '`.`users` WHERE `email` = "' . $data['email'] . '" LIMIT 1';
		$result['email'] = $mysql->search($sql);
	
	// Check...
	if (empty($result['username']) && empty($result['email'])) {

		// Build the query.
		$sql = 'INSERT INTO `' . $db . '`.`users` (`user_id`,`username`,`access_level`,`created`,`email`,`password`,`salt`,`cookie_string`) VALUES';
		$sql .= "(0,'{$data['username']}','{$dynamic['access_level']}',CURRENT_TIMESTAMP,'{$data['email']}','{$pass}','{$dynamic['salt']}','{$dynamic['cookie']}');";
		
		$mysql->query($sql);
		header("Location: ../../index.php");
	} else {
		die('Someone already has that username or is using that email.');
	}
	