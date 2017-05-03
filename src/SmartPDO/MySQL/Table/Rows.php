<?php

/**
 * File: Rows.php
 */
namespace SmartPDO\MySQL\Table;

use SmartPDO\Config;
use SmartPDO\Parameters;

/**
 * MySQL Row collector
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class Rows implements \SmartPDO\Interfaces\Rows {

	/**
	 * Flag for available columns which are used
	 *
	 * @var array
	 */
	private $columns;

	/**
	 * flag for the inserted ID when available
	 *
	 * @var int|string
	 */
	private $insertedID;

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
	 * Rowcount from the query
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
	 * Rowcount from the database
	 *
	 * @var int
	 */
	private $tableRows = 0;

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
	 *
	 * @throws \Exception
	 */
	public function __Construct(\SmartPDO\Interfaces\Database $db, \SmartPDO\Parameters $parameters) {
		// Store the parameters
		$this->parameters = $parameters;
		$this->mysql = $db;
		// Check if multiple tables are used
		$this->multipleTables = count ( $this->parameters->getTables () ) > 1;
		// Query Format
		$query = "{SELECT}{INSERT}{UPDATE}{DELETE}{JOIN}{WHERE}{GROUPBY}{ORDERBY}{LIMIT}";
		// Build the real Query
		$query = str_replace ( '{SELECT}', $this->_createSelect (), $query );
		$query = str_replace ( '{INSERT}', $this->_createInsert (), $query );
		$query = str_replace ( '{UPDATE}', $this->_createUpdate (), $query );
		$query = str_replace ( '{DELETE}', $this->_createDelete (), $query );
		$query = str_replace ( '{JOIN}', $this->_createJoins (), $query );
		$query = str_replace ( '{WHERE}', $this->_createWhere (), $query );
		$query = str_replace ( '{GROUPBY}', $this->_createGroupBy (), $query );
		$query = str_replace ( '{ORDERBY}', $this->_createOrderBy (), $query );
		$query = str_replace ( '{LIMIT}', $this->_createLimit (), $query );
		// Trim the query
		$query = trim ( $query );
		// Query command check
		switch ($this->parameters->getCommand ()) {
			// Query: select
			case "SELECT" :
			case "INSERT" :
			case "UPDATE" :
			case "DELETE" :
				break;

			default :
				var_dump ( $query );
				throw new \Exception ( "Command '" . $this->parameters->getCommand () . "' not yet implemented!" );
				break;
		}
		// Prepate the pdo
		$this->sth = $this->mysql->pdo->prepare ( $query );
		// Execute with values
		try {
			// Check if the database is readonly and WRITE permissions are required
			if (Config::$readOnly == true && (Config::PDO_WRITE & Config::commandList [$this->parameters->getCommand ()]) != 0) {
				// Provide fake ID's
				$this->rowCount = 11;
				$this->insertedID = 11;
			} else {
				// Execute query with the pramters
				$this->sth->execute ( $this->values );
				// Check if current query is an INSERT
				if ($this->parameters->getCommand () == 'INSERT') {
					// Store the insertID
					$this->insertedID = $this->mysql->pdo->lastInsertId ();
				}
				// Get and store the rowcount
				$this->rowCount = $this->sth->rowCount ();
			}
		} catch ( \Exception $ex ) {
			// Something when wrong...
			echo $query . PHP_EOL;
			throw new \Exception ( $ex->getMessage () );
		}

		if (get_class ( $db ) == "SmartPDO\MySQL") {
			try {
				$query = "";
				$query .= 'SELECT `TABLE_ROWS`' . PHP_EOL;
				$query .= '	FROM `INFORMATION_SCHEMA`.`TABLES`' . PHP_EOL;
				$query .= '	WHERE `TABLE_SCHEMA` = ? AND TABLE_NAME = ?';

				$values = array (
						$this->mysql->getDatabase (),
						$this->parameters->getTable ()
				);
				$sth = $this->mysql->pdo->prepare ( $query );
				$sth->execute ( $values );

				$this->tableRows = intval ( $sth->fetch () ['TABLE_ROWS'] );
			} catch ( \Exception $ex ) {
				// Something when wrong...
				echo $query . PHP_EOL;
				throw new \Exception ( $ex->getMessage () );
			}
		}
		// Increase the counter, nice to have for testing after x commands
		self::$queryCounter ++;
	}

	/**
	 * Creates the DELETE part in the Query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	private function _createDelete() {
		// Check if DELETE can be used with the current command
		if ((Config::PDO_DELETE & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Return result
		return sprintf ( "DELETE FROM `%s`", $this->parameters->getTable () ) . PHP_EOL;
	}

	/**
	 * Creates the INSERT part in the Query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	private function _createInsert() {
		// Check if INSERT can be used with the current command
		if ((Config::PDO_INSERT & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Check if INSERTS is not null and has items
		if ($this->parameters->getInsert () == null || count ( $this->parameters->getInsert () ) == 0) {
			// Nothing to be inserted
			return "";
		}
		// Load all columns ( keys )
		$columns = array_keys ( $this->parameters->getInsert () );
		// Dynamicly add ? for prepared statement
		$values = array_fill ( 0, count ( $this->parameters->getInsert () ), "?" );
		// Add all values for the prepared statement
		$this->values = array_merge ( $this->values, array_values ( $this->parameters->getInsert () ) );
		// Return result
		return sprintf (
				"INSERT INTO `%s` (`%s`) VALUES (%s)",
				$this->parameters->getTable (),
				implode ( '`, `', $columns ),
				implode ( ", ", $values ) );
	}
	private function _createGroupBy() {
		// Check if ORDER BY can be used with the current command
		if ((Config::PDO_GROUPBY & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Load GROUP BY's
		$groups = $this->parameters->getGroup ();
		// Check if ORDER BY is not null and has items
		if ($groups == null || count ( $groups ) == 0) {
			// No ordering
			return "";
		}
		$list = array ();
		// Loop throuhg all parameters
		foreach ( $groups as $group ) {
			// Load parameters
			$table = $group->getTable ();
			$column = $group->getColumn ();
			// Check if the column exists at first
			if (! $this->parameters->columnExists ( $table, $column )) {
				// Error message
				$message = "Column `%s`.`%s` does not exist!";
				$message = sprintf ( $message, $table, $column );
				// Error throw
				throw new \Exception ( $message );
			}
			// Check if multiple tables are used
			if ($this->multipleTables) {
				// use `table`.`column` ASC|DESC
				// $list [] = sprintf ( "`%s`.`%s` %s", $v [0], $v [1], ($v [2] === true ? "ASC" : "DESC") );
			} else {
				// Check if column is specified in current columns
				if (! in_array ( $column, $this->columns )) {
					// Error message
					$message = "Column `%s`.`%s` is not available in this query!";
					$message = sprintf ( $message, $table, $column );
					// Error throw
					throw new \Exception ( $message );
				}
				// Add column to the list
				$list [] = $column;
			}
		}
		// Return result
		return sprintf ( "GROUP BY `%s", implode ( "`, `", $list ) ) . "`" . PHP_EOL;
	}

	/**
	 * Creates the JOIN part in the Query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	private function _createJoins() {
		// Check if JOIN can be used with the current command
		if ((Config::PDO_JOIN & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Check if JOINS is not null and has items
		if ($this->parameters->getJoins () == null || count ( $this->parameters->getJoins () ) == 0) {
			// No inner joins defined
			return "";
		}
		// Create the result variable
		$result = '';
		// Load all JOINS
		$joins = $this->parameters->getJoins ();
		// Loop throuhg all parameters
		foreach ( $joins as $join ) {
			// Add: [INNER LEFT RIGHT] JOIN `table`
			$result .= sprintf ( "%s `%s`%s", $join [0], $join [3], PHP_EOL );
			// Add: on `table`.`column` = `table2`.`column2`
			$result .= sprintf ( "\tON `%s`.`%s` = `%s`.`%s`" . PHP_EOL, $join [3], $join [4], $join [1], $join [2] );
		}
		// Place indentation and return result
		return preg_replace ( "/^./m", "$0", trim ( $result ) ) . PHP_EOL;
	}

	/**
	 * Creates the LIMIT part in the Query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	private function _createLimit() {
		// Check if LIMIT can be used with the current command
		if ((Config::PDO_LIMIT & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Get parameter limit
		$limit = $this->parameters->getLimit ();
		// Check if JOINS is not null and has exactly 2 items
		if ($limit == NULL || count ( $limit ) != 2) {
			return "";
		}
		// Return result
		return sprintf ( "LIMIT %s,%s" . PHP_EOL, $limit [0], $limit [1] );
	}

	/**
	 * Creates the ORDER BY part in the Query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	private function _createOrderBy() {
		// Check if ORDER BY can be used with the current command
		if ((Config::PDO_ORDERBY & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Load ORDERS
		$orders = $this->parameters->getOrder ();
		// Check if ORDER BY is not null and has items
		if ($orders == null || count ( $orders ) == 0) {
			// No ordering
			return "";
		}
		$list = array ();
		// Loop throuhg all parameters
		foreach ( $orders as $order ) {
			$table = $order->getTable ();
			$column = $order->getColumn ();
			$asc = $order->isAscending ();
			// Check if multiple tables are used
			if ($this->multipleTables) {
				// use `table`.`column` ASC|DESC
				$list [] = sprintf ( "`%s`.`%s` %s", $table, $column, ($asc ? "ASC" : "DESC") );
			} else {
				// use `column` ASC|DESC
				$list [] = sprintf ( "`%s` %s", $column, ($asc ? "ASC" : "DESC") );
			}
		}
		// Return result
		return sprintf ( "ORDER BY %s", implode ( ", ", $list ) ) . PHP_EOL;
	}

	/**
	 * Creates the SELECT part in the Query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @throws \Exception
	 * @return string
	 */
	private function _createSelect() {
		// Check if SELECT can be used with the current command
		if ((Config::PDO_SELECT & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Load all columns to be returned
		$columns = $this->parameters->getColumns ();
		// Load table name
		$rootTable = $this->parameters->getTable ();
		// Check if multiple tables are used
		if ($this->multipleTables !== true) {
			// Check if only 1 columns is defined and its '*'
			if (count ( $columns ) == 1 && $columns [0] == "*") {
				// Show ALL columns
				return sprintf ( "SELECT *%sFROM `%s`", PHP_EOL . "\t", $rootTable ) . PHP_EOL;
			} else {
				// loop through columns to be shown
				foreach ( $columns as $column ) {
					// Verify colum exists
					if (! $this->parameters->columnExists ( $rootTable, $column )) {
						// Column does not exist
						throw new \Exception ( sprintf ( "column `%s`.`%s` does not exist!", $rootTable, $column ) );
					}
				}
				$this->columns = $columns;
				// Return result
				return sprintf ( "SELECT `%s` %sFROM `%s`", implode ( '`, `', $columns ), PHP_EOL, $rootTable ) . PHP_EOL;
			}
		} else {
			// Multiple tables are used, fully named columns are now required
			$result = "SELECT" . PHP_EOL . "\t";
			// Create Column list for ALIAS defining
			$tableColumns = array ();
			// Check if only 1 columns is defined and its '*'
			if (count ( $columns ) == 1 && $columns [0] == "*") {
				// Show ALL columns, Loop through all tables
				foreach ( $this->parameters->getTables () as $table ) {
					// Loop through all columns
					foreach ( $this->mysql->getTableColumns ( $table ) as $column ) {
						// Add new column with alias
						$tableColumns [] = sprintf (
								"`%s`.`%s` as `%s`",
								$table,
								$column,
								$this->_prependTableName ( $column, $table ) );
						// Store used column(s)
						$this->columns [] = $table . \SmartPDO\Config::$multiTableSeparator . $column;
					}
				}
			} else {
				// Show specified columns, loop through all columns
				foreach ( $columns as $column ) {
					// to explode the column name
					$tmp = explode ( Config::$multiTableSeparator, $column );
					// Load table name, if specifyd else root table
					$tmpTable = isset ( $tmp [1] ) ? $this->mysql->getTableName ( $tmp [0] ) : $rootTable;
					// Load table column
					$tmpColumn = isset ( $tmp [1] ) ? $tmp [1] : $tmp [0];
					// Verify Source table exists
					if (! $this->parameters->tableExists ( $tmpTable )) {
						throw new \Exception ( sprintf ( "Table `%s` does not exist!", $tmpTable ) );
					}
					if (! in_array ( $tmpTable, $this->parameters->getTables () )) {
						throw new \Exception ( sprintf ( "Table `%s` is not available in this query!", $tmpTable ) );
					}
					// Verify Source columns exists
					if (! $this->parameters->columnExists ( $tmpTable, $tmpColumn )) {
						throw new \Exception ( sprintf ( "Column `%s`.`%s` does not exist!", $tmpTable, $tmpColumn ) );
					}
					// Add new column with alias
					$tableColumns [] = sprintf (
							"`%s`.`%s` as `%s`",
							$tmpTable,
							$tmpColumn,
							$this->_prependTableName ( $tmpColumn, $tmpTable ) );
					// Store used column(s)
					$this->columns [] = $tmpTable . \SmartPDO\Config::$multiTableSeparator . $column;
				}
			}
			// Add each table column in a seperate line
			$result .= implode ( sprintf ( ",%s\t", PHP_EOL ), $tableColumns ) . PHP_EOL;
			// Add FROM table
			$result .= sprintf ( "FROM `%s`" . PHP_EOL, $this->parameters->getTable () );
			// Return result
			return $result;
		}
	}

	/**
	 * Creates the UPDATE part in the Query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	private function _createUpdate() {
		// Check if UPDATE can be used with the current command
		if ((Config::PDO_UPDATE & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Check if SET's is not null and has items
		if ($this->parameters->getSet () == null || count ( $this->parameters->getSet () ) == 0) {
			// Nothing to be inserted
			return "";
		}
		// Load all columns ( keys )
		$columns = array_keys ( $this->parameters->getSet () );
		// Dynamicly add ? for prepared statement
		$values = array_fill ( 0, count ( $this->parameters->getSet () ), "?" );
		// Add all values for the prepared statement
		$this->values = array_merge ( $this->values, array_values ( $this->parameters->getSet () ) );
		// Return result
		return sprintf (
				"UPDATE `%s` SET" . PHP_EOL . "\t`%s` = ?",
				$this->parameters->getTable (),
				implode ( sprintf ( '` = ?,%s`', PHP_EOL . "\t" ), $columns ),
				implode ( ", ", $values ) ) . PHP_EOL;
	}

	/**
	 * Creates the WHERE part in the Query
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @throws \Exception
	 * @return string
	 */
	private function _createWhere() {
		// Check if WHERE can be used with the current command
		if ((Config::PDO_WHERE & Config::commandList [$this->parameters->getCommand ()]) == 0) {
			return "";
		}
		// Create the result variable
		$result = sprintf ( "WHERE %s\t( ", PHP_EOL );
		// Check if WHERE is not null and has items
		if ($this->parameters->getWhere () == null || count ( $this->parameters->getWhere () ) == 0) {
			// Load all results
			return "WHERE 1" . PHP_EOL;
		}
		// Flag for if an OR/ANDn group has been placed
		$placeLogic = true;
		$depth = 1;
		// Loop throuhg all WHERE parameters
		$parameters = $this->parameters->getWhere ();
		foreach ( $parameters as $i => $w ) {
			// Handle OR statements starting after first parameters
			if ($i > 0) {
				// Parameter must be an object!
				if (! is_object ( $w )) {
					throw new \Exception ( "'" . $w [0] . "' is not configured as Class" );
				}
				if ($placeLogic == true) {
					$skip = array ();
					$skip [] = strtolower ( "SmartPDO\Parameters\Group" );

					if (! in_array ( strtolower ( get_class ( $w ) ), $skip )) {
						$result .= sprintf ( " %s ", $w->isAnd () ? "AND" : "OR" );
					}
				} else {
					// Reset OR flag
					$placeLogic = true;
				}

				// if ($w [0] == 'GROUP') {
				// // Check if next element exists and is not an OR
				// if (isset ( $parameters [$i + 1] ) && $parameters [$i + 1] [0] != "OR") {
				// // OR detected, creating left-handed or group
				// $result .= sprintf ( " ) %s%s\t( ", $w [1] == true ? "OR" : "AND", PHP_EOL );
				// // An OR has been placed
				// $placedOr = true;
				// }
				// } else {
				// if ($placedOr != true) {
				// if ($w [0] == 'WHERE') {
				// $result .= sprintf ( " %s ", $w [5] === "AND" ? "AND" : "OR" );
				// } else {
				// // Add AND, since no OR was placed
				// $result .= " AND ";
				// }
				// } else {
				// // Reset OR flag
				// $placedOr = false;
				// }
				// }
			}
			if (is_object ( $w )) {
				if (! is_subclass_of ( $w, '\SmartPDO\Parameters\WhereLogic' )) {
					$message = "Object is given but not extended by '%s' ";
					$message = sprintf ( $message, '\SmartPDO\Parameters\WhereLogic' );
					throw new \Exception ( $message );
				}
				/**
				 *
				 * @var \SmartPDO\Parameters\WhereLogic $w
				 */
				switch (strtolower ( get_class ( $w ) )) {

					case "smartpdo\parameters\group" :
						$op = $w->isAnd () ? "AND" : "OR";
						$result .= sprintf ( " ) %s%s%s( ", $op, PHP_EOL, str_repeat ( "\t", $depth ) );
						$placeLogic = false;
						break;

					case "smartpdo\parameters\where" :
						$result .= $this->parseWhere ( $w );
						break;

					case "smartpdo\parameters\where\between" :
						$result .= $this->parseWhereBetween ( $w );
						break;

					case "smartpdo\parameters\where\in" :
						$result .= $this->parseWhereIn ( $w );
						break;

					default :
						throw new \Exception ( get_class ( $w ) . ' is not configured' );
						break;
				}
			} else {

				// Checking what to do: WHERE, WHEREIN, LIKE etc.
				switch ($w [0]) {
					case "IN" :
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

					case "LIKE" :
						if ($this->multipleTables == true) {
							$result .= sprintf ( "`%s`.`%s` %sLIKE ?", $w [1], $w [2], $w [4] == true ? 'NOT ' : '' );
						} else {
							$result .= sprintf ( "`%s` %sLIKE ?", $w [2], $w [4] == true ? 'NOT ' : '' );
						}
						$this->values [] = $w [3];

						if ($w [5] != "!") {
							$result .= " ESCAPE ?";
							$this->values [] = $w [5];
						}
						break;

					default :
						throw new \Exception ( $w [0] . ' is not configured' );
						break;
				}
			}
		}
		// Trim result

		$result .= " )";
		$result = trim ( $result );
		// Return result
		return $result . PHP_EOL;
	}

	/**
	 * Prepend table to column name if using multiple tables
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Table column name
	 * @param string $table
	 *        	table name
	 * @return string
	 */
	private function _prependTableName($column, $table) {
		if ($this->multipleTables) {
			// remove the prefix of the provided table
			$prepend = substr ( $table, strlen ( $this->mysql->getPrefix () ) );
			return $prepend . Config::$multiTableSeparator . $column;
		} else {
			return $columnl;
		}
	}

	/**
	 * Parse WHERE to valid syntax
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param \SmartPDO\Parameters\Where $where
	 *
	 * @return string
	 */
	private function parseWhere(\SmartPDO\Parameters\Where $where) {
		// Load parameters
		$table = $where->getTable ();
		$column = $where->getColumn ();
		$comparison = $where->getComparison ();
		$value = $where->getValue ();

		// Result variable
		$result = "";

		// Check if multiple tables are used due to JOINS
		if ($this->multipleTables == true) {
			// Add table name
			$result .= sprintf ( "`%s`.", $table );
		}

		// Check if value is NULL
		if ($value == NULL) {
			// IS NULL syntax
			$result .= sprintf ( "`%s` IS %sNULL", $column, $comparison === true ? "" : "NOT " );
		} else {
			// Comparison syntax
			$result .= sprintf ( "`%s` %s ?", $column, $comparison );
			// Add value
			$this->values [] = $where->getValue ();
		}
		// Return syntax
		return $result;
	}

	/**
	 * Parse WHERE IN to valid syntax
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param \SmartPDO\Parameters\Where\In $in
	 *
	 * @return string
	 */
	private function parseWhereIn(\SmartPDO\Parameters\Where\In $in) {
		// Load parameters
		$table = $in->getTable ();
		$column = $in->getColumn ();

		// Result variable
		$result = "";

		// Check if multiple tables are used due to JOINS
		if ($this->multipleTables == true) {
			// Add table name
			$result .= sprintf ( "`%s`.", $table );
		}

		// register values
		$this->values = array_merge ( $this->values, array_values ( $in->getValues () ) );
		// Create prepared ? values for query
		$fill = implode ( ", ", array_fill ( 0, count ( $in->getValues () ), "?" ) );
		// Finish syntax
		$result .= sprintf ( "`%s` %sIN (%s)", $column, $in->isNot () ? "NOT " : "", $fill );
		// Return syntax
		return $result;
	}

	/**
	 * Parse WHERE BETWEEN to valid syntax
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param \SmartPDO\Parameters\Between $between
	 *
	 * @return string
	 */
	private function parseWhereBetween(\SmartPDO\Parameters\Where\Between $between) {
		// Load parameters
		$table = $between->getTable ();
		$column = $between->getColumn ();
		$start = $between->getStart ();
		$stop = $between->getStop ();
		$not = $between->isNot ();

		// Result variable
		$result = "";

		// Check if start/stop is DateTime: Convert
		if (is_object ( $start ) && get_class ( $start ) == "DateTime") {
			$start = $start->format ( "Y-m-d H:i:s" );
			$stop = $stop->format ( "Y-m-d H:i:s" );
		}

		// Check if multiple tables are used due to JOINS
		if ($this->multipleTables == true) {
			// Add table name
			$result .= sprintf ( "`%s`.", $table );
		}

		// Add start/stop values
		$this->values [] = $start;
		$this->values [] = $stop;

		// Create BETWEEN syntax
		$result .= sprintf ( "`%s` %sBETWEEN ? AND ?", $column, $not ? 'NOT ' : '' );
		// Return syntax
		return $result;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Rows::getInsertedID()
	 *
	 * @return NULL|number|string
	 */
	public function getInsertedID() {
		return ($this->parameters->getCommand () != 'INSERT' ? null : $this->insertedID);
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Rows::getQuery()
	 *
	 * @return string
	 */
	public function getQuery() {
		// Query command must be SELECT
		return $this->sth->queryString;
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
		// Data can only be fetched once, return cached rows
		if ($this->rows != null) {
			return $this->rows;
		}
		// Query command must be SELECT
		if ($this->parameters->getCommand () != 'SELECT') {
			return null;
		}
		// Get and store the rows
		$this->rows = $this->sth->fetchAll ();
		// Check if multiple tables are used
		if ($this->multipleTables) {
			// Create temp rows and tables
			$rows = array ();
			$tables = array ();
			// Loop through all rows
			foreach ( $this->rows as $key => $values ) {
				// Check if tables are detected
				if (count ( $tables ) == 0) {
					// Loop through all keys ( columns )
					foreach ( array_keys ( $values ) as $c ) {
						// split the string with the table separotor in the Config
						$tmp = explode ( Config::$multiTableSeparator, $c );
						// Check if table is not already defined
						if (! isset ( $tables [$tmp [0]] )) {
							// Define table name
							$tables [$tmp [0]] = array ();
						}
					}
				}
				// Check if row keys ( copy of table ) does not exist
				if (! isset ( $rows [$key] )) {
					// Copy tables to the row ( only keys ) no filling
					$rows [$key] = $tables;
				}
				// Loop through all values
				foreach ( $values as $column => $value ) {
					// split the string with the table separotor in the Config
					$tmp = explode ( Config::$multiTableSeparator, $column );
					// Fill : [ROW] [Table] [COLUMN] = Value
					$rows [$key] [$tmp [0]] [$tmp [1]] = $value;
					// var_dump($tmp);
				}
			}
			// Overwrite rows
			$this->rows = $rows;
		}
		// Return all rows
		return $this->rows;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \SmartPDO\Interfaces\Rows::getTotalRows()
	 *
	 * @return int
	 */
	public function getTotalRows() {
		return $this->tableRows;
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