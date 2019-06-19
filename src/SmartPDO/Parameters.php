<?php

/**
 * File: Parameters.php
 */
namespace SmartPDO;

/**
 * Smart PDO Table parameters handler
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class Parameters
{

	/**
	 * Placeholder for the columns to be selected, default = array( '*' )
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var string[]
	 */
	private $columns = array(
		'*'
	);

	/**
	 * Placeholder for the main query statement: SELECT DELETE etc
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var string
	 */
	private $command = 'SELECT';

	/**
	 * Storage for active database
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var \SmartPDO\Interfaces\Database
	 */
	private $db = null;

	/**
	 * Placeholder for the DISTINCT flag
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var bool
	 */
	private $distinct = false;

	/**
	 * Placeholder for all GROUP BY columns
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var \SmartPDO\Parameters\GroupBy[]
	 */
	private $group = null;

	/**
	 * Placeholder for each SET
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var array
	 */
	private $insert = null;

	/**
	 * Placeholder for each JOIN
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var \SmartPDO\Parameters\Join[]
	 */
	private $joins = null;

	/**
	 * Placeholder for the LIMIT
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var \SmartPDO\Parameters\Limit
	 */
	private $limit = null;

	/**
	 * Placeholder for each ORDER
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var \SmartPDO\Parameters\OrderBy[]
	 */
	private $order = null;

	/**
	 * Placeholder for the table prefix
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var string
	 */
	private $prefix = "";

	/**
	 * placeholder for each SET key, value
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var \SmartPDO\Parameters\Set[]
	 */
	private $set = null;

	/**
	 * Placeholder for the current table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var string
	 */
	private $tableName = null;

	/**
	 * Placeholder for all selected table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var string[]
	 */
	private $tableNames = null;

	/**
	 * Placeholder for all WHERE datasets
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @var \SmartPDO\Parameters\WhereLogic[]
	 */
	private $where = null;

	/**
	 * Initialise the Parameter set with the mysql
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param \SmartPDO\Interfaces\Database $db
	 *			the SmartPDO database
	 * @param string $tableName
	 *			The main table
	 */
	function __Construct(\SmartPDO\Interfaces\Database $db, string $tableName)
	{
		// Register the Database
		$this->db = $db;
		// Register the First Table
		$this->registerTable($db->getTableName($tableName));
	}

	/**
	 * Verify that a Table Column exists
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $tableName 
	 *			Tablename
	 * @param string $column
	 *			Column name
	 *			
	 * @return bool
	 */
	public function columnExists(string $tableName, string $column)
	{
		// Let the database check if the Table Column exists
		return $this->db->columnExists($tableName, $column);
	}

	/**
	 * Get the requested columns to be shown
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @return string[]
	 */
	public function getColumns()
	{
		// Return the Column names which are used
		return $this->columns;
	}

	/**
	 * Get the current query command
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *	 
	 * @see array \SmartPDO\Config::commandList
	 *		
	 * @return string
	 */
	public function getCommand()
	{
		return $this->command;
	}

	/**
	 * Get the GROUP BY collection
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return \SmartPDO\Parameters\GroupBy[]
	 */
	public function getGroup()
	{
		return $this->group;
	}

	/**
	 * Get the INSERT collection
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return array
	 */
	public function getInsert()
	{
		return $this->insert;
	}

	/**
	 * Get the JOIN collection
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return \SmartPDO\Parameters\Join[]
	 */
	public function getJoins()
	{
		return $this->joins;
	}

	/**
	 * Get the LIMIT
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return \SmartPDO\Parameters\Limit
	 */
	public function getLimit()
	{
		return $this->limit;
	}

	/**
	 * Returns all Database tables
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *			Tablename for the TableInformation
	 *			
	 * @return \SmartPDO\Interfaces\TableColumns
	 */
	public function getTableInfo($table)
	{
		// returns all columns of a single table
		return $this->db->getTableInfo($table);
	}
	
	/**
	 * Returns all Database tables
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return \SmartPDO\Interfaces\TableColumns
	 */
	public function getTableInfos()
	{
		// return all tables with its columns
		return $this->db->getTableInfos();
	}

	/**
	 * Get the ORDER collection
	 * array markup: Column => ASC|DESC
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return \SmartPDO\Parameters\OrderBy[]
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * Get the table prefix
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->db->getPrefix();
	}

	/**
	 * Get the SET collection
	 * arrays markup: column => value
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return \SmartPDO\Parameters\Set[]
	 */
	public function getSet()
	{
		return $this->set;
	}

	/**
	 * Get the main table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return string
	 */
	public function getTable()
	{
		return $this->tableName;
	}

	/**
	 * Return all tables which will be used
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return string[]
	 */
	public function getTables()
	{
		return $this->tableNames;
	}

	/**
	 * Get the WHERE collection
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return \SmartPDO\Parameters\WhereLogic[]
	 */
	public function getWhere()
	{
		return $this->where;
	}

	/**
	 * Checks if the current query requires a Distinc
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return bool
	 */
	public function isDistinct()
	{
		// Returns if the current query is in DISTINCT mode
		return $this->distinct === true;
	}

	/**
	 * Register columns to be loaded
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $columns
	 *			Columns to be shown, fully named when using JOIN(s)
	 */
	public function registerColumns(string ...$columns)
	{
		$this->columns = $columns;
	}

	/**
	 * Register the sql command
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @see \SmartPDO\Config::commandList
	 *
	 * @param string $command
	 *			The SQL command type
	 *
	 * @throws \Exception
	 */
	 public function registerCommand(string $command)
	{
		// Validate argument types
		if (! is_string($command)) {
			throw new \Exception("Expected string, '" . gettype($command) . "' given");
		}
		// Check if command is available
		if (! in_array(strtoupper($command), array_keys(Config::commandList))) {
			throw new \Exception("Command is '" . strtoupper($command) . "' invalid");
		}
		// Register Command
		$this->command = strtoupper($command);
	}

	/**
	 * Register a new AND/OR GROUP
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param bool $and
	 *			New group AND or OR group
	 *			
	 * @throws \Exception
	 */
	public function registerGroup(bool $and)
	{
		if (! is_bool($and)) {
			throw new \Exception("Expected boolean, '" . gettype($and) . "' given");
		}
		// Register Where command
		$this->where[] = new \SmartPDO\Parameters\Group($and === true, false);
	}

	/**
	 * Register an GROUP BY
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *			Fully qualified table column
	 * @param string $table
	 *			Target table, NULL for master table
	 *
	 * @throws \Exception
	 */
	public function registerGroupBy(string $column, string $table)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_GROUPBY & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register GROUP BY with current command: " . $this->command);
		}
		//
		if (! is_string($column)) {
			throw new \Exception("Expected bool, '" . gettype($column) . "' given");
		}
		// Verify Source columns exists
		if (! $this->columnExists($table, $column)) {
			throw new \Exception(sprintf("Table column `%s`.`%s` does not exist!", $table, $column));
		}
		if (! in_array($table, $this->tableNames)) {
			throw new \Exception(sprintf("Table `%s` is not available at this moment!", $table));
		}
		if (! is_array($this->group)) {
			$this->group = array();
		}
		$this->group[] = new \SmartPDO\Parameters\GroupBy($table, $column);
	}

	/**
	 * Register an INSERT
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $column
	 *			Fully qualified table column
	 * @param string $value
	 *			Value to be inserted
	 */
	public function registerInsert(string $column, $value)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_INSERT & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register INSERT with current command: " . $this->command);
		}
		// Validate argument types
		if (! is_string($column)) {
			throw new \Exception("Expected string, '" . gettype($column) . "' given");
		}
		if (! is_array($this->insert)) {
			$this->insert = array();
		}
		// Add set parameters
		$this->insert[$column] = $value;
	}

	/**
	 * Register an JOIN
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @see \SmartPDO\Config::JoinList
	 *
	 * @param string $type
	 *			Type of join to be used
	 * @param string $tableLeft
	 *			Fully qualified source table name including prefix
	 * @param string $columnLeft
	 *			Fully qualified source table column
	 * @param string $tableRight
	 *			Fully qualified target table name including prefix
	 * @param string $columnsRight
	 *			Fully qualified target table column
	 * @param string $comparison
	 *			Comparision action see compareList for more info
	 *			
	 * @throws \Exception
	 */
	public function registerJoin(string $type, string $tableLeft, string $columnLeft, string $tableRight, string $columnsRight, string $comparison)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_JOIN & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register a JOIN with current command: " . $this->command);
		}
		// Validate comparison symbol
		if (! in_array($type, Config::JoinList)) {
			throw new \Exception("JOIN types: '" . $comparison . "' is not allowed. see joinList for more info");
		}
		// Validate comparison symbol
		if (! in_array($comparison, \SmartPDO\Config::compareList)) {
			throw new \Exception("provided invalid compare: '" . $comparison . "'. see compareList for more info");
		}
		// Get the actual tablename
		$tableLeft = $this->db->getTableName($tableLeft);
		// Get the actual tablename
		$tableRight = $this->db->getTableName($tableRight);		
		// Check if source table & column exist, and table is available in the current context
		$this->tableColumnCheck($tableLeft, $columnLeft, true);
		// Check if target table & column exist
		$this->tableColumnCheck($tableRight, $columnsRight);
		// Check if the join table is null
		if ($this->joins == NULL) {
			$this->joins = array();
		}
		// Register INNER JOIN
		$this->joins[] = new \SmartPDO\Parameters\Join($type, $tableLeft, $columnLeft, $tableRight, $columnsRight);
		// Register table if not registered for usage
		$this->registerTable($tableRight);
	}

	/**
	 * Register the LIMIT
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param int $items
	 *			Number of rows the fetch
	 * @param int $start
	 *			Start row
	 *			
	 * @throws \Exception
	 */
	public function registerLimit(int $items, int $start)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_LIMIT & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register LIMIT with current command: " . $this->command);
		}
		if (! is_int($items)) {
			throw new \Exception("Expected integer, '" . gettype($items) . "' given");
		}
		// Validate argument types
		if (! is_int($start)) {
			throw new \Exception("Expected integer, '" . gettype($start) . "' given");
		}
		
		if (! ($items >= 0)) {
			throw new \Exception("items value must positive!");
		}
		if (! ($start >= 0)) {
			throw new \Exception("Start value must positive!");
		}
		// Set LIMIT values
		$this->limit = new \SmartPDO\Parameters\Limit($items, $start);
	}

	/**
	 * Register a MOD on a column
	 * 
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *	 
	 * @see \SmartPDO\Config::commandList
	 * @see \SmartPDO\Config::modList
	 * 
	 * @param string $column
	 *			the column to be modified
	 * @param float $mod 
	 *			the value it should be modified
	 * @param string $operator
	 *			the operator flag for increment/decrease
	 */
	public function registerMod(string $column, float $mod, string $operator )
	{
		// Check if function is allowed within current command
		if ((Config::PDO_UPDATE & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register 'MOD' with current command: " . $this->command);
		}
		// Validate comparison symbol
		if (! in_array($operator, Config::modList)) {
			throw new \Exception("MOD type: '" . $operator . "' is not allowed. see ModList for more info");
		}
		if (! ($mod >= 0)) {
			throw new \Exception("items value must positive!");
		}
		// Add MOD set parameters
		$this->set[] = new Parameters\Mod($column, $operator, $mod);
	}
	
	/**
	 * Register an ORDER BY
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $column
	 *			Fully qualified table column
	 * @param bool $ascending
	 *			True for acsending else descending
	 * @param string $table
	 *			Target table, NULL for master table
	 */
	public function registerOrderBy(string $column, bool $ascending, string $table)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_ORDERBY & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register ORDER BY with current command: " . $this->command);
		}
		// Check if the column is provided as a String
		if (! is_string($column)) {
			throw new \Exception("Expected bool, '" . gettype($column) . "' given");
		}
		// Check if the Ascending is provided as a Boolean
		if (! is_bool($ascending)) {
			throw new \Exception("Expected bool, '" . gettype($ascending) . "' given");
		}
		// Verify Source columns exists
		if (! $this->columnExists($table, $column)) {
			throw new \Exception(sprintf("Table column `%s`.`%s` does not exist!", $table, $column));
		}
		// Check if the table is useable at the moment
		if (! in_array($table, $this->tableNames)) {
			throw new \Exception(sprintf("Table `%s` is not available at this moment!", $table));
		}
		$this->order[] = new \SmartPDO\Parameters\OrderBy($table, $column, $ascending);
	}

	/**
	 * Register a SET key value
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @param string $column
	 *			table column
	 * @param string|integer
	 *			$value Value to be updated
	 */
	public function registerSet(string $column, $value)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_UPDATE & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register SET with current command: " . $this->command);
		}
		// Validate column is a string
		if (! is_string($column)) {
			throw new \Exception("Expected string, '" . gettype($column) . "' given");
		}
		if (! is_array($this->set)) {
			$this->set = array();
		}
		$this->set[] = new Parameters\Set($column, $value) ;
	}

	/**
	 * Register the table name
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $table
	 *			table to be registered
	 */
	private function registerTable(string $table)
	{
		// Check if the table exists
		if(!$this->db->tableExists($table)){
			throw new \Exception(sprintf("table `%s` does not exist!", $table));
		}
		// Check if the tablenames is an array
		if(!is_array($this->tableNames)){
			// Create new array
			$this->tableNames = array();
		}
		// Check if the master table is defined
		if(is_null($this->tableName)){
			// Define the master table
			$this->tableName = $table;			
		}
		// Check if the table is already registered
		if(!in_array($table, $this->tableNames)){
			// Register table name
			$this->tableNames[] = $table;			
		}
	}

	/**
	 * Register a new dataset: WHERE
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @see \SmartPDO\Config::compareList
	 * @see \SmartPDO\Config::commandList
	 *	 
	 * @param string $tableName
	 *			Table name which the columns belongs to
	 * @param string $column
	 *			Fully qualified source table column
	 * @param string $comparison
	 *			Comparision action see compareList for more info
	 * @param string $value
	 *			Value to compare
	 * @param string $and
	 *			AND condition if true, else OR
	 */
	public function registerWhere($tableName, $column, $comparison, $value, $and)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_WHERE & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register WHERE with current command: " . $this->command);
		}
		// Validate comparison symbol
		if (! in_array($comparison, \SmartPDO\Config::compareList)) {
			throw new \Exception("provided invalid compare: '" . $comparison . "'. see compareList for more info");
		}
		// Get the actual tablename
		$tableName = $this->db->getTableName($tableName);
		// CCheck if table & column exist, and Table is available
		$this->tableColumnCheck(
			$tableName,
			$column,
			true
		);
		// Check if the where is an array
		if(!is_array($this->where)){
			// Make array
			$this->where = array();
		}
		// Register Where command: COMMAND, TABLE, COMPARISION/BOOL(IS NULL), VALUE
		$this->where[] = new \SmartPDO\Parameters\Where(
			$tableName, 
			$column, 
			$comparison, 
			$value, 
			$and
		);
	}

	/**
	 * Register a new dataset: WHERE BETWEEN
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param bool $tableName
	 *			Target table
	 * @param string $column
	 *			Fully qualified table column
	 * @param double|int|\DateTime $start
	 *			Start value
	 * @param double|int|\DateTime $stop
	 *			Stop value
	 * @param bool $not
	 *			Boolean for IS NOT
	 * @param bool $and
	 *			Is condition prefix with AND or OR
	 */
	public function registerWhereBetween(string $tableName, string $column, $start, $stop, bool $not, bool $and)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_WHERE & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register WHERE with current command: " . $this->command);
		}
		// Get the actual tablename
		$tableName = $this->db->getTableName($tableName);
		// CCheck if table & column exist, and Table is available
		$this->tableColumnCheck(
			$tableName,
			$column,
			true);
		// Check if Start/Stop is allowed
		$allowed = false;
		// Check both: double or int
		if ((is_double($start) && is_double($stop)) || (is_int($start) && is_int($stop))) {
			$allowed = true;
		}
		// Check both: DateTime
		if ((is_object($start) && is_object($stop)) && (get_class($start) == "DateTime" && get_class($stop) == "DateTime")) {
			$allowed = true;
		}
		if (is_string($start) && is_string($stop)) {
			$allowed = true;
		}
		// Start and stop must bo both type of: double | int | DateTime
		if ($allowed !== true) {
			throw new \Exception("Start and stop values are not equal or not supported");
		}
		// Check if the where is an array
		if(!is_array($this->where)){
			// Make array
			$this->where = array();
		}
		// Register Where command
		$this->where[] = new \SmartPDO\Parameters\Where\Between(
			$tableName,
			$column,
			$start,
			$stop,
			$not, 
			$and);
	}

	/**
	 * Register a new dataset: WHERE IN
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $tableName
	 *			Target table, NULL for master table
	 * @param string $column
	 *			Column name
	 * @param array $list
	 *			(multiple) strings|numbers for WHERE IN
	 * @param bool $not
	 *			Whether is must be in the list or not
	 * @param bool $and
	 *			Is condition prefix with AND or OR
	 *			
	 * @throws \Exception
	 */
	public function registerWhereIn(string $tableName, string $column, array $list, bool $not, bool $and)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_WHERE & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register WHERE IN with current command: " . $this->command);
		}
		// Get the actual tablename
		$tableName = $this->db->getTableName($tableName);
		// CCheck if table & column exist, and Table is available
		$this->tableColumnCheck(
			$tableName, 
			$column, 
			true
		);
		// Check if the where is an array
		if(!is_array($this->where)){
			// Make array
			$this->where = array();
		}
		// Register Where command
		$this->where[] = new \SmartPDO\Parameters\Where\In(
			$tableName,
			$column,
			$list,
			$not,
			$and
		);
	}

	/**
	 * Register a LIKE
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param bool $tableName
	 *			Target table, NULL for master table
	 * @param string $column
	 *			Fully qualified table column
	 * @param mixed $value
	 *			Value to be compared
	 * @param string $not
	 *			if true will change to LIKE NOT
	 * @param string $escape
	 *			Escape character, which can be changed
	 * @param bool $and
	 *			Is condition prefix with AND or OR
	 */
	public function registerWhereLike(string $tableName, string $column, $value, bool $not, string $escape, bool $and)
	{
		// Check if function is allowed within current command
		if ((Config::PDO_WHERE & Config::commandList[$this->command]) == 0) {
			throw new \Exception("Cannot register WHERE with current command: " . $this->command);
		}
		// Get the actual tablename
		$tableName = $this->db->getTableName($tableName);
		// Check if table & column exist, and Table is available
		$this->tableColumnCheck(
			$tableName, 
			$column,
			true
		);
		// Check if the where is an array
		if(!is_array($this->where)){
			// Make array
			$this->where = array();
		}
		// Register Where command
		$this->where[] = new \SmartPDO\Parameters\Where\Like(
			$tableName,
			$column,
			$value, 
			$not, 
			$escape, 
			$and
		);
	}

	/**
	 * Enable Distinct, columns must be defined
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 */
	public function setDistinct()
	{
		$this->distinct = true;
	}
	
	/**
	 * Check if a table exists with its columns
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $tableName
	 *			Table name
	 * @param string $column
	 *			Column name
	 * @throws \Exception
	 */
	private function tableColumnCheck(string $tableName, string $column, bool $checkAvailable = false)
	{
		// Verify table exists
		if (! $this->tableExists($tableName)) {
			$message = sprintf(
				"table `%s` does not exist!",
				$tableName
			);
			throw new \Exception($message);
		}
		// Verify columns exists
		if (! $this->columnExists($tableName, $column)) {
			$message = sprintf(
				"column `%s`.`%s` does not exist!",
				$tableName,
				$column
			);
			throw new \Exception($message);
		}
		if($checkAvailable === true){
			// Verify table is defined
			if (! in_array($tableName, $this->tableNames)) {
				$message = sprintf(
					"table `%s` is not available at this moment!",
					$tableName
				);
				throw new \Exception($message);
			}
		}
	}
	
	/**
	 * Verify that a Table exists
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $tableName
	 *			Tablename to be checked if it exists
	 *			
	 * @return bool
	 */
	public function tableExists(string $tableName)
	{
		// Let the database check if the Table exists 
		return $this->db->tableExists($tableName);
	}
}