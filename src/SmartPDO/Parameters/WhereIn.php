<?php

/**
 * File: WhereIn.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter WHERE
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class WhereIn extends \SmartPDO\Parameters\WhereLogic {
	/**
	 * values for IS IN
	 *
	 * @var array
	 */
	private $list;

	/**
	 * Flag for IS NOT
	 *
	 * @var bool
	 */
	private $not;

	/**
	 * FunctionDescription
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param unknown $table
	 * @param unknown $column
	 * @param unknown $list
	 * @param unknown $not
	 * @param unknown $and
	 */
	public function __Construct($table, $column, $list, $not, $and) {
		$this->table = $table;
		$this->column = $column;
		$this->list = $list;
		$this->not = $not;
		$this->and = $and === true;
	}

	/**
	 * Get all values for IS IN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return array
	 */
	function getList() {
		return $this->list;
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