<?php

/**
 * File: Between.php
 */
namespace SmartPDO\Parameters\Where;

/**
 * SmartPdo Parameter WHERE: BETWEEN
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class Between extends \SmartPDO\Parameters\WhereLogic {

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
	 * @param double|int|\DateTime $start
	 *        	Start value
	 * @param double|int|\DateTime $stop
	 *        	Stop value
	 * @param bool $not
	 *        	Boolean for IS NOT
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
}