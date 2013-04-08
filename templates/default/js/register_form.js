/**
 * Issue Tracker
 * Adam Shannon
 * 2009-12-23
 */

function check_form() {
	// Because of the massive types of entry, we're going to just check
	// to see if the fields are filled in.
	var 
		username = document.getElementById('u_name'),
		password = document.getElementById('u_pass'),
		email = document.getElementById('u_email');
		
	var 
		all_good = true,
		border = '1px solid #FF0000';
	
	if (username.value === '') {
		all_good = false;
		username.style.border = border;
		username.title = 'You need to enter a value';
	}
	
	if (password.value === '') {
		all_good = false;
		password.style.border = border;
		password.title = 'You need to enter a value';
	}
	
	if (email.value === '') {
		all_good = false;
		email.style.border = border;
		email.title = 'You need to enter a value';
	}
	
	if (all_good === true) {
		document.getElementsByTagName('form')[0].submit();
	}
}