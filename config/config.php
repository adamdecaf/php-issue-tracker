<?php
/**
 * Issue Tracker
 * Adam Shannon
 * 2009-12-23
 */
 
$config = array();

// Set the template directory.
$template_dir = 'default';

	// Check to see if a template has been chosen.
	if ($_GET['template'] !== '' && !empty($_GET['template'])) {
		$template_dir = $_GET['template'];
	}

// The mysql part
$config['mysql'] = array(
	'hostname' => '',
	'username' => '',
	'password' => '',
	'database' => 'issue-tracker',
);


// Set the priority for items
$config['priority'] = array(
	0 => 'low',
	1 => 'medium',
	2 => 'high',
	3 => 'severe',
	10 => 'none'
);


// The status for issues
$config['status'] = array(
	0 => 'reported',
	1 => 'assigned',
	2 => 'in progress',
	3 => 'testing',
	4 => 'pushed',
	5 => 'solved',
	10 => 'duplicate'
);


// ========================================
// ==       Don't edit below this!       ==
// ========================================

// Set the access level for each account.
$config['access'] = array(
	0 => 'guest',
	10 => 'banned',
	40 => 'restricted',
	50 => 'member',
	60 => 'reporter',
	70 => 'developer',
	80 => 'moderator',
	90 => 'admin'
);

// Check for mysql data.
if (empty($config['mysql']['hostname']) || $config['mysql']['hostname'] === '') {
	die("You need to fill in a hostname for the MySQL data.");
}

if (empty($config['mysql']['username']) || $config['mysql']['username'] === '') {
	die("You need to fill in a username for the MySQL data.");
}

if (empty($config['mysql']['password']) || $config['mysql']['password'] === '') {
	die("You need to fill in a username for the MySQL data.");
}

if (empty($config['mysql']['database']) || $config['mysql']['database'] === '') {
	die("You need to fill in a database for the MySQL data.");
}
