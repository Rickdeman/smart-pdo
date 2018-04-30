<?php

/**
 * File: Limit.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo MOD Parameter
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class Mod extends Set
{
	
	/**
	 * modify action
	 *
	 * @var string
	 */
	private $operator;

	/**
	 * MODE SET parameter initialiser
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Full column name
	 * @param string $comparison
	 *        	Comparision action see compareList for more info
	 * @param string $value
	 *        	Value to compare
	 */
	function __Construct(string $column, string $operator, $mod) {
		$this->column = $column;
		$this->operator = $operator;
		$this->value = $mod;
	}

	/**
	 * Get the operator function
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */	
	public function getOperator()
	{
		return $this->operator;
	}
	
}