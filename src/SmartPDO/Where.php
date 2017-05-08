<?php

/**
 * File: Where.php
 */
namespace SmartPDO;

class Where {

	/**
	 * Database PDO handler
	 *
	 * @var \SmartPDO\Interfaces\Database
	 */
	private $db;

	/**
	 * Master table
	 *
	 * @var string
	 */
	private $table;

	/**
	 * WHERE/OR/AND Collection
	 *
	 * @var array
	 */
	private $where = array ();

	/**
	 * FunctionDescription
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param \SmartPDO\Interfaces\Database $db
	 *        	SmartPDO Database Object
	 */
	public function __Construct(\SmartPDO\Interfaces\Database $db, $table) {
		$this->db = $db;
		$this->table = $table;
	}

	/**
	 * Get the tablename as string, Master, (prefix)table
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *        	Get the table name: Master/(prefix)table
	 * @throws \Exception
	 * @return string
	 */
	private function _getTableName($table = null) {
		if ($table == NULL) {
			return $this->table;
		} else if (in_array ( $this->db->getPrefix () . $table, array_keys ( $this->db->getTables () ) )) {
			return $this->db->getPrefix () . $table;
		} else {
			Throw new \Exception ( "Table '$table' does not exist, or is not available" );
		}
	}

	/**
	 * add (AND) BETWEEN
	 *
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @version 1
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
	 *
	 * @return \SmartPDO\Where
	 */
	public function between($column, $start, $stop, $not = false, $table = null) {
		// Get tablename
		$tbl = $this->_getTableName ( $table );
		// Register dataset WHERE BETWEEN
		$this->parameters->registerWhereBetween ( $column, $start, $stop, $not, $tbl, $this->ors === 0 );
		// Decrease OR counter if possible
		if ($this->ors > 0) {
			$this->ors --;
		}
		// Return current object
		return $this;
	}
}