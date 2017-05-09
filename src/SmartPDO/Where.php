<?php

/**
 * File: Where.php
 */
namespace SmartPDO;

class Where {

	/**
	 * Flag for AND/OR, must be reset after each use!
	 *
	 * @var string
	 */
	protected $and = true;

	/**
	 * Database class
	 *
	 * @var \SmartPDO\Interfaces\Database
	 */
	protected $db;

	/**
	 * Holds the parameter set for building querys
	 *
	 * @var \SmartPDO\Parameters
	 */
	protected $parameters;

	/**
	 * Number of times a OR should be placed
	 *
	 * @var integer
	 */
	protected $ors = 0;

	/**
	 * Requestes table name without prefix
	 *
	 * @var string
	 */
	protected $tableName;

	/**
	 * WHERE Handler
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param \SmartPDO\Interfaces\Database $db
	 *        	SmartPDO Database Object
	 * @param string $table
	 *        	Full table name
	 */
	function __Construct(\SmartPDO\Interfaces\Database $db, $table) {
		$this->parameters = new \SmartPDO\Parameters ( $db->getTables () );

		// Store parameters
		$this->parameters->registerPrefix ( $db->getPrefix () );
		$this->parameters->registerTable ( $table );
		$this->parameters->registerCommand ( "SELECT" );

		// Store SmartPDO ( is interface )
		$this->db = $db;

		// Store table name without prefix
		$this->tableName = substr ( $table, strlen ( $db->getPrefix () ) );
	}

	/**
	 * add (AND) BETWEEN
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
	 * @return \SmartPDO\MySQL\Table
	 */
	public function between($column, $start, $stop, $not = false, $table = null) {
		// Get tablename
		$tbl = $this->db->getTableName ( $table != null ? $table : $this->tableName );
		// Register dataset WHERE BETWEEN
		$this->parameters->registerWhereBetween ( $column, $start, $stop, $not, $tbl, $this->ors == 0 );
		// Decrease OR counter if possible
		if ($this->ors > 0) {
			$this->ors --;
		}
		// Return current object
		return $this;
	}
}