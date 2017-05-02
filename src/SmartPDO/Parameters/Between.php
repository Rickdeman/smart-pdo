<?php

/**
 * File: Between.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter WHERE: BETWEEN
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class Between extends \SmartPDO\Parameters\WhereLogic {

	/**
	 * Flag for ascending or not
	 *
	 * @var bool
	 */
	private $ascending;

	/**
	 * Flag for IS NOT
	 *
	 * @var bool
	 */
	private $not;

	/**
	 * Start value for BETWEEN
	 *
	 * @var number
	 */
	private $start;

	/**
	 * end value for BETWEEN
	 *
	 * @var number
	 */
	private $stop;

	/**
	 * BETWEEN parameter initialiser
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *        	Full table name
	 * @param string $column
	 *        	Full column name
	 * @param bool $ascending
	 *        	sorting order is ascending or not
	 * @param bool $and
	 *        	if the AND statement should be used or OR
	 */
	function __Construct($table, $column, $start, $stop, $not, $and) {
		$this->table = $table;
		$this->column = $column;
		$this->start = $start;
		$this->stop = $stop;
		$this->not = $not;
		$this->and = $and === true;
	}

	/**
	 * Get the start value
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return number
	 */
	function getStart() {
		return $this->start;
	}

	/**
	 * Get the stop value
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return number
	 */
	function getStop() {
		return $this->stop;
	}

	/**
	 * Check if ordering ascending or descending
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return bool
	 */
	function isAscending() {
		return $this->ascending === true;
	}

	/**
	 * Check if condition is inverted: IS NOT
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return bool
	 */
	function isNot() {
		return $this->not === true;
	}
}