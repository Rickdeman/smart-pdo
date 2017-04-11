<?php

/**
 * File: Rows.php
 */
namespace SmartPDO\MySQL\Table;

class Rows implements \SmartPDO\Interfaces\Rows {

	/**
	 * Is there more than one table used
	 *
	 * @var bool
	 */
	private $multipleTables = false;

	/**
	 * Mysql class
	 *
	 * @var \SmartPDO\MySQL
	 */
	private $mysql;

	/**
	 * Sql query paramaters
	 *
	 * @var \SmartPDO\Parameters
	 */
	private $parameters;

	/**
	 * Counter for query executions
	 *
	 * @var integer
	 */
	private static $queryCounter = 0;

	/**
	 * Rowcount from the database
	 *
	 * @var int
	 */
	private $rowCount;

	/**
	 * Rows from the database
	 *
	 * @var array
	 */
	private $rows;

	/**
	 * Pdo statement
	 *
	 * @var \PDOStatement
	 */
	private $sth;

	/**
	 * Prepared values for statement
	 *
	 * @var array
	 */
	private $values = array ();

	/**
	 * MySQL execution and Row Handling
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param \SmartPDO\Interfaces\Database $db
	 * @param \SmartPDO\Parameters $parameters
	 */
	public function __Construct(\SmartPDO\Interfaces\Database $db, \SmartPDO\Parameters $parameters) {
		// Store the parameters
		$this->parameters = $parameters;
		$this->mysql = $db;
		$this->multipleTables = count ( $this->parameters->getTables () ) > 1;
		// Query variable
		$query = "";

		// Query: set by command
		switch ($this->parameters->getCommand ()) {

			// Query: select
			case "SELECT" :
				break;

			default :
				throw new \Exception ( "Command not yet implemented!" );
				break;
		}

		$query = "{SELECT}{JOINS}{WHERE}{ORDERBY}{LIMIT}";

		$query = str_replace ( '{SELECT}', $this->createSelect (), $query );
		$query = str_replace ( '{JOINS}', $this->createJoins (), $query );
		$query = str_replace ( '{WHERE}', $this->createWhere (), $query );
		$query = str_replace ( '{ORDERBY}', $this->createOrderBy (), $query );
		$query = str_replace ( '{LIMIT}', $this->createLimit (), $query );
		$query = trim ( $query );

		if ($this->parameters->getCommand () == '!') {
			var_dump ( EOL . $query );
			die ();
		}
		if (self::$queryCounter > 0) {
			var_dump ( $query );
			die ();
		}
		// Prepate the pdo
		$this->sth = $this->mysql->pdo->prepare ( $query );
		// Execute with values
		try {
			$this->sth->execute ( $this->values );
		} catch ( \Exception $ex ) {
			echo $query . PHP_EOL;
			throw new \Exception ( $ex->getMessage () );
		}
		// Get and store the rowcount
		$this->rowCount = $this->sth->rowCount ();
		self::$queryCounter ++;
	}
	private function createJoins() {
		try {
			// Create the result variable
			$result = '';
			// Check for columns
			if ($this->parameters->getJoins () == null || count ( $this->parameters->getJoins () ) == 0) {
				// No inner joins defined
				return $result;
			}
			$joins = $this->parameters->getJoins ();
			// Loop throuhg all parameters
			foreach ( $joins as $join ) {
				// Add inner join `table` on `table`.`column` = `table2`.`column2`
				$result .= sprintf ( "%s `%s`%s", $join [0], $join [3], PHP_EOL );

				$result .= sprintf (
						"\tON `%s`.`%s` = `%s`.`%s`" . PHP_EOL,
						$join [3],
						$join [4],
						$join [1],
						$join [2] );
				/* */
			}
			// Place indentation
			$result = preg_replace ( "/^./m", "$0", trim ( $result ) );
			// Return result
			return $result;
		} catch ( \Exception $ex ) {
			print_r ( $ex );
			die ();
		}
	}

