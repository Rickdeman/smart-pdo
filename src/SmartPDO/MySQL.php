<?php

/**
 * File: MySQL.php
 */
namespace SmartPDO;

/**
 * Smart MySQL PDO handler
 *
 * @author Rick de Man <rick@rickdeman.nl>
 * @version 1
 *
 */
class MySQL implements \SmartPDO\Interfaces\Database {

	/**
	 * Name of the current database
	 *
	 * @var string
	 */
	private $databaseName;

	/**
	 * Pdo database handler
	 *
	 * @var \PDO
	 */
	public $pdo;

	/**
	 * Table prefix string
	 *
	 * @var string
	 */
	private $prefix = '';

	/**
	 * Mysql database table list
	 *
	 * @var array
	 */
	private $tables = array ();

	/**
	 * SmartPDO MySQL handler
	 *
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @version 1
	 *
	 * @param string $user
	 *        	Username for logging in to the database
	 * @param string $pass
	 *        	Password for current user
	 * @param string $database
	 *        	Database to use
	 * @param string $prefix
	 *        	Declare a prefix for all tables
	 * @param string $host
	 *        	Specify host if different
	 * @param string $char
	 *        	Specify a charset
	 */
	public function __Construct($user, $pass, $database, $prefix = "", $host = "127.0.0.1", $char = "utf8") {
		try {
			// The actual connection
			$this->pdo = new \PDO ( "mysql:host=$host;charset=$char", $user, $pass );
			// Pdo attributes setup
			$this->pdo->setAttribute ( \PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC );
			$this->pdo->setAttribute ( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			$this->pdo->Query ( 'USE ' . $database );
		} catch ( PDOException $e ) {
			// No connection could be made
			throw new \Exception ( "SmartPDO was unable to open a connection" );
		}
		try {
			// Show table prefix
			$_table = 'Tables_in_' . $database;
			// Show query
			$_query = "SELECT TABLE_NAME, COLUMN_NAME  from information_schema.columns where table_schema = '" . $database . "' LIMIT 0, 500";
			// Check for prefix in dsn connection

			// Save prefix
			$this->prefix = $prefix == "" ? "" : $prefix . "_";
			$this->databaseName = $database;
			// For each row in the datatable set
			foreach ( $this->pdo->Query ( $_query )->Fetchall () as $V ) {
				// Add row
				if ($this->prefix == "" || Functions::startsWith ( $this->prefix, $V ["TABLE_NAME"] )) {
					// Create table index if not exists
					if (! isset ( $this->tables [$V ["TABLE_NAME"]] )) {
						// Add table name with first column
						$this->tables [$V ["TABLE_NAME"]] = $V ["COLUMN_NAME"];
					} else {
						// add another column in CSV format
						$this->tables [$V ["TABLE_NAME"]] .= "," . $V ["COLUMN_NAME"];
					}
				}
			}
		} catch ( Exception $e ) {
			// No connection could be made
			throw new \Exception ( "SmartPDO was unable to correctly configure itself" );
		}
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @see \SmartPDO\Interfaces\Database::columnExists()
	 *
	 * @param string $column
	 *        	The Column to be 'found'
	 * @param string $table
	 *        	The table to be used
	 * @param bool $noException
	 *        	If the column or table is not found discard the exception
	 */
	public function columnExists($column, $table, $noException = false) {
		try {
			return (in_array ( $column, explode ( ",", $this->tables [$table] ) ));
		} catch ( Exception $e ) {
			if ($noException !== true) {
				throw new \Exception ( "Table and/or Column does not exist!" );
			}
		}
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Database::getDatabaseName()
	 *
	 * @return string
	 */
	public function getDatabase() {
		return $this->databaseName;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Database::getPrefix()
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getPrefix() {
		return $this->prefix;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Database::getTable()
	 *
	 * @param string $tableName
	 *        	Name of the table within the database
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function getTable($tableName) {
		// Check if table exist
		if (! in_array ( $tableName, array_keys ( $this->tables ) )) {
			// Check if prefix table exists
			if (in_array ( $this->prefix . $tableName, array_keys ( $this->tables ) )) {
				// Return prefix table
				return $this->getTable ( $this->prefix . $tableName );
			}
			// Table not found
			Throw new \Exception ( "Table '$tableName' does not exist" );
		}
		// Return mysql table
		return new \SmartPDO\MySQL\Table ( $this, $tableName );
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Database::getTableColumns()
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $tableName
	 *        	Table of which the columns should be returned
	 * @throws \Exception
	 * @return array Array holding all columns from specified table
	 *
	 */
	public function getTableColumns($tableName) {
		// Check if
		if (in_array ( $this->getTableName ( $tableName ), array_keys ( $this->tables ) )) {
			return explode ( ",", $this->tables [$tableName] );
		} else {
			throw new \Exception ( "provided table '$tableName' does not exists" );
		}
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Database::getTableName()
	 *
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @version 1
	 *
	 * @param string $tableName
	 *        	Table name without prefix
	 * @throws \Exception
	 * @return string
	 */
	public function getTableName($tableName) {
		// Check if table exist
		if (! in_array ( $tableName, array_keys ( $this->tables ) )) {
			// Check if prefix table exists
			if (in_array ( $this->prefix . $tableName, array_keys ( $this->tables ) )) {
				// Return prefix table
				return $this->getTableName ( $this->prefix . $tableName );
			}
			// Table not found
			Throw new \Exception ( "Table '$tableName' does not exist" );
		}
		// Return mysql table
		return $tableName;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Database::getTables()
	 *
	 * @return array[]
	 */
	public function getTables() {
		return $this->tables;
	}
}