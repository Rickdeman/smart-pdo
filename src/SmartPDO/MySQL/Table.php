<?php

/**
 * File: Table.php
 */
namespace SmartPDO\MySQL;

/**
 * MySQL Table handler
 *
 * @author Rick de Man <rick@rickdeman.nl>
 * @version 1
 *         
 */
class Table implements \SmartPDO\Interfaces\Table {
	
	/**
	 * Mysql class
	 *
	 * @var \SmartPDO\MySQL
	 */
	private $mysql;
	
	/**
	 * Holds the parameter set for building querys
	 *
	 * @var \SmartPDO\Parameters
	 */
	private $parameters;
	
	/**
	 * Requestes table name without prefix
	 *
	 * @var string
	 */
	private $tableName;
	
	/**
	 * Contructor for the MySQL Table handler
	 *
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @version 1
	 *         
	 * @param \SmartPDO\Interfaces\Database $db
	 *        	SmartPDO Database Object
	 * @param string $table
	 *        	Full table name
	 */
	function __Construct(\SmartPDO\Interfaces\Database $db, $table) {
		$this->parameters = new \SmartPDO\Parameters ( $db->getTables () );
		// Store SmartPDO ( is interface )
		$this->mysql = $db;
		// Store parameters
		$this->parameters->registerPrefix ( $db->getPrefix () );
		$this->parameters->registerTable ( $table );
		$this->parameters->registerCommand ( "SELECT" );
		// Store table name without prefix
		$this->tableName = substr ( $table, strlen ( $db->getPrefix () ) );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::columns()
	 *
	 * @param string $columns
	 *        	Columns to be shown, fully named when using JOIN(s)
	 *        	
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function columns(...$columns) {
		// Register all columns
		$this->parameters->registerColumns ( ...$columns );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::delete()
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function delete() {
		// Register as DELETE command
		$this->parameters->registerCommand ( "DELETE" );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::execute()
	 *
	 * @return \SmartPDO\MySQL\Table\Rows
	 */
	public function execute() {
		return new \SmartPDO\MySQL\Table\Rows ( $this->mysql, $this->parameters );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::or()
	 *
	 * @param bool $group
	 *        	True for creating a new group, otherwise left handed will be created
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function group($group = true) {
		// Register the OR for the WHERE statement
		$this->parameters->registerOr ( $group );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::whereIn()
	 *
	 * @param string $column
	 *        	Column name
	 * @param array $list
	 *        	(multiple) strings for WHERE IN
	 * @param bool $not
	 *        	Whether is must be in the list or not
	 * @param string $table
	 *        	Target table, NULL for master table
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function In($column, $list, $not = false, $table = null) {
		$tbl = $table != null ? $table : $this->tableName;
		$this->parameters->registerIn ( $column, $list, $not, $tbl );
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::innerJoin()
	 *
	 * @param string $targetTable
	 *        	Target table name
	 * @param string $targetColumn
	 *        	Target table column, null for master table ID
	 * @param string $sourceTable
	 *        	Source table, NULL for master table
	 * @param string $sourceColumn
	 *        	Source table column, null for ID
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function innerJoin($targetTable, $targetColumn = null, $sourceTable = null, $sourceColumn = null) {
		$targetColumn = $targetColumn != null ? $targetColumn : $this->tableName . "ID";
		$sourceTable = $sourceTable != null ? $sourceTable : $this->tableName;
		$sourceColumn = $sourceColumn != null ? $sourceColumn : "ID";
		// Insert new INNER JOIN dataset
		$this->parameters->registerJoin ( "INNER JOIN", $this->mysql->getTableName ( $sourceTable ), $sourceColumn, $this->mysql->getTableName ( $targetTable ), $targetColumn );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::insert()
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function insert() {
		// Register as INSERT command
		$this->parameters->registerCommand ( "INSERT" );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::leftJoin()
	 *
	 * @param string $targetTable
	 *        	Target table name
	 * @param string $targetColumn
	 *        	Target table column, null for master table ID
	 * @param string $sourceTable
	 *        	Source table, NULL for master table
	 * @param string $sourceColumn
	 *        	Source table column, null for ID
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function leftJoin($targetTable, $targetColumn = null, $sourceTable = null, $sourceColumn = null) {
		$targetColumn = $targetColumn != null ? $targetColumn : $this->tableName . "ID";
		$sourceTable = $sourceTable != null ? $sourceTable : $this->tableName;
		$sourceColumn = $sourceColumn != null ? $sourceColumn : "ID";
		// Insert new LEFT JOIN dataset
		$this->parameters->registerJoin ( "LEFT JOIN", $this->mysql->getTableName ( $sourceTable ), $sourceColumn, $this->mysql->getTableName ( $targetTable ), $targetColumn );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::like()
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
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 *
	 */
	public function like($column, $value, $not = false, $table = null, $escape = "!") {
		$table = $this->mysql->getTableName ( $table != null ? $table : $this->tableName );
		$this->parameters->registerLike ( $column, $value, $not, $table, $escape );
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::limit()
	 *
	 * @param integer $start
	 *        	The start index
	 * @param integer $items
	 *        	The maximum amount of rows to fetch
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function limit($start, $items) {
		// Register LIMIT parameters
		$this->parameters->registerLimit ( $start, $items );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::orderBy()
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
	public function orderBy($column, $asc = true, $table = null) {
		$table = $this->mysql->getTableName ( $table != null ? $table : $this->tableName );
		$this->parameters->registerOrderBy ( $column, $asc, $table );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::rightJoin()
	 *
	 * @param string $targetTable
	 *        	Target table name
	 * @param string $targetColumn
	 *        	Target table column, null for master table ID
	 * @param string $sourceTable
	 *        	Source table, NULL for master table
	 * @param string $sourceColumn
	 *        	Source table column, null for ID
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function rightJoin($targetTable, $targetColumn = null, $sourceTable = null, $sourceColumn = null) {
		$targetColumn = $targetColumn != null ? $targetColumn : $this->tableName . "ID";
		$sourceTable = $sourceTable != null ? $sourceTable : $this->tableName;
		$sourceColumn = $sourceColumn != null ? $sourceColumn : "ID";
		// Insert new RIGHT JOIN dataset
		$this->parameters->registerJoin ( "RIGHT JOIN", $this->mysql->getTableName ( $sourceTable ), $sourceColumn, $this->mysql->getTableName ( $targetTable ), $targetColumn );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::select()
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function select() {
		// Register as INSERT command
		$this->parameters->registerCommand ( "SELECT" );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::set()
	 *
	 * @param string $column
	 *        	table column
	 * @param string|integer $value
	 *        	Value to be updated
	 *        	
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function set($column, $value) {
		// Add update SET
		$this->parameters->registerSet ( $column, $value );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::update()
	 *
	 * @return \SmartPDO\MySQL\Table
	 */
	public function update() {
		// Register as UPDATE command
		$this->parameters->registerCommand ( "UPDATE" );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::value()
	 *
	 * @param string $column
	 *        	table column
	 * @param string|integer $value
	 *        	Value to be inserted
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function value($column, $value) {
		// Register new INSERT key value
		$this->parameters->registerInsert ( $column, $value );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::where()
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
	public function where($column, $value, $comparison = '=', $table = null) {
		$tableName = $this->mysql->getTableName ( $table != null ? $table : $this->tableName );
		// Register where dataset
		$this->parameters->registerWhere ( $tableName, $column, $comparison, $value );
		// Return current object
		return $this;
	}
}