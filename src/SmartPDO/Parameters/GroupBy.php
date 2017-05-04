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
 */
class GroupBy extends \SmartPDO\Parameters\WhereLogic {

	/**
	 * GROUP BY parameter initialiser
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @param string $table
	 *        	Full table name
	 * @param string $column
	 *        	Full column name
	 */
	function __Construct($table, $column) {
		$this->table = $table;
		$this->column = $column;
	}
}