<?php

/**
 * File: Parameters.php
 */
namespace SmartPDO;

define ( 'SMART_PDO_COLUMNS', 0b00000001 );
define ( 'SMART_PDO_JOIN', 0b00000010 );
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
	 * Storage for all MySQL tables with columns
	 *
	 * @var array
	 */
	private $mysqlTables = null;

	/**
	 * Available query statements
	 *
	 * @var array
	 */
	const commandList = array (
			'SELECT' => SMART_PDO_COLUMNS | SMART_PDO_JOIN | SMART_PDO_LIMIT | SMART_PDO_ORDERBY | SMART_PDO_WHERE,
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
	 * Available JOIN types
	 *
	 * @var array
	 */
	const JoinList = array (
			"INNER JOIN",
			"LEFT JOIN",
			"RIGHT JOIN"
	);

	/**
	 * Placeholder for the LIMIT
	 *
	 * @var array
	 */
	private $limit = null;

	/**
	 * Placeholder for each ORDER
	 *
	 * @var array
	 */
	private $order = null;

	/**
	 * Placeholder for the table prefix
	 *
	 * @var string
	 */
	private $prefix = "";

	/**
	 * Placeholder for each JOIN
	 *
	 * @var array
	 */
	private $joins = null;

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
	 * Placeholder for all WHERE datasets
	 *
	 * @var array
	 */
	private $where = null;

	/**
	 * Initialise the Parameter set with the mysql
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param array $tables
	 */
	function __Construct(array $tables) {
		$this->mysqlTables = $tables;
	}

	/**
	 * Verify that a Table Column exists
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *        	Tablename
	 * @param string $column
	 *        	Column name
	 * @return boolean
	 */
	private function _ColumnExists($table, $column) {
		try {
			return (in_array ( $column, explode ( ',', $this->mysqlTables [$table] ) ));
		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * Verify that a Table exists
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *        	Tablename * @param unknown $table
	 * @return boolean
	 */
	private function _tableExists($table) {
		return in_array ( $table, array_keys ( $this->mysqlTables ) );
	}

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
	 * Get the requested columns to be shown
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return array
	 */
	public function getColumns() {
		return $this->columns;
	}

	/**
	 * Get the JOIN collection
	 *
	 * arrays markup: [ sourceTable, sourceColumn, targetTable, targetColumn ]
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return array
	 */
	public function getJoins() {
		return $this->joins;
	}

	/**
	 * Get the LIMIT
	 *
	 * array markup: [ start, count ]
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return array
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Get the ORDER collection
	 *
	 * array markup: Column => ASC|DESC
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return array
	 */
	public function getOrder() {
		return $this->order;
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
	 * Get the WHERE collection
	 *
	 * arrays markup: [ column, comparison, value, operator ]
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return array
	 */
	public function getWhere() {
		return $this->where;
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
	 * Register an JOIN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @see Parameters::JoinList
	 * @param string $type
	 *        	Type of join to be used
	 * @param string $sourceTable
	 *        	Fully qualified source table name including prefix
	 * @param string $sourceColumn
	 *        	Fully qualified source table column
	 * @param string $targetTable
	 *        	Fully qualified target table name including prefix
	 * @param string $targetColumn
	 *        	Fully qualified target table column
	 * @throws \Exception
	 */
	public function registerJoin($type, $sourceTable, $sourceColumn, $targetTable, $targetColumn) {
		// Check if function is allowed within current command
		if ((SMART_PDO_JOIN & self::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register a JOIN with current command: " . $this->command );
		}
		// Validate comparison symbol
		if (! in_array ( $type, self::JoinList )) {
			throw new \Exception ( "JOIN types: '" . $comparison . "' is not allowed. see joinList for more info" );
		}
		// Verify Source table is string
		if (! is_string ( $sourceTable )) {
			throw new \Exception ( "Expected 'sourceTable' to be string, '" . gettype ( $sourceTable ) . "' provided" );
		}
		// Verify Target table is string
		if (! is_string ( $targetTable )) {
			throw new \Exception ( "Expected 'targetTable' to be string, '" . gettype ( $targetTable ) . "' provided" );
		}

		// TODO: Check $sourceColumn & $targetColumn exists within its table
		if ($this->joins == NULL) {
			$this->joins = array ();
		}
		// Register INNER JOIN
		$this->joins [] = array (
				"INNER JOIN",
				$sourceTable,
				$sourceColumn,
				$targetTable,
				$targetColumn
		);
		$this->tables [] = $targetTable;
	}

	/**
	 * Register the LIMIT
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param int $start
	 *        	Start row
	 * @param int $items
	 *        	Number of rows the fetch
	 * @throws \Wms\Exception
	 */
	public function registerLimit($start, $items) {
		// Check if function is allowed within current command
		if ((SMART_PDO_LIMIT & self::commandList [$this->command]) == 0) {
			throw new \Wms\Exception ( "Cannot register LIMIT with current command: " . $this->command );
		}
		// Validate argument types
		if (! is_int ( $start )) {
			throw new \Wms\Exception ( "Expected integer, '" . gettype ( $start ) . "' provided" );
		}
		if (! is_int ( $items )) {
			throw new \Wms\Exception ( "Expected integer, '" . gettype ( $items ) . "' provided" );
		}
		// Set LIMIT values
		$this->limit = array (
				$start,
				$items
		);
	}

	/**
	 * Register an OR within the WHERE statement
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param boolean $group
	 * @throws \Exception
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
	 * Register an ORDER BY
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Fully qualified table column
	 * @param bool $asc
	 *        	True for ASC otherwise DESC
	 * @param bool $table
	 *        	Target table, NULL for master table
	 * @throws \Wms\Exception
	 */
	public function registerOrderBy($column, $asc, $table) {

		// Check if function is allowed within current command
		if ((SMART_PDO_ORDERBY & self::commandList [$this->command]) == 0) {
			throw new \Wms\Exception ( "Cannot register ORDER BY with current command: " . $this->command );
		}
		//
		if (! is_string ( $column )) {
			throw new \Exception ( "Expected bool, '" . gettype ( $column ) . "' provided" );
		}
		if (! is_bool ( $asc )) {
			throw new \Exception ( "Expected bool, '" . gettype ( $asc ) . "' provided" );
		}

		$this->order [] = array (
				$table,
				$column,
				$asc
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
		// Verify table exists
		if (! $this->_tableExists ( $table )) {
			throw new \Exception ( sprintf ( "Table `%s` does not exist!", $table ) );
		}
		// Verify columns exists
		if (! $this->_ColumnExists ( $table, $column )) {
			throw new \Exception ( sprintf ( "Column `%s`.`%s` does not exist!", $table, $column ) );
		}

		if ($this->where == null) {
			$this->where = array ();
		}
		// Register Where command
		$this->where [] = array (
				'WHERE',
				$table,
				$column,
				$value != NULL ? $comparison : $comparison === "=",
				$value
		);
	}

	/**
	 * FunctionDescription
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param unknown $column
	 * @param unknown $not
	 * @param unknown $table
	 * @param unknown ...$params
	 *
	 * @throws \Exception
	 */
	public function registerWhereIn($column, $list, $not, $table) {
		// Validate argument types
		if (! is_string ( $column )) {
			throw new \Exception ( "Expected string, '" . gettype ( $column ) . "' provided" );
		}
		// Verify table exists
		if (! $this->_tableExists ( $table )) {
			throw new \Exception ( sprintf ( "Table `%s` does not exist!", $table ) );
		}
		// Verify columns exists
		if (! $this->_ColumnExists ( $table, $column )) {
			throw new \Exception ( sprintf ( "Column `%s`.`%s` does not exist!", $table, $column ) );
		}
		if ($this->where == null) {
			$this->where = array ();
		}
		// Register Where command
		$this->where [] = array (
				'WHEREIN',
				$table,
				$column,
				$list,
				$not
		);
	}
}