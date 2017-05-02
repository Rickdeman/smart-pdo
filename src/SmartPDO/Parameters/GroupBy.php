<?php

/**
 * File: GroupBy.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter GROUP BY
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class GroupBy {

	/**
	 * Column name
	 *
	 * @var string
	 */
	private $column;

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table;

	/**
	 * GROUP BY parameter initialiser
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *        	Full table name
	 * @param string $column
	 *        	Full column name
	 */
	function __Construct($table, $column) {
		$this->table = $table;
		$this->column = $column;
	}

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
}