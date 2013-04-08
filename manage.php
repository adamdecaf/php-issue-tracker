<?php
/**
 * Issue Tracker
 * Adam Shannon
 * 2009-12-23
 */
 
// Check to see if we have an issue at all.
if (!$_GET['id'] || empty($_GET['id'])) {
	header('Location: index.php');
}

// Load some frameworks and then the prefs.
include 'config/config.php';
include 'system/mysql.php';
include 'system/template.php';

	// Ok, let's go back and grab the template
	include $template['header'];
	
		// Load the data on the issue.
		$i = $mysql->search("SELECT * FROM `$db`.`issues` WHERE `issue_id` = " . $mysql->clean($_GET['id']) . " LIMIT 1");
		$issue = $i[0];
	
		// Load the template to manage an issue.
		include $template['manage_issue'];
		
		// Set the js variables.
		$js = array(
			'priority' => $issue['priority'],
			'project' => $issue['project'],
			'status' => $issue['status'],
			'assigned_to' => $issue['assigned_to']
		);
	
	// Close it out with the footer.
	include $template['footer'];
	