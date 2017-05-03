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
	 * add (AND) BETWEEN
	 *
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @version 1
	 *
	 * @param string $column
	 *        	table column
	 * @param double|int|\DateTime|string $start
	 *        	Start value
	 * @param double|int|\DateTime|string $stop
	 *        	End value
	 * @param bool $not
	 *        	Whether is must be in the list or not
	 * @param string $table
	 *        	Target table, NULL for root table
	 */
	public function between($column, $start, $stop, $not = false, $table = null);

	/**
	 * Set columns to be selected
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $columns
	 *        	Columns to be shown, fully named when using JOIN(s)
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function columns(...$columns);

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
	 * create a AND/OR group
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param bool $and
	 *        	True for an AND group otherwise OR
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function group($and = false);

	/**
	 * Add GROUP BY
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Column to be sorted by
	 * @param string $table
	 *        	Target table, NULL for root table
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function groupBy($column, $table = null);

	/**
	 * Add (AND) IN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Column name
	 * @param array $list
	 *        	(multiple) strings for WHERE IN
	 * @param bool $not
	 *        	Whether is must be in the list or not
	 * @param string $table
	 *        	Target table, NULL for root table
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function in($column, $list, $not = false, $table = null);

	/**
	 * Add INNER JOIN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $targetTable
	 *        	Target table name
	 * @param string $targetColumn
	 *        	Target table column, null for root table ID
	 * @param string $sourceTable
	 *        	Source table, NULL for root table
	 * @param string $sourceColumn
	 *        	Source table column, null for ID
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function innerJoin($targetTable, $targetColumn = null, $sourceTable = null, $sourceColumn = null);

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
	 * Add LEFT JOIN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $targetTable
	 *        	Target table name
	 * @param string $targetColumn
	 *        	Target table column, null for root table ID
	 * @param string $sourceTable
	 *        	Source table, NULL for root table
	 * @param string $sourceColumn
	 *        	Source table column, null for ID
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function leftJoin($targetTable, $targetColumn = null, $sourceTable = null, $sourceColumn = null);

	/**
	 * add LIKE
	 *
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @version 1
	 *
	 * @param string $column
	 *        	Column name
	 * @param mixed $value
	 *        	Value to be compared
	 * @param bool $not
	 *        	if true will change to LIKE NOT
	 * @param string|null $table
	 *        	Table name, null for root table
	 * @param string $escape
	 *        	Escape character, which can be changed
	 */
	public function like($column, $value, $not = false, $table = null, $escape = "!");

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
	public function limit($start, $items);

	/**
	 * Add ORDER BY
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Column to be sorted by
	 * @param bool $asc
	 *        	True for ascending, false for descending
	 * @param string $table
	 *        	Target table, NULL for root table
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function orderBy($column, $asc = true, $table = null);

	/**
	 * Add RIGHT JOIN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $targetTable
	 *        	Target table name
	 * @param string $targetColumn
	 *        	Target table column, null for root table ID
	 * @param string $sourceTable
	 *        	Source table, NULL for root table
	 * @param string $sourceColumn
	 *        	Source table column, null for ID
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function rightJoin($targetTable, $targetColumn = null, $sourceTable = null, $sourceColumn = null);

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
	 * Add SET
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	table column
	 * @param string|integer $value
	 *        	Value to be updated
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function set($column, $value);

	/**
	 * Set the AND to OR for single time
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param number $times
	 *        	The number of times a OR is requested
	 *
	 * @return \SmartPDO\MySQL\Table
	 *
	 */
	public function setOr($times = 1);

	/**
	 * Create an UPDATE query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function update();

	/**
	 * Add key value for inserting
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	table column
	 * @param string|integer $value
	 *        	Value to be inserted
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function value($column, $value);

	/**
	 * Add (AND) WHERE comparison
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
	 *        	Specified table, NULL for root table
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function where($column, $value, $comparison = '=', $table = null);
}