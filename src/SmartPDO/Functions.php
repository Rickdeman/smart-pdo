<?php

/**
 * File: Functions.php
 */
namespace SmartPDO;

/**
 * General functions for SmartPDO
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *		
 */
class Functions
{

	/**
	 * Validates if a string starts with a section
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $part
	 *			The part which the string must start with
	 * @param string $string
	 *			The string to look in
	 * @param bool $lowerCase
	 *			Compare with al lowercase characters
	 *			
	 * @return boolean
	 */
	public static function startsWith(string $part, string $string, bool $lowerCase = false)
	{
		// Check for lowercase bool
		if ($lowerCase === true) {
			// Lowercase all strings
			$part = strtolower($part);
			$string = strtolower($string);
		}
		// Verify 'starts with'
		return $part === "" || strpos($string, $part) === 0;
	}
}