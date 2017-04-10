<?php

/**
 * File: Database.php
 */
namespace SmartPDO\Interfaces;

/**
 * Interface for all SmartPDO handlers
 *
 * @author Rick de Man
 * @version 1
 *         
 */
interface Database {
	
	/**
	 * Standard interface for constructing a SmartPDO object
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
	 *        	Specifie a charset
	 */
	public function __Construct($user, $pass, $database, $prefix = "", $host = "127.0.0.1", $char = "utf8");
	
	/**
	 * Verify a column exists within a table
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $column
	 *        	The Column to be 'found'
	 * @param string $table
	 *        	The table to be used
	 * @param bool $noException
	 *        	If the column or table is not found discard the exception
	 * @return bool True if exists, otherwise false
	 */
	public function columnExists($column, $table, $noException = false);
	
	/**
	 * Get a mysql table
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $tableName
	 *        	Name of the table within the database
	 * @throws \Exception
	 * @return \SmartPDO\MySQL\Table
	 */
	public function getTable($tableName);
	
	/**
	 * Get all columns of from a table, prefix is not required
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $tableName
	 *        	Table of which the columns should be returned
	 */
	public function getTableColumns($tableName);
	
	/**
	 * Get a tablename with the prefix
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @param string $tableName
	 *        	Table name without prefix
	 * @throws \Exception
	 * @return string
	 */
	public function getTableName($tableName);
	
	/**
	 * Get all tables with columns
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return array
	 */
	public function getTables();
	
	/**
	 * Get the prefix string
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *        
	 * @return string
	 */
	public function getPrefix();
}