	/**
	 * Creates the limit statement
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	private function createLimit() {
		// Create the result variable
		$result = '';
		// Get parameter limit
		$limit = $this->parameters->getLimit ();
		// Check for columns
		if ($this->parameters->getLimit () == NULL) {
			return $result;
		}

		return sprintf ( "LIMIT %s,%s" . PHP_EOL, $limit [0], $limit [1] );
	}
	private function createOrderBy() {
		// Create the result variable
		$result = '';
		// Check for columns
		if ($this->parameters->getOrder () == null || count ( $this->parameters->getOrder () ) == 0) {
			// No ordering
			return $result;
		}
		// Start of command
		$result .= 'ORDER BY ';
		// Loop throuhg all parameters
		foreach ( $this->parameters->getOrder () as $k => $v ) {
			if ($this->multipleTables) {
				$result .= sprintf ( "`%s`.`%s` %s", $v [0], $v [1], ($v [2] === true ? "ASC" : "DESC") );
			} else {
				$result .= sprintf ( "`%s` %s", $v [1], ($v [2] === true ? "ASC" : "DESC") );
			}

			// Check for last index
			if ($k != @end ( array_keys ( @$this->parameters->getOrder () ) )) {
				// Add seperator
				$result .= ', ';
			}
		}
		// Return result
		return $result . PHP_EOL;
	}
	private function createSelect() {
		$columns = $this->parameters->getColumns ();
		$result = "SELECT";
		if ($this->multipleTables !== true) {
			if (count ( $columns ) == 1 && $columns [0] == "*") {
				return sprintf ( "SELECT *%sFROM `%s`" . PHP_EOL, PHP_EOL . "\t", $this->parameters->getTable () );
			} else {
				throw new \Exception ( "Not Implemented: Single Table specified columns" );
			}
		} else {
			if (count ( $columns ) == 1 && $columns [0] == "*") {
				$result .= PHP_EOL . "\t";
				$columns = array ();
				foreach ( $this->parameters->getTables () as $table ) {
					foreach ( $this->mysql->getTableColumns ( $table ) as $column ) {

						$columns [] = sprintf (
								"`%s`.`%s` as `%s`",
								$table,
								$column,
								$this->prependTableName ( $column, $table ) );

						// echo "$table.$column as " ;
						// echo $this->prependTableName($column, $table);
						// echo EOL;
					}
				}
				$result .= implode ( sprintf ( ", %s\t", PHP_EOL ), $columns ) . PHP_EOL;
				$result .= sprintf ( "FROM `%s`" . PHP_EOL, $this->parameters->getTable () );
				return $result;
			} else {
				throw new \Exception ( "Not Implemented: Multiple Table specified columns" );
			}
		}

		var_dump ( implode ( ', ', $this->parameters->getColumns () ) );
		die ();
	}
	private function createWhere() {

		// Create the result variable
		$result = sprintf ( "WHERE %s\t( ", PHP_EOL );
		// If is not array: where 1
		if ($this->parameters->getWhere () == null || count ( $this->parameters->getWhere () ) == 0) {
			// Load all results
			return "WHERE 1";
		}
		$Exception = false;
		$placedOr = false;
		// Loop throuhg all parameters\
		$parameters = $this->parameters->getWhere ();
		foreach ( $parameters as $i => $w ) {
			// Handle OR statements starting after first parameters
			if ($i > 0) {

				if ($w [0] != 'OR') {
					// First parameters is not an "OR"
					if ($placedOr != true) {
						// Add AND
						$result .= " AND ";
					} else {
						$placedOr = false;
					}
				} else {
					// OR detected, creating left-handed or group
					if ($w [1] == true) {
						// Create Group
						$result .= sprintf ( " ) OR%s\t( ", PHP_EOL );
					} else {
						// Create left-handed
						$result .= " OR ";
					}
					// An OR has been placed
					$placedOr = true;
				}
			}
			switch ($w [0]) {
				case "WHERE" :
					if ($w [4] == NULL) {
						if ($this->multipleTables == true) {
							$result .= sprintf ( "`%s`.`%s` IS %sNULL", $w [1], $w [2], $w [3] === true ? "" : "NOT " );
						} else {
							$result .= sprintf ( "`%s` IS %sNULL", $w [2], $w [3] === true ? "" : "NOT " );
						}
					} else {
						if ($this->multipleTables == true) {
							$result .= sprintf ( "`%s`.`%s` %s ?", $w [1], $w [2], $w [3] );
						} else {
							$result .= sprintf ( "`%s` %s ?", $w [2], $w [3] );
						}
						$this->values [] = $w [4];
					}
					break;

				case "WHEREIN" :
					if ($this->multipleTables == true) {
						$result .= sprintf (
								"`%s`.`%s` %sIN (%s)",
								$w [1],
								$w [2],
								$w [4] != true ? "" : "NOT ",
								implode ( ', ', array_fill ( 0, count ( $w [3] ), "?" ) ) );
						$this->values = array_merge ( $this->values, $w [3] );
					} else {
						$result .= sprintf (
								"`%s` %sIN (%s)",
								$w [2],
								$w [4] != true ? "" : "NOT ",
								implode ( ', ', array_fill ( 0, count ( $w [3] ), "?" ) ) );
						$this->values = array_merge ( $this->values, $w [3] );
					}
					break;

				default :
					throw new \Exception ( $w [0] . ' is not configured' );
					break;
			}
		}
		// Trim result
		$result .= " )";
		$result = trim ( $result );
		// Return result
		return $result . PHP_EOL;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Rows::getRows()
	 *
	 * @throws \Exception
	 * @return array
	 */
	public function getRows() {
		// Data can only be fetched once
		if ($this->rows != null) {
			return $this->rows;
		}
		// Query command must be SELECT
		if ($this->parameters->getCommand () != 'SELECT') {
			return null;
		}
		// Get and store the rows
		$this->rows = $this->sth->fetchAll ();

		if ($this->multipleTables) {
			$rows = array ();
			$tables = array ();
			foreach ( $this->rows as $key => $values ) {
				if (count ( $tables ) == 0) {
					foreach ( array_keys ( $values ) as $c ) {
						$tmp = explode ( '.', $c );
						if (! isset ( $tables [$tmp [0]] )) {
							$tables [$tmp [0]] = array ();
						}
					}
				}

				if (! isset ( $rows [$key] )) {
					$rows [$key] = $tables;
				}

				foreach ( $values as $column => $value ) {
					$tmp = explode ( '.', $column );
					$rows [$key] [$tmp [0]] [$tmp [1]] = $value;
					// var_dump($tmp);
				}
			}
			$this->rows = $rows;
		}
		return $this->rows;
	}
	public function getQuery() {
		return $this->sth->queryString;
	}
	private function prependTableName($column, $table) {
		if ($this->multipleTables) {
			$prepend = str_replace ( '_', '', substr ( $table, strlen ( $this->mysql->getPrefix () ) ) );
			return $prepend . '.' . ucfirst ( $column );
		} else {
			return $columnl;
		}
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Rows::rowCount()
	 *
	 * @throws \Exception
	 * @return number
	 */
	public function rowCount() {
		return $this->rowCount;
	}
}