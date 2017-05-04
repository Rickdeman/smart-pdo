<?php

/**
 * File: Where.php
 */
namespace SmartPDO\Parameters\Where;

/**
 * SmartPdo Parameter WHERE
 * 
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class Like extends \SmartPDO\Parameters\WhereLogic {

	/**
	 * escape character
	 * 
	 * @var string
	 */
	private $escape;

	/**
	 * Value to compare
	 * 
	 * @var mixed
	 */
	private $value;

	/**
	 * WHERE parameter initialiser
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @param string $table
	 *        	Full table name
	 * @param string $column
	 *        	Full column name
	 * @param bool $comparison
	 *        	Comparision action see compareList for more info
	 * @param string $value
	 *        	Value to compare
	 * @param string $and
	 *        	AND condition if true, else OR
	 */
	function __Construct($table, $column, $value, $not, $escape, $and) {
		$this->table = $table;
		$this->column = $column;
		$this->value = $value;
		$this->escape = $escape;
		$this->not = $not === true;
		$this->and = $and === true;
	}

	/**
	 * Get the value for the statement
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @return mixed
	 */
	public function getEscape() {
		return $this->escape;
	}

	/**
	 * Get the value for the statement
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}
}