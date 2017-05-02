<?php

/**
 * File: Where.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter WHERE
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class Where extends \SmartPDO\Parameters\WhereLogic {

	/**
	 *
	 * @var bool|string
	 */
	private $comparison;

	/**
	 *
	 * @var mixed
	 */
	private $value;

	/**
	 * WHERE parameter initialiser
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *        	Full table name
	 * @param string $column
	 *        	Full column name
	 * @param unknown $comparison
	 * @param unknown $value
	 * @param unknown $and
	 */
	function __Construct($table, $column, $comparison, $value, $and) {
		$this->table = $table;
		$this->column = $column;
		$this->comparison = $comparison;
		$this->value = $value;
		$this->and = $and === true;
	}

	/**
	 * Get the Comparison method
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return boolean|string
	 */
	public function getComparison() {
		return $this->comparison;
	}

	/**
	 * Get the value for the statement
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}
}