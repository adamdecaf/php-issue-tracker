/**
 * Issue Tracker
 * Adam Shannon
 * 2009-12-23
 */

function check_form() {
	// Because of the massive types of entry, we're going to just check
	// to see if the fields are filled in.
	var 
		title = document.getElementById('u_tite'),
		summary = document.getElementById('u_summary');
		
	var 
		all_good = true,
		border = '1px solid #FF0000';
	
	if (title.value === '') {
		all_good = false;
		title.style.border = border;
		title.title = 'You need to enter a value';
	}
	
	if (summary.value === '') {
		all_good = false;
		summary.style.border = border;
		summary.title = 'You need to enter a value';
	}
	
	if (all_good === true) {
		document.getElementsByTagName('form')[0].submit();
	}
}