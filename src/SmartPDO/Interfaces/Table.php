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
	 * @param \SmartPDO\Interfaces\Database $db
	 *        	SmartPDO Databse Database object
	 * @param string $table
	 *        	Selected table name
	 */
	function __Construct(\SmartPDO\Interfaces\Database $db, $table);
	
	/**
	 * Add INNER JOIN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $targetTable
	 *        	Source table name
	 * @param string $targetColumn
	 *        	Source table column
	 * @param string $sourceTable
	 *        	Target table, NULL for master table
	 * @param string $sourceColumn
	 *        	Target table column, null for ID
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addInnerJoin($targetTable, $targetColumn, $sourceTable = null, $sourceColumn = null);
	
	/**
	 * Add key value for inserting
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $column
	 *        	Column name to be used
	 * @param string|integer $value
	 *        	Value to be inserted in the column
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addInsert($column, $value);
	
	/**
	 * Add LEFT JOIN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $targetTable
	 *        	Source table name
	 * @param string $targetColumn
	 *        	Source table column
	 * @param string $sourceTable
	 *        	Target table, NULL for master table
	 * @param string $sourceColumn
	 *        	Target table column
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addLeftJoin($targetTable, $targetColumn, $sourceTable, $sourceColumn);
	
	/**
	 * Add Or
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param bool $group
	 *        	True for creating a new group, otherwise left handed will be created
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addOr($group = true);
	
	/**
	 * Add order by
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $column
	 *        	Column to be sorted by
	 * @param bool $asc
	 *        	True for ascending, false for descending
	 * @param string $table
	 *        	Target table, NULL for master table
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addOrderBy($column, $asc = true, $table = null);
	
	/**
	 * Add RIGHT JOIN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $targetTable
	 *        	Source table name
	 * @param string $targetColumn
	 *        	Source table columns
	 * @param string $sourceTable
	 *        	Target table, NULL for master table
	 * @param string $sourceColumn
	 *        	Target table column
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addRightJoin($targetTable, $targetColumn, $sourceTable, $sourceColumn);
	
	/**
	 * Add SET
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $column
	 *        	Column name to be updated
	 * @param string|integer $value
	 *        	Value to be inserted
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addSet($column, $value);
	
	/**
	 * Add WHERE comparison
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $column
	 *        	Columns name
	 * @param mixed $value
	 *        	Value to match, use NULL for 'IS NULL'
	 * @param string $comparison
	 *        	Comparision action, when value is NULL, use = or !=
	 * @param string $table
	 *        	Specified table, NULL for master table
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addWhere($column, $value, $comparison = '=', $table = null);
	
	/**
	 * Creates a DELETE query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return \SmartPDO\MySQL\Table
	 */
	public function delete();
	
	/**
	 * Execute query with created parameters
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return \SmartPDO\MySQL\Table\Rows
	 */
	public function execute();
	
	/**
	 * Create an INSERT query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return \SmartPDO\MySQL\Table
	 */
	public function insert();
	
	/**
	 * Create an SELECT query, default
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return \SmartPDO\MySQL\Table
	 */
	public function select();
	
	/**
	 * Set columns to be selected
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string|array $columns
	 *        	Columns name(s)
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function setColumns($columns);
	
	/**
	 * Add LIMIT
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param integer $start
	 *        	The start index
	 * @param integer $items
	 *        	The maximum amount of rows to fetch
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function setLimit($start, $items);
	
	/**
	 * Create an UPDATE query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return \SmartPDO\MySQL\Table
	 */
	public function update();
}