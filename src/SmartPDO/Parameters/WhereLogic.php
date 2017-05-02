<?php

/**
 * File: WhereLogic.php
 */
namespace SmartPDO\Parameters;

class WhereLogic {

	/**
	 * statement logic AND
	 *
	 * @var bool
	 */
	protected $and = false;

	/**
	 * Column name
	 *
	 * @var string
	 */
	protected $column;

	/**
	 * Table name
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * Get the column name
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	function getColumn() {
		return $this->column;
	}

	/**
	 * Get the table name
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	function getTable() {
		return $this->table;
	}

	/**
	 * Check if ordering ascending or descending
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return bool
	 */
	function isAnd() {
		return $this->and === true;
	}
}