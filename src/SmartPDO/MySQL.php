<?php

/**
 * File: MySQL.php
 */
namespace SmartPDO;

/**
 * Smart MySQL PDO handler
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class MySQL implements \SmartPDO\Interfaces\Database
{
	
	/**
	 * Name of the current database
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var string
	 */
	private $databaseName;
	

	/**
	 * Cache list for columns exist or not
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var array
	 */
	private $existingColumns = array();
	
	/**
	 * Cache list for tables exist or not
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var array
	 */
	private $existingTables = array();

	/**
	 * Pdo database handler
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var \PDO
	 */
	public $pdo;

	/**
	 * Table prefix string
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var string
	 */
	private $prefix = '';

	/**
	 * Mysql database table list
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var \SmartPDO\MySQL\TableColumns[]
	 */
	private $tableColumns = array();
	
	/**
	 * Get the tableNames
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var string[]
	 */
	private $tableNames;

	/**
	 * SmartPDO MySQL handler
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $user
	 *			Username for logging in to the database
	 * @param string $pass
	 *			Password for current user
	 * @param string $database
	 *			Database to use
	 * @param string $prefix
	 *			Declare a prefix for all tables
	 * @param string $host
	 *			Specify host if different
	 * @param string $char
	 *			Specify a charset
	 */
	public function __construct(string $user, string $pass, string $database, string $prefix = "", string $host = "127.0.0.1", string $char = "utf8")
	{
		try {
			// The actual connection
			$this->pdo = new \PDO("mysql:host=$host;charset=$char", $user, $pass);
			// Pdo attributes setup
			$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->pdo->Query('USE ' . $database);
		} catch (\PDOException $e) {
			// No connection could be made
			throw new \Exception("SmartPDO was unable to open a connection");
		}
		try {
			// Save prefix
			$this->prefix = $prefix == "" ? "" : $prefix . "_";
			// Save the database name			
			$this->databaseName = $database;
			// Creat the Query for loading all columns
			$_query = "SELECT * from information_schema.columns where table_schema = '" . $database . "'";
			/**
			 * @var \SmartPDO\MySQL\TableColumns $tmpTableInfo
			 */
			// Create temporary variable
			$tmpTableInfo = null;
			// Loop through all rows
			foreach ($this->pdo->Query($_query)->Fetchall() as $V) {
				// Get the tableName
				$tableName = $V["TABLE_NAME"];
				// Check if the table is allowed with/without prefix
				if ($this->prefix == "" || Functions::startsWith($this->prefix, $tableName)) {
					// Check if the temp TableInfo must be created/refreshed
					if( $tmpTableInfo == null || $tmpTableInfo->getTableName() != $tableName){
						// Check if the table is not NULL
						if($tmpTableInfo != null){
							// Register the table
							$this->tableColumns[] = $tmpTableInfo;
						}
						// Create new temp TableInfo
						$tmpTableInfo = new \SmartPDO\MySQL\TableColumns($tableName);
					}
					// Add the column
				  	$tmpTableInfo->addColumn(new MySQL\TableColumn($V));
				}
			}
			// Add the last temp. TableInfo
			$this->tableColumns[] = $tmpTableInfo;
			// Load all Tablenames
			$this->getTableNames();
		} catch (\Exception $e) {
			// No connection could be made
			throw new \Exception("SmartPDO was unable to correctly configure itself");
		}
	}	
	
	/**
	 * Generes object to be shown in print_r/var_dump
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return array
	 */
	public function __debugInfo() {
		$result = get_object_vars($this);
		foreach(array('tableColumns','existingColumns','pdo') as $key){
			unset($result[$key]);			
		}
		return $result;
	}

	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::columnExists()
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return bool
	 */
	public function columnExists(string $tableName, string $column, bool $noException = false)
	{
		try {
			// Get the actual table name
			$tableName = $this->getTableName($tableName);		
			// Get full name
			$name = sprintf("%s.%s", $tableName, $column);
			// Check if result has be determined
			if(isset($this->existingColumns[$name])){
				// Return result from cache
				return $this->existingColumns[$name] === true;
			}
			// Check if the table exists
			if(!in_array($tableName, $this->getTableNames())){
				// Table does not exists, so does the column
				return false;
			}
			// Check if the column exists in the Table Columns
			$result = in_array($column, $this->getTableInfo($tableName)->getColumnNames());
			// Save to cache
			$this->existingColumns[$name] = $result === true;
			return $result;
		} catch (\Exception $e) {
			if ($noException !== true) {
				throw new \Exception("Table and/or Column does not exist!");
			}
		}
		// Default result
		return false;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getColumnSeperator()
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getColumnSeperator()
	{
		// Returns the column seperator
		return $this->columnSeperator;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getDatabaseName()
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return string
	 */
	public function getDatabaseName()
	{
		// Returns the database name
		return $this->databaseName;
	}

	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getPrefix()
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return string
	 */
	public function getPrefix()
	{
		// Returns the table prefix
		return $this->prefix;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getTable()
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return \SmartPDO\MySQL\Table
	 */
	public function getTable(string $tableName) 
	{
		// Check if table exist
		if (! in_array($tableName, array_keys($this->tableColumns))) {
			// Check if prefix table exists
			if (in_array($this->prefix . $tableName, array_keys($this->tableColumns))) {
				// Return prefix table
				return $this->getTable($this->prefix . $tableName);
			}
			// Table not found
			Throw new \Exception("Table '$tableName' does not exist");
		}
		// Return mysql table
		return new \SmartPDO\MySQL\Table($this, $tableName);
	}

	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getTableColumnNames()
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return string[]
	 */
	public function getTableColumnNames(string $tableName)
	{
		// Load the TableInfo
		$tableInfo = $this->GetTableInfo($tableName);
		// Verify table has been found
		if($tableInfo == null)
			// Table does not exist
			throw new \Exception("provided table '$tableName' does not exists");
		// Return all tablecolumns
		return $tableInfo->getColumnNames();
	}

	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getTableInfo()
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return \SmartPDO\MySQL\TableColumns
	 */
	public function getTableInfo(string $tableName)
	{
		// Get the actual table name
		$tableName = $this->getTableName($tableName);		
		// Check if table exist
		if (in_array($tableName, $this->getTableNames())) {
			// Map the name to the correct index
			$index = array_search ( $tableName, $this->getTableNames());
			// Return the index table
			return $this->tableColumns[$index];
		}
		// Nothing has been found
		return null;
	}

	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getTableInfos()
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return \SmartPDO\MySQL\TableColumns[]
	 */
	public function getTableInfos()
	{
		return $this->tableColumns;
	}

	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getTableName()
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return string
	 */
	public function getTableName(string $tableName)
	{
		// Get all tableNames
		$tableNames = $this->getTableNames();
		// Check if table exist
		if (! in_array($tableName, $tableNames)) {
			// Check if prefix table exists
			if (in_array($this->prefix . $tableName, $tableNames)) {
				// Return prefix table
				return $this->getTableName($this->prefix . $tableName);
			}
			// Table not found
			Throw new \Exception("Table '$tableName' does not exist");
		}
		// Return (actual) the table name
		return $tableName;
	}  

	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::getTableNames()
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return string[]
	 */
	public function getTableNames(){
		// Check if all table names have been loaded
		if($this->tableNames!=null)
			// return cache tableNames
			return $this->tableNames;
		// Map the array to the table names
		$this->tableNames = array_map(
			function(\SmartPDO\MySQL\TableColumns $table){
				// Only return the table name
				return $table->getTableName();
			},
   			$this->tableColumns
		);
		// Return result
		return $this->tableNames;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\Database::tableExists()
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return bool
	 */
	public function tableExists(string $tableName){
		// Get the actual table name
		$tableName = $this->getTableName($tableName);	
		// Check if result has be determined
		if(isset($this->existingTables[$tableName])){
			// Return result from cache
			return $this->existingTables[$tableName] === true;
		}
		$result = true;
		// Check if the table exists
		if(!in_array($tableName, $this->getTableNames())){
			// Table does not exists, so does the column
			$result = false;
		}
		// Set a memory flag for enhancements
		$this->existingTables[$tableName] = $result === true;
		// Return the result
		return $result;
	}
}