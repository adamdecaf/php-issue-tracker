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

	// Ok, let's go back and grab the template
	include $template['header'];
	
		// Include the form to register with
		include $template['register_form'];
	
	// Close it out with the footer.
	include $template['register_footer'];
	include $template['footer'];