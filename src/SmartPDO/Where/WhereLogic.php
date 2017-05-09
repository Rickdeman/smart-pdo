<?php

/**
 * File: WhereLogic.php
 */
namespace SmartPDO\Where;

/**
 * Default parameters for a WHERE
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
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
	 * Flag for IS NOT
	 *
	 * @var bool
	 */
	protected $not = false;

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
	public function getColumn() {
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
	public function getTable() {
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
	public function isAnd() {
		return $this->and === true;
	}

	/**
	 * Check if condition is inverted: IS NOT
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return bool
	 */
	public function isNot() {
		return $this->not === true;
	}
}