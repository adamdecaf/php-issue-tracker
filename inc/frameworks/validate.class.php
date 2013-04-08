<?php
/**
 * Text/Plain Validation Framework
 * Copyright (C)  2009  Adam Shannon
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * [:] This license applies to all subpages and directories, unless
 * [:] otherwise stated.
 */

class validation_class {

	// Set the allowed symbols
	// These should be albe to become appended
	// to the end of a regex bracket.
	// e.g. [a-z0-9{$allowed_symbols}]
	public $allowed_symbols = '-_!@#$%^&*';

	/**
	 * @name: check_limits
	 * This function will check the limits for the rest of the class.
	 *
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: array -> The array containing the limits [, bool -> on error (limits not valid)].
	 */
	public function check_limits($limits = array(2)) {
		// Check to see if the limits are numeric
		if (!is_numeric($limits[0]) || !is_numeric($limits[1])) {
		
			// "Throw" an error
			return "Limit(s) are not numeric!";
			
		} else {
			
			// Convert the limits to int's if they are numeric
			$limits[0] = (int) $limits[0];
			$limits[1] = (int) $limits[1];
			
			// Now check to see if the value is acceptable or not.
			if ($limits[1] < $limits[0]) {
				$tmp = $limits[0];
				$limits[0] = $limits[1];
				$limits[1] = $tmp;
			}
			
			// Check to see if they are negative
			if ($limits[0] < 0) {
				$limits[0] *= -1;
			}
			
			if ($limits[1] < 0) {
				$limits[1] *= -1;
			}
			
		}
		
		// Send the limit(s) back
		return $limits;
	}
	
	
	/**
	 * @name: check
	 * This function will take a regex and a string then compare the two and return
	 *	a bool based on the result.
	 * 
	 * @parm: $regex -> The regular expression to check the string against.
	 * @parm: $str -> The string to check
	 * @return: bool
	 */
	public function check($regex, $str) {
		// Now compare the string against the regex.
		if (preg_match($regex, strtolower($str))) {
				
			// Return true if the string matches
			return '<strong>true</strong>';
				
		} else {
			
			// Return false if the string does not match.
			return '<em>false</em>';
				
		}
		
		// On an error return false.
		return 'false';
	}
	
	
	/**
	 * @name: alpha
	 * This function will check to see if a string contains only alpha characters
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function alpha($str, $limits = array(2)) {
		// Check the limits
		$this->check_limits($limits);
		
		// Build the regex.
		$regex = '/^[a-z]{' . $limits[0] . ',' . $limits[1] . '}$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	
	/**
	 * @name: numeric
	 * This function will check to see if a string [/number] is numeric.
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function numeric($str, $limits = array(2)) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^[0-9]{' . $limits[0] . ',' . $limits[1] . '}$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	
	/**
	 * @name: alpha_numeric
	 * This function will check to see if a string contains only alpha numeric characters.
	 *	If the string does it then returns a bool of true and if not a bool of false.
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function alpha_numeric($str, $limits = array(2)) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^[a-z0-9]{' . $limits[0] . ',' . $limits[1] . '}$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	
	/**
	 * @name: symbols
	 * This function will check to see if a string contains only symbol characters.
	 *	If the string does it then returns a bool of true and if not a bool of false.
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function symbols($str, $limits = array(2)) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^[' . $this->allowed_symbols . ']{' . $limits[0] . ',' . $limits[1] . '}$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	/**
	 * @name: alpha_symbols
	 * This function will check to see if a string contains only alpha numeric and symbol characters.
	 *	If the string does it then returns a bool of true and if not a bool of false.
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function alpha_symbols($str, $limits = array(2)) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^[a-z' . $this->allowed_symbols . ']{' . $limits[0] . ',' . $limits[1] . '}$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	
	/**
	 * @name: numeric_soybols
	 * This function will check to see if a string contains only alpha numeric characters.
	 *	If the string does it then returns a bool of true and if not a bool of false.
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function numeric_symbols($str, $limits = array(2)) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^[0-9' . $this->allowed_symbols . ']{' . $limits[0] . ',' . $limits[1] . '}$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	
	/**
	 * @name: alpha_numeric_symbols
	 * This function will check to see if a string contains only alpha numeric characters.
	 *	If the string does it then returns a bool of true and if not a bool of false.
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function alpha_numeric_symbols($str, $limits = array(2)) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^[a-z0-9' . $this->allowed_symbols . ']{' . $limits[0] . ',' . $limits[1] . '}$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	
	/**
	 * @name: email
	 * This function will check to see if the string matches a common email pattern
	 *	
	 *	user@domain.tld
	 *	first.last@domain.tld
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function email($str, $limits = array(2)) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{' . $limits[0] . ',' . $limits[1] . '})$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	
	/**
	 * @name: ip
	 * This function will check to see if the string matches a common IP Address pattern
	 *	
	 *	127.000.000.0001
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function ip($str) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
	
	/**
	 * @name: url
	 * This function will check to see if the string matches a common IP Address pattern
	 *	
	 *	http://domain.tld
	 *	https://domain.tld
	 
	 *	http://sub.domain.tld
	 *	https://sub.domain.tld
	 *
	 * @parm: $str -> The string to check against
	 * @parm: @limits -> An array containing the [lower, upper] bounds for the strings length.
	 * @return: bool [, string (on error only)]
	 */
	public function url($str) {
		// Check the limits
		$limits = $this->check_limits($limits);
		
		// Build the regex
		$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
		
		// Now check the string and return the result.
		return $this->check($regex, $str);
	}
	
}