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
	 * @param \SmartPDO\Interfaces\Database $mysql
	 * @param unknown $table
	 */
	function __Construct(\SmartPDO\Interfaces\Database $mysql, $table){
		$this->parameters = new \SmartPDO\Parameters(); 
		// Store SmartPDO ( is interface )
		$this->mysql = $mysql;
		// Store parameters
		$this->parameters->registerPrefix ( $mysql->getPrefix () );
		$this->parameters->registerTable ( $table );
		$this->parameters->registerCommand("SELECT");
		// Store table name without prefix
		$this->tableName = substr ( $table, strlen ( $mysql->getPrefix () ) );
	}
	
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Wms\Pdo\interfaces\table::addOr()
	 *
	 * @param bool $group
	 *        	True for creating a new group, otherwise left handed will be created
	 *
	 * @return \Wms\Pdo\Mysql\Table
	 */
	public function addOr($group = true){
		// Register the OR for the WHERE statement
		$this->parameters->registerOr($group);
		// Return this object
		return $this;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \Wms\Pdo\interfaces\table::addWhere()
	 *
	 * @param string $column
	 *        	Columns name
	 * @param mixed $value
	 *        	Value to match
	 * @param string $comparison
	 *        	Comparision action '= | >= | <=' etc
	 * @param string $table
	 *        	Main table other table specified withing joins
	 * @return \Wms\Pdo\Mysql\Table
	 */
	public function addWhere($column, $value, $comparison = '=', $table = null) {
		$tableName = $this->mysql->getTableName ( $table != null ? $table : $this->tableName );
		// Register where dataset
		$this->parameters->registerWhere ( $tableName, $column, $comparison, $value );
		// Return this object
		return $this;
	}

}