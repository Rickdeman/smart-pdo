<?php

/**
 * File: Parameters.php
 */
namespace SmartPDO;

use SmartPDO\Parameters\GroupBy;
use SmartPDO\Parameters\OrderBy;
use SmartPDO\Parameters\Between;
use SmartPDO\Parameters\WhereLogic;
use SmartPDO\Parameters\Group;
use SmartPDO\Parameters\Where;
use SmartPDO\Parameters\WhereIn;

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
	 * Placeholder for all GROUP BY columns
	 *
	 * @var GroupBy[]
	 */
	private $group = array ();

	/**
	 * Placeholder for each SET
	 *
	 * @var array
	 */
	private $insert = null;

	/**
	 * Placeholder for each JOIN
	 *
	 * @var array
	 */
	private $joins = null;

	/**
	 * Placeholder for the LIMIT
	 *
	 * @var array
	 */
	private $limit = null;

	/**
	 * Storage for all MySQL tables with columns
	 *
	 * @var array
	 */
	private $mysqlTables = null;

	/**
	 * Placeholder for each ORDER
	 *
	 * @var OrderBy[]
	 */
	private $order = null;

	/**
	 * Placeholder for the table prefix
	 *
	 * @var string
	 */
	private $prefix = "";

	/**
	 * placeholder for each SET key, value
	 *
	 * @var array
	 */
	private $set = null;

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
	private $where = array ();

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
	public function columnExists($table, $column) {
		try {
			return (in_array ( $column, explode ( ',', $this->mysqlTables [$table] ) ));
		} catch ( Exception $e ) {
			return false;
		}
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
	 * Get the GROUP BY collection
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return GroupBy[]
	 */
	public function getGroup() {
		return $this->group;
	}

	/**
	 * Get the INSERT collection
	 *
	 * arrays markup: column => value
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return array
	 */
	public function getInsert() {
		return $this->insert;
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
	 * @return OrderBy[]
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
	 * Get the SET collection
	 *
	 * arrays markup: column => value
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return array
	 */
	public function getSet() {
		return $this->set;
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
	 * @return WhereLogic[]
	 */
	public function getWhere() {
		return $this->where;
	}

	/**
	 * Register an BETWEEN
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Fully qualified table column
	 * @param double|int $start
	 *        	Start value
	 * @param double|int $stop
	 *        	Stop value
	 * @param bool $not
	 *        	Boolean for IS NOT
	 * @param bool $table
	 *        	Target table
	 * @param bool $and
	 *        	Is condition prefix with AND or OR
	 *
	 * @throws \Exception
	 */
	public function registerBetween($column, $start, $stop, $not, $table, $and) {
		// Check if function is allowed within current command
		if ((Config::PDO_WHERE & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register WHERE with current command: " . $this->command );
		}
		// Check if table & column exist
		$this->tableColumnCheck ( $table, $column );
		// Verify table is defined
		if (! in_array ( $table, $this->tables )) {
			$message = "Source table `%s` is not available at this moment!";
			$message = sprintf ( $message, $table );
			throw new \Exception ( $message );
		}
		$allowed = false;
		// Check both: double or int
		if ((is_double ( $start ) && is_double ( $stop )) || (is_int ( $start ) && is_int ( $stop ))) {
			$allowed = true;
		}
		// Check both: DateTime
		if ((is_object ( $start ) && is_object ( $stop )) && (get_class ( $start ) == "DateTime" && get_class ( $stop ) == "DateTime")) {
			$allowed = true;
		}
		if (is_string ( $start ) && is_string ( $stop )) {
			$allowed = true;
		}
		// Start and stop must bo both type of: double | int | DateTime
		if ($allowed !== true) {
			throw new \Exception ( "Start and stop values are not equal or not supported" );
		}
		// Register Where command
		$this->where [] = new Between ( $table, $column, $start, $stop, $not, $and );
	}

	/**
	 * FunctionDescription
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $columns
	 *        	Columns to be shown, fully named when using JOIN(s)
	 */
	public function registerColumns(...$columns) {
		$this->columns = $columns;
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
		if (! in_array ( strtoupper ( $command ), array_keys ( Config::commandList ) )) {
			throw new \Exception ( "Command is '" . strtoupper ( $command ) . "' invalid" );
		}
		// Register Command
		$this->command = strtoupper ( $command );
	}

	/**
	 * Register an GROUP within the WHERE statement with AND/OR
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param bool $or
	 *        	True for creating a new group, otherwise left handed will be created
	 * @throws \Exception
	 */
	public function registerGroup($and) {
		if (! is_bool ( $and )) {
			throw new \Exception ( "Expected bool, '" . gettype ( $and ) . "' provided" );
		}
		// Register Where command
		$this->where [] = new Group ( $and, null );
	}

	/**
	 * Register an GROUP BY
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Fully qualified table column
	 * @param bool $table
	 *        	Target table, NULL for master table
	 *
	 * @throws \Exception
	 */
	public function registerGroupBy($column, $table) {
		// Check if function is allowed within current command
		if ((Config::PDO_GROUPBY & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register GROUP BY with current command: " . $this->command );
		}
		//
		if (! is_string ( $column )) {
			throw new \Exception ( "Expected bool, '" . gettype ( $column ) . "' provided" );
		}
		// Verify Source columns exists
		if (! $this->columnExists ( $table, $column )) {
			throw new \Exception ( sprintf ( "Table column `%s`.`%s` does not exist!", $table, $column ) );
		}
		if (! in_array ( $table, $this->tables )) {
			throw new \Exception ( sprintf ( "Table `%s` is not available at this moment!", $table ) );
		}
		$this->group [] = new GroupBy ( $table, $column );
	}

	/**
	 * FunctionDescription
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Column name
	 * @param array $list
	 *        	(multiple) strings for WHERE IN
	 * @param bool $not
	 *        	Whether is must be in the list or not
	 * @param string $table
	 *        	Target table, NULL for master table
	 * @param bool $and
	 *        	Is condition prefix with AND or OR
	 *
	 * @throws \Exception
	 */
	public function registerIn($column, $list, $not, $table, $and) {
		// Check if function is allowed within current command
		if ((Config::PDO_WHERE & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register WHERE IN with current command: " . $this->command );
		}
		// Check if table & column exist
		$this->tableColumnCheck ( $table, $column );
		// Register Where command
		$this->where [] = new WhereIn ( $table, $column, $list, $not, $and );
	}
	/**
	 * Register an INSERT
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	Fully qualified table column
	 * @param string $value
	 *        	Value to be inserted
	 */
	public function registerInsert($column, $value) {
		// Check if function is allowed within current command
		if ((Config::PDO_INSERT & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register INSERT with current command: " . $this->command );
		}
		// Validate argument types
		if (! is_string ( $column )) {
			throw new \Exception ( "Expected string, '" . gettype ( $column ) . "' provided" );
		}
		if (! is_array ( $this->insert )) {
			$this->insert = array ();
		}
		// Add set parameters
		$this->insert [$column] = $value;
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
		if ((Config::PDO_JOIN & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register a JOIN with current command: " . $this->command );
		}
		// Validate comparison symbol
		if (! in_array ( $type, self::JoinList )) {
			throw new \Exception ( "JOIN types: '" . $comparison . "' is not allowed. see joinList for more info" );
		}
		// Check if source table & column exist
		$this->tableColumnCheck ( $sourceTable, $sourceColumn );
		// Check if target table & column exist
		$this->tableColumnCheck ( $targetTable, $targetColumn );
		// Check if source table is already defined
		if (! in_array ( $sourceTable, $this->tables )) {
			throw new \Exception ( sprintf ( "Source table `%s` is not available at this moment!", $targetTable ) );
		}
		if ($this->joins == NULL) {
			$this->joins = array ();
		}
		// Register INNER JOIN
		$this->joins [] = array (
				$type,
				$sourceTable,
				$sourceColumn,
				$targetTable,
				$targetColumn
		);
		$this->tables [] = $targetTable;
	}

	/**
	 * Register a LIKE
	 *
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @version 1
	 *
	 * @param unknown $column
	 *        	Column name
	 * @param unknown $value
	 *        	Value to be compared
	 * @param string $not
	 *        	if true will change to LIKE NOT
	 * @param unknown $table
	 *        	Table name, null for root table
	 * @param string $escape
	 *        	Escape character, which can be changed
	 */
	public function registerLike($column, $value, $not, $table, $escape) {
		// Check if function is allowed within current command
		if ((Config::PDO_WHERE & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register WHERE with current command: " . $this->command );
		}
		// Validate argument types
		if (! is_string ( $column )) {
			throw new \Exception ( "Expected string, '" . gettype ( $column ) . "' provided" );
		}
		// Verify table exists
		if (! $this->tableExists ( $table )) {
			throw new \Exception ( sprintf ( "Table `%s` does not exist!", $table ) );
		}
		// Verify columns exists
		if (! $this->columnExists ( $table, $column )) {
			throw new \Exception ( sprintf ( "Column `%s`.`%s` does not exist!", $table, $column ) );
		}

		// Register Where command
		$this->where [] = array (
				'LIKE',
				$table,
				$column,
				$value,
				$not,
				$escape
		);
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
	 * @throws \Exception
	 */
	public function registerLimit($start, $items) {
		// Check if function is allowed within current command
		if ((Config::PDO_LIMIT & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register LIMIT with current command: " . $this->command );
		}
		// Validate argument types
		if (! is_int ( $start )) {
			throw new \Exception ( "Expected integer, '" . gettype ( $start ) . "' provided" );
		}
		if (! is_int ( $items )) {
			throw new \Exception ( "Expected integer, '" . gettype ( $items ) . "' provided" );
		}
		// Set LIMIT values
		$this->limit = array (
				$start,
				$items
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
	 * @param bool $ascending
	 *        	True for acsending else descending
	 * @param bool $table
	 *        	Target table, NULL for master table
	 * @throws \Exception
	 */
	public function registerOrderBy($column, $ascending, $table) {
		// Check if function is allowed within current command
		if ((Config::PDO_ORDERBY & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register ORDER BY with current command: " . $this->command );
		}
		//
		if (! is_string ( $column )) {
			throw new \Exception ( "Expected bool, '" . gettype ( $column ) . "' provided" );
		}
		if (! is_bool ( $ascending )) {
			throw new \Exception ( "Expected bool, '" . gettype ( $ascending ) . "' provided" );
		}
		// Verify Source columns exists
		if (! $this->columnExists ( $table, $column )) {
			throw new \Exception ( sprintf ( "Table column `%s`.`%s` does not exist!", $table, $column ) );
		}
		if (! in_array ( $table, $this->tables )) {
			throw new \Exception ( sprintf ( "Table `%s` is not available at this moment!", $table ) );
		}
		$this->order [] = new OrderBy ( $table, $column, $ascending );
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
	 * Register a SET key value
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *        	table column
	 * @param string|integer $value
	 *        	Value to be updated
	 * @throws \Exception
	 */
	public function registerSet($column, $value) {
		// Check if function is allowed within current command
		if ((Config::PDO_UPDATE & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register SET with current command: " . $this->command );
		}
		// Validate column is a string
		if (! is_string ( $column )) {
			throw new \Exception ( "Expected string, '" . gettype ( $column ) . "' provided" );
		}
		if (! is_array ( $this->set )) {
			$this->set = array ();
		}
		$this->set [$column] = $value;
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
	 * @param string $and
	 *        	AND condition if true, else OR
	 *
	 * @throws \Exception
	 */
	public function registerWhere($table, $column, $comparison, $value, $and) {
		// Check if function is allowed within current command
		if ((Config::PDO_WHERE & Config::commandList [$this->command]) == 0) {
			throw new \Exception ( "Cannot register WHERE with current command: " . $this->command );
		}
		// Validate comparison symbol
		if (! in_array ( $comparison, self::compareList )) {
			throw new \Exception ( "provided invalid compare: '" . $comparison . "'. see compareList for more info" );
		}
		// Check if table & column exist
		$this->tableColumnCheck ( $table, $column );
		// Register Where command: COMMAND, TABLE, COMPARISION/BOOL(IS NULL), VALUE
		$this->where [] = new Where ( $table, $column, $value != NULL ? $comparison : $comparison === "=", $value, $and );
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
	public function tableExists($table) {
		return in_array ( $table, array_keys ( $this->mysqlTables ) );
	}
	private function tableColumnCheck($table, $column) {
		// Verify Source table is string
		if (! is_string ( $table )) {
			$message = "Expected 'table' to be string, '%s' provided";
			$message = sprintf ( $message, gettype ( $table ) );
			throw new \Exception ( $message );
		}
		// Verify Source column is string
		if (! is_string ( $column )) {
			$message = "Expected 'column' to be string, '%s' provided";
			$message = sprintf ( $message, gettype ( $column ) );
			throw new \Exception ( $message );
		}
		// Verify table exists
		if (! $this->tableExists ( $table )) {
			$message = "table `%s` does not exist!";
			$message = sprintf ( $message, $table );
			throw new \Exception ( $message );
		}
		// Verify columns exists
		if (! $this->columnExists ( $table, $column )) {
			$message = "column `%s`.`%s` does not exist!";
			$message = sprintf ( $message, $sourceTable, $column );
			throw new \Exception ( $message );
		}
	}
}