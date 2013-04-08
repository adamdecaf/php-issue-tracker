<?php
/**
 * Issue Tracker
 * Adam Shannon
 * 2009-12-23
 */
 
error_reporting(E_NONE);
 
// Check to see if we have an issue at all.
if (!$_GET['id'] || empty($_GET['id'])) {
	header('Location: index.php');
}

// Load some frameworks and then the prefs.
include 'config/config.php';
include 'system/mysql.php';
include 'system/template.php';

	// The issue id.
	$id = $mysql->clean($_GET['id']);
	
	// Let's grab the global issues.
	$sql = 'SELECT * FROM `' . $db . '`.`issues` WHERE `public` = 1 AND `issue_id` = ' . $id . ' ORDER BY `issue_id` DESC LIMIT 20';
		$issue = $mysql->search($sql);
	
	// Grab the project
	$sql = 'SELECT * FROM `' . $db . '`.`projects` WHERE `project_id` = ' . $issue[0]['project'] . ' LIMIT 20';
		$project = $mysql->search($sql);
		
	// Grab the users
	$sql = 'SELECT * FROM `' . $db . '`.`users` WHERE `user_id` = ' . $issue[0]['assigned_to'] . ' LIMIT 20';
		$user_tmp = $mysql->search($sql);
		
			$user = $user_tmp[0];
		
	// Crab the comments
	$sql = 'SELECT * FROM `' . $db . '`.`comments` WHERE `issue_id` = ' . $issue[0]['issue_id'] . ' LIMIT 20';
		$comments = $mysql->search($sql);
		
		$sql = 'SELECT * FROM `' . $db . '`.`users` WHERE ';
		foreach ($comments as $c) {
			$sql .= '`user_id` = ' . $c['from'] . ' OR ';
		}
		
		$sql = substr($sql, 0, -3);
		$sql .= 'LIMIT 100';
		
			$users_orig = $mysql->search($sql);
			
			foreach ($users_orig as $u) {
				$users[$u['user_id']] = $u;
			}
		
	// Ok, let's go back and grab the template
	include $template['header'];
	
	// Print out the issues.
	// include $template['issue_page_header'];
	
		// Now print out the issue details.
		include $template['issue_page_content'];
	
	
	// Close it out with the footer.
	include $template['issue_page_footer'];
	include $template['footer'];