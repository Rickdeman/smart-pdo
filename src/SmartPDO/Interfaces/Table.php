<?php

/**
 * File: Table.php
 */
namespace SmartPDO\Interfaces;
 
/**
 * Interface for all SmartPDO Table handlers
 *
 * @author Rick de Man
 * @version 1
 *         
 */
interface Table {
		
	/**
	 * Mysql table constructor
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param \SmartPDO\Mysql $mysql
	 *        	Mysql class object
	 * @param string $table
	 *        	Selected table name
	 */
	function __Construct(\SmartPDO\Interfaces\Database $mysql, $table);
	
	/**
	 * Add Oy
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param bool $group
	 *        	True for creating a new group, otherwise left handed will be created
	 *
	 * @return \SmartPDO\Interfaces\Table
	 */
	public function addOr($group = true);
	
	/**
	 * Add here
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Columns name
	 * @param mixed $value
	 *        	Value to match
	 * @param string $comparison
	 *        	Comparision action '= | >= | <=' etc
	 * @param string $table
	 *        	Default the main table is used, otherwise as specified
	 *
	 * @return \SmartPDO\Interfaces\Table
	 */
	public function addWhere($column, $value, $comparison = '=', $table = null);
	
}