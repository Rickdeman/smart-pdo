<?php

/**
 * File: Parameters.php
 */
namespace SmartPDO;

define ( 'SMART_PDO_COLUMNS', 0b00000001 );
define ( 'SMART_PDO_INNERJOIN', 0b00000010 );
define ( 'SMART_PDO_INSERT', 0b00000100 );
define ( 'SMART_PDO_LIMIT', 0b00001000 );
define ( 'SMART_PDO_ORDERBY', 0b00010000 );
define ( 'SMART_PDO_SET', 0b00100000 );
define ( 'SMART_PDO_WHERE', 0b01000000 );

/**
 * Smart PDO Table parameters handler
 *
 * @author Rick de Man <rick@rickdeman.nl>
 * @version 1
 *         
 */
class Parameters {
	
	/**
	 * Placeholder for the columns to be selected, default = array( '*' )
	 *
	 * @var array
	 */
	private $columns = array (
			'*' 
	);
	
	/**
	 * Placeholder for the main query statement: SELECT DELETE etc
	 *
	 * @var string
	 */
	private $command = 'SELECT';
	
	/**
	 * Available query statements
	 *
	 * @var array
	 */
	const commandList = array (
			'SELECT' => SMART_PDO_COLUMNS | SMART_PDO_INNERJOIN | SMART_PDO_LIMIT | SMART_PDO_ORDERBY | SMART_PDO_WHERE,
			'UPDATE' => SMART_PDO_SET | SMART_PDO_WHERE,
			'INSERT' => SMART_PDO_INSERT,
			'DELETE' => SMART_PDO_WHERE 
	);
	
	/**
	 * Available compare methods
	 *
	 * @var array
	 */
	const compareList = array (
			"=",
			"<=>",
			"<>",
			"!=",
			">",
			">=",
			"<",
			"<=" 
	);
	
	/**
	 * Placeholder for the table prefix
	 *
	 * @var string
	 */
	private $prefix = "";
	
	/**
	 * Placeholder for the current table
	 *
	 * @var string
	 */
	private $table = "";
	
	/**
	 * Placeholder for all selected table
	 *
	 * @var array
	 */
	private $tables = array ();
	
	/**
	 * Get the current query command
	 *
	 * @see Parameters::commandList
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return string
	 */
	public function getCommand() {
		return $this->command;
	}
	
	/**
	 * Get the table prefix
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return array
	 */
	public function getPrefix() {
		return $this->prefix;
	}
	
	/**
	 * Get the main table
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
	 * Return all tables which will be used
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getTables() {
		return $this->tables;
	}
	
	/**
	 * Register the sql command
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @see Parameters::commandList
	 *
	 * @param string $command
	 *        	The SQL command type
	 *        	
	 * @throws \Exception
	 */
	public function registerCommand($command) {
		// Validate argument types
		if (! is_string ( $command )) {
			throw new \Exception ( "Expected string, '" . gettype ( $command ) . "' provided" );
		}
		// Check if command is available
		if (! in_array ( strtoupper ( $command ), array_keys ( self::commandList ) )) {
			throw new \Exception ( "Command is '" . strtoupper ( $command ) . "' invalid" );
		}
		// Register Command
		$this->command = strtoupper ( $command );
	}
	
	/**
	 * Register an OR within the WHERE statement
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param boolean $group        	
	 * @throws \Wms\Exception
	 */
	public function registerOr($group) {
		if (! is_bool ( $group )) {
			throw new \Exception ( "Expected bool, '" . gettype ( $prefix ) . "' provided" );
		}
		// Register Where command
		$this->where [] = array (
				'OR',
				$group 
		);
	}
	
	/**
	 * Register the database used prefix
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $prefix
	 *        	Provide the prefix for the table
	 * @throws \Exception
	 */
	public function registerPrefix($prefix) {
		// Validate argument types
		if (! is_string ( $prefix )) {
			throw new \Exception ( "Expected string, '" . gettype ( $prefix ) . "' provided" );
		}
		// Register the prefix
		$this->prefix = $prefix;
	}
	
	/**
	 * Register the table name
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $table
	 *        	Fully qualified table
	 * @throws \Exception
	 */
	public function registerTable($table) {
		// Validate argument types
		if (! is_string ( $table )) {
			throw new \Exception ( "Expected string, '" . gettype ( $table ) . "' provided" );
		}
		// Register table name
		$this->table = $table;
		$this->tables [] = $table;
	}
	
	/**
	 * Register an WHERE set
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @see compareList
	 * @param string $table
	 *        	Table name which the columns belongs to
	 * @param string $column
	 *        	Fully qualified source table column
	 * @param string $comparison
	 *        	Comparision action see compareList for more info
	 * @param string $value
	 *        	Value to match
	 *        	
	 * @throws \Exception
	 */
	public function registerWhere($table, $column, $comparison, $value) {
		// Check if function is allowed within current command
		if ((SMART_PDO_WHERE & self::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register WHERE with current command: " . $this->command );
		}
		// Validate argument types
		if (! is_string ( $column )) {
			throw new \Exception ( "Expected string, '" . gettype ( $column ) . "' provided" );
		}
		// Validate comparison symbol
		if (! in_array ( $comparison, self::compareList )) {
			throw new \Exception ( "provided invalid compare: '" . $comparison . "'. see compareList for more info" );
		}
		// Register Where command
		$this->where [] = array (
				'WHERE',
				$table,
				$column,
				$comparison,
				$value 
		);
	}
}