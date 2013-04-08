<?php
/**
 * RandString Class
 * Adam Shannon
 *
 * Decaf Productions License
 * <http://decafproductions.com/license.php>
 *
 * 09/29/2009
 */

class rand_string_class {

	// Set the allowed characters.
	// These are the ASCII values for 'a' and 'z'.
	public $ascii_min = 97;
	public $ascii_max = 122;
	public $allowed_characters = array('!', '@', '#', '\$', '%', '^', '&', '*', '(', ')', '-', '//', '\/', '\\');
	
	/**
	 * @name: generate
	 * This will generate a random string of length $length.
	 *
	 * @parm: $length <- [Optional] The strings length.
	 * @return: str
	 */
	public function generate($length = 8) {
	
		// Set some constants.
		$count = count($this->allowed_characters) - 1;
		$string = '';
		
		// Generate the string.
		for ($n = 0; $n < $length; $n++) {
			
			// Decide what to use.
			if (rand(0, 7) % 2 == 0) {
				
				// Use an ASCII character
				$string .= chr(rand($this->ascii_min, $this->ascii_max));
				
			} else {
			
				// Otherwise add a character.
				$string .= $this->allowed_characters[rand(0, $count)];
			
			}
			
		}
		
	return $string;
	}
	
}