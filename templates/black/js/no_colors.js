/**
 * No Colors
 * Adam Shannon
 * 2009-12-23
 */
 
function no_colors() {
	var elms = document.getElementsByTagName('tr');
	var count = elms.length;
	var n = 0;
	
	for (n = 0; n < count; n++) {
		elms[n].style.backgroundColor = '#FFFFFF';
	}
}