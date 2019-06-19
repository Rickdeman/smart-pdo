<?php

/**
 * File: Where.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter WHERE
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class Where extends \SmartPDO\Parameters\WhereLogic {

	/**
	 * Comparision action
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $comparison;

	/**
	 *
	 * Value to compare
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var mixed
	 */
	private $value;

	/**
	 * WHERE parameter initialiser
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *			Full table name
	 * @param string $column
	 *			Full column name
	 * @param string $comparison
	 *			Comparision action see compareList for more info
	 * @param string $value
	 *			Value to compare
	 * @param string $and
	 *			AND condition if true, else OR
	 */
	function __Construct(string $table, string $column, string $comparison, $value, bool $and) {
		$this->table = $table;
		$this->column = $column;
		$this->comparison = $comparison;
		$this->value = $value;
		$this->and = $and === true;
	}

	/**
	 * Get the Comparison method
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getComparison() {
		return $this->comparison;
	}

	/**
	 * Get the value for the statement
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}
}