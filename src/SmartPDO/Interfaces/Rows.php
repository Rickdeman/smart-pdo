<?php

/**
 * File: Rows.php
 */
namespace SmartPDO\Interfaces;

/**
 * Pdo rows interface
 * 
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 */
interface Rows {

	/**
	 * Mysql table row handler
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @param \SmartPDO\Interfaces\Database $db
	 *        	Mysql handler
	 * @param \SmartPDO\Parameters $parameters
	 *        	Sql query parameters
	 */
	function __Construct(\SmartPDO\Interfaces\Database $db, \SmartPDO\Parameters $parameters);

	/**
	 * Get the ID of the last inserted row
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @return null|int|string
	 */
	function getInsertedID();

	/**
	 * Get the used QUERY
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @return string
	 */
	function getQuery();

	/**
	 * Get the rows
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @return array
	 */
	function getRows();

	/**
	 * Get the row count of the table column
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @return int
	 */
	function getTotalRows();

	/**
	 * Get the amount of rows
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @return number
	 */
	function rowCount();
}