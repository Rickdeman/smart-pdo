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
	 *  SmartPDO Database Object        	
	 * @param string $table
	 * Full table name   	
	 */
	function __Construct(\SmartPDO\Interfaces\Database $db, $table) {
		$this->parameters = new \SmartPDO\Parameters ( $db->getTables() );
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
	 * @see \SmartPDO\Interfaces\Table::addInnerJoin()
	 *
	 * @param string $targetTable
	 *        	Source table name
	 * @param string $targetColumn
	 *        	Source table column
	 * @param string $sourceTable
	 *        	Target table, NULL for master table
	 * @param string $sourceColumn
	 *        	Target table column
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addInnerJoin($targetTable, $targetColumn, $sourceTable = null, $sourceColumn = null) {
		// Use specified table or master table
		$sourceTable = $sourceTable != null ? $sourceTable : $this->tableName;
		$sourceColumn = $sourceColumn != null ? $sourceColumn : "ID";
		// Insert new INNER JOIN dataset
		$this->parameters->registerJoin ( 
				"INNER JOIN", 
				$this->mysql->getTableName ( $sourceTable ), 
				$sourceColumn, 
				$this->mysql->getTableName ( $targetTable ), 
				$targetColumn );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::addInsert()
	 *
	 * @param string $column
	 *        	Column name to be used
	 * @param string|integer $value
	 *        	Value to be inserted in the column
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addInsert($column, $value) {
		// TODO: Implement addInsert
		throw new \Exception ( "Not implemented" );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::addLeftJoin()
	 *
	 * @param string $targetTable
	 *        	Source table name
	 * @param string $targetColumn
	 *        	Source table column
	 * @param string $sourceTable
	 *        	Target table, NULL for master table
	 * @param string $sourceColumn
	 *        	Target table column
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addLeftJoin($targetTable, $targetColumn, $sourceTable, $sourceColumn) {
		// Use specified table or master table
		$sourceTable = $sourceTable != null ? $sourceTable : $this->tableName;
		$sourceColumn = $sourceColumn != null ? $sourceColumn : "ID";
		// Insert new LEFT JOIN dataset
		$this->parameters->registerJoin ( 
				"LEFT JOIN", 
				$this->mysql->getTableName ( $sourceTable ), 
				$sourceColumn, 
				$this->mysql->getTableName ( $targetTable ), 
				$targetColumn );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::addOr()
	 *
	 * @param bool $group
	 *        	True for creating a new group, otherwise left handed will be created
	 *        	
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addOr($group = true) {
		// Register the OR for the WHERE statement
		$this->parameters->registerOr ( $group );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::addOrderBy()
	 *
	 * @param string $column
	 *        	Column to be sorted by
	 * @param bool $asc
	 *        	True for ascending, false for descending
	 * @param string $table
	 *        	Target table, NULL for master table
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addOrderBy($column, $asc = true, $table = null){
		$table= $this->mysql->getTableName ( $table != null ? $table : $this->tableName );
		$this->parameters->registerOrderBy($column, $asc, $table);
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::addRightJoin()
	 *
	 * @param string $targetTable
	 *        	Source table name
	 * @param string $targetColumn
	 *        	Source table columns
	 * @param string $sourceTable
	 *        	Target table, NULL for master table
	 * @param string $sourceColumn
	 *        	Target table column
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addRightJoin($targetTable, $targetColumn, $sourceTable, $sourceColumn) {
		// Use specified table or master table
		$sourceTable = $sourceTable != null ? $sourceTable : $this->tableName;
		$sourceColumn = $sourceColumn != null ? $sourceColumn : "ID";
		// Insert new RIGHT JOIN dataset
		$this->parameters->registerJoin ( 
				"RIGHT JOIN", 
				$this->mysql->getTableName ( $sourceTable ), 
				$sourceColumn, 
				$this->mysql->getTableName ( $targetTable ), 
				$targetColumn );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::addSet()
	 *
	 * @param string $column
	 *        	Column name to be updated
	 * @param string|integer $value
	 *        	Value to be inserted
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addSet($column, $value) {
		// TODO: Implement addSet
		throw new \Exception ( "Not implemented" );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::addWhere()
	 *
	 * @param string $column
	 *        	Columns name
	 * @param mixed $value
	 *        	Value to match, use NULL for 'IS NULL' 
	 * @param string $comparison
	 *        	Comparision action, when value is NULL, use = or !=
	 * @param string $table
	 *        	Specified table, NULL for master table
	 * @return \SmartPDO\MySQL\Table
	 */
	public function addWhere($column, $value, $comparison = '=', $table = null) {
		$tableName = $this->mysql->getTableName ( $table != null ? $table : $this->tableName );
		// Register where dataset
		$this->parameters->registerWhere ( $tableName, $column, $comparison, $value );
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
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table\Rows
	 */
	public function execute() {
		return new \SmartPDO\MySQL\Table\Rows($this->mysql, $this->parameters);
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
	 * @see \SmartPDO\Interfaces\Table::setColumns()
	 *
	 * @param unknown $columns        	
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function setColumns($columns) {
		// TODO: Implement setColumns
		throw new \Exception ( "Not implemented" );
		// Return current object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Table::setLimit()
	 *
	 * @param integer $start
	 *        	The start index
	 * @param integer $items
	 *        	The maximum amount of rows to fetch
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function setLimit($start, $items) {
		// Register LIMIT parameters
		$this->parameters->registerLimit($start, $items);
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
}