<?php
/**
 * Issue Tracker
 * Adam Shannon
 * 2009-12-23
 */

// Load some frameworks and then the prefs.
include 'config/config.php';
include 'system/mysql.php';
include 'system/template.php';

	// Ok, now that we have the prefs we can begin to grab the data for the front page.
	$data = array();
	
	// Let's grab the global issues.
	$sql = 'SELECT * FROM `' . $db . '`.`issues` WHERE `public` = 1 ORDER BY `issue_id` DESC LIMIT 100';
	$data['issues'] = $mysql->search($sql);
	
	// Grab the projects
	$sql = 'SELECT * FROM `' . $db . '`.`projects` ORDER BY `project_id` DESC LIMIT 100';
	$projects_orig = $mysql->search($sql);
	$projects = array();
	
		// Sort the projects
		foreach ($projects_orig as $proj) {
			$projects[$proj['project_id']] = $proj;
		}
		
	// Grab the users
	$sql = 'SELECT * FROM `' . $db . '`.`users` ORDER BY `user_id` DESC LIMIT 100';
	$users_orig = $mysql->search($sql);
	$users = array();
	
		// Sort the projects
		foreach ($users_orig as $u) {
			$users[$u['user_id']] = $u;
		}
		
	// Ok, let's go back and grab the template
	include $template['header'];
	
	// Print out the issues.
	include $template['issue_header'];
	
	foreach ($data['issues'] as $issue) {
		include $template['issue'];
	}
	
	include $template['issue_footer'];
	
	// Close it out with the footer.
	include $template['footer'];