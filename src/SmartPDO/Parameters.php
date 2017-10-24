<?php

/**
 * File: Parameters.php
 */
namespace SmartPDO;

/**
 * Smart PDO Table parameters handler
 *
 * @author Rick de Man <rick@rickdeman.nl>
 * @version 1
 */
class Parameters
{

    /**
     * Placeholder for the columns to be selected, default = array( '*' )
     *
     * @var string[]
     */
    private $columns = array(
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
    private $dbTables = null;

    /**
     * Placeholder for the DISTINCT flag
     *
     * @var bool
     */
    private $distinct = false;

    /**
     * Placeholder for all GROUP BY columns
     *
     * @var \SmartPDO\Parameters\GroupBy[]
     */
    private $group = array();

    /**
     * Placeholder for each SET
     *
     * @var array
     */
    private $insert = null;

    /**
     * Placeholder for each JOIN
     *
     * @var \SmartPDO\Parameters\Join[]
     */
    private $joins = null;

    /**
     * Placeholder for the LIMIT
     *
     * @var \SmartPDO\Parameters\Limit
     */
    private $limit = null;

    /**
     * Placeholder for each ORDER
     *
     * @var \SmartPDO\Parameters\OrderBy[]
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
    private $tables = array();

    /**
     * Placeholder for all WHERE datasets
     *
     * @var array
     */
    private $where = array();

    /**
     * Initialise the Parameter set with the mysql
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param array $tables
     */
    function __Construct(array $tables)
    {
        $this->dbTables = $tables;
    }

    /**
     * Verify that a Table Column exists
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $table
     *            Tablename
     * @param string $column
     *            Column name
     *            
     * @return boolean
     */
    public function columnExists(string $table, string $column)
    {
        try {
            return (in_array($column, explode(',', $this->dbTables[$table])));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the requested columns to be shown
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Get the current query command
     *
     * @see array \SmartPDO\Config::commandList
     *     
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
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
     * @version 1
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
     * @version 1
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
     * @version 1
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
     * @version 1
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
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return array
     */
    public function getDbTables()
    {
        return $this->dbTables;
    }

    /**
     * Get the ORDER collection
     * array markup: Column => ASC|DESC
     *
     * @version 1
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
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return array
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get the SET collection
     * arrays markup: column => value
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return array
     */
    public function getSet()
    {
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
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Return all tables which will be used
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * Get the WHERE collection
     *
     * @version 1
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
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return boolean
     */
    public function isDistinct()
    {
        return $this->distinct === true;
    }

    /**
     * Register columns to be loaded
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $columns
     *            Columns to be shown, fully named when using JOIN(s)
     */
    public function registerColumns(string ...$columns)
    {
        $this->columns = $columns;
    }

    /**
     * Register the sql command
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @see array \SmartPDO\Config::commandList
     *     
     * @param string $command
     *            The SQL command type
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
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param bool $and
     *            New group AND or OR group
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
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            Fully qualified table column
     * @param string $table
     *            Target table, NULL for master table
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
        if (! in_array($table, $this->tables)) {
            throw new \Exception(sprintf("Table `%s` is not available at this moment!", $table));
        }
        $this->group[] = new \SmartPDO\Parameters\GroupBy($table, $column);
    }

    /**
     * Register an INSERT
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            Fully qualified table column
     * @param string $value
     *            Value to be inserted
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
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @see \SmartPDO\Config::JoinList
     *
     * @param string $type
     *            Type of join to be used
     * @param string $tableLeft
     *            Fully qualified source table name including prefix
     * @param string $columnLeft
     *            Fully qualified source table column
     * @param string $tableRight
     *            Fully qualified target table name including prefix
     * @param string $columnsRight
     *            Fully qualified target table column
     * @param string $comparison
     *            Comparision action see compareList for more info
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
        // Check if source table & column exist
        $this->tableColumnCheck($tableLeft, $columnLeft);
        // Check if target table & column exist
        $this->tableColumnCheck($tableRight, $columnsRight);
        // Check if source table is already defined
        if (! in_array($tableLeft, $this->tables)) {
            throw new \Exception(sprintf("Source table `%s` is not available at this moment!", $tableRight));
        }
        if ($this->joins == NULL) {
            $this->joins = array();
        }
        // Register INNER JOIN
        $this->joins[] = new \SmartPDO\Parameters\Join($type, $tableLeft, $columnLeft, $tableRight, $columnsRight);
        $this->tables[] = $tableRight;
    }

    /**
     * Register the LIMIT
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param int $items
     *            Number of rows the fetch
     * @param int $start
     *            Start row
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
     * Register an ORDER BY
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            Fully qualified table column
     * @param bool $ascending
     *            True for acsending else descending
     * @param string $table
     *            Target table, NULL for master table
     *            
     * @throws \Exception
     */
    public function registerOrderBy(string $column, bool $ascending, string $table)
    {
        // Check if function is allowed within current command
        if ((Config::PDO_ORDERBY & Config::commandList[$this->command]) == 0) {
            throw new \Exception("Cannot register ORDER BY with current command: " . $this->command);
        }
        //
        if (! is_string($column)) {
            throw new \Exception("Expected bool, '" . gettype($column) . "' given");
        }
        if (! is_bool($ascending)) {
            throw new \Exception("Expected bool, '" . gettype($ascending) . "' given");
        }
        // Verify Source columns exists
        if (! $this->columnExists($table, $column)) {
            throw new \Exception(sprintf("Table column `%s`.`%s` does not exist!", $table, $column));
        }
        if (! in_array($table, $this->tables)) {
            throw new \Exception(sprintf("Table `%s` is not available at this moment!", $table));
        }
        $this->order[] = new \SmartPDO\Parameters\OrderBy($table, $column, $ascending);
    }

    /**
     * Register the database used prefix
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $prefix
     *            Provide the prefix for the table
     *            
     * @throws \Exception
     */
    public function registerPrefix(string $prefix)
    {
        // Validate argument types
        if (! is_string($prefix)) {
            throw new \Exception("Expected string, '" . gettype($prefix) . "' given");
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
     *            table column
     * @param string|integer $value
     *            Value to be updated
     *            
     * @throws \Exception
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
        $this->set[$column] = $value;
    }

    /**
     * Register the table name
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $table
     *            Fully qualified table
     *            
     * @throws \Exception
     */
    public function registerTable(string $table)
    {
        // Validate argument types
        if (! is_string($table)) {
            throw new \Exception("Expected string, '" . gettype($table) . "' given");
        }
        // Register table name
        $this->table = $table;
        $this->tables[] = $table;
    }

    /**
     * Register a new dataset: WHERE
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @see array \SmartPDO\Config::compareList
     *     
     * @param string $table
     *            Table name which the columns belongs to
     * @param string $column
     *            Fully qualified source table column
     * @param string $comparison
     *            Comparision action see compareList for more info
     * @param string $value
     *            Value to compare
     * @param string $and
     *            AND condition if true, else OR
     *            
     * @throws \Exception
     */
    public function registerWhere($table, $column, $comparison, $value, $and)
    {
        // Check if function is allowed within current command
        if ((Config::PDO_WHERE & Config::commandList[$this->command]) == 0) {
            throw new \Exception("Cannot register WHERE with current command: " . $this->command);
        }
        // Validate comparison symbol
        if (! in_array($comparison, \SmartPDO\Config::compareList)) {
            throw new \Exception("provided invalid compare: '" . $comparison . "'. see compareList for more info");
        }
        // Check if table & column exist
        $this->tableColumnCheck($table, $column);
        // if value = NULL > bool else comparison operator
        $comp = $value !== NULL ? $comparison : $comparison === "=";
        // Register Where command: COMMAND, TABLE, COMPARISION/BOOL(IS NULL), VALUE
        $this->where[] = new \SmartPDO\Parameters\Where($table, $column, $comp, $value, $and);
    }

    /**
     * Register a new dataset: WHERE BETWEEN
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            Fully qualified table column
     * @param double|int|\DateTime $start
     *            Start value
     * @param double|int|\DateTime $stop
     *            Stop value
     * @param bool $not
     *            Boolean for IS NOT
     * @param bool $table
     *            Target table
     * @param bool $and
     *            Is condition prefix with AND or OR
     *            
     * @throws \Exception
     */
    public function registerWhereBetween(string $column, $start, $stop, bool $not, string $table, bool $and)
    {
        // Check if function is allowed within current command
        if ((Config::PDO_WHERE & Config::commandList[$this->command]) == 0) {
            throw new \Exception("Cannot register WHERE with current command: " . $this->command);
        }
        // Check if table & column exist
        $this->tableColumnCheck($table, $column);
        // Verify table is defined
        if (! in_array($table, $this->tables)) {
            $message = "Source table `%s` is not available at this moment!";
            $message = sprintf($message, $table);
            throw new \Exception($message);
        }
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
        // Register Where command
        $this->where[] = new \SmartPDO\Parameters\Where\Between($table, $column, $start, $stop, $not, $and);
    }

    /**
     * Register a new dataset: WHERE IN
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            Column name
     * @param array $list
     *            (multiple) strings|numbers for WHERE IN
     * @param bool $not
     *            Whether is must be in the list or not
     * @param string $table
     *            Target table, NULL for master table
     * @param bool $and
     *            Is condition prefix with AND or OR
     *            
     * @throws \Exception
     */
    public function registerWhereIn(string $column, array $list, bool $not, string $table, bool $and)
    {
        // Check if function is allowed within current command
        if ((Config::PDO_WHERE & Config::commandList[$this->command]) == 0) {
            throw new \Exception("Cannot register WHERE IN with current command: " . $this->command);
        }
        // Check if table & column exist
        $this->tableColumnCheck($table, $column);
        // Register Where command
        $this->where[] = new \SmartPDO\Parameters\Where\In($table, $column, $list, $not, $and);
    }

    /**
     * Register a LIKE
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            Fully qualified table column
     * @param mixed $value
     *            Value to be compared
     * @param string $not
     *            if true will change to LIKE NOT
     * @param bool $table
     *            Target table, NULL for master table
     * @param string $escape
     *            Escape character, which can be changed
     * @param bool $and
     *            Is condition prefix with AND or OR
     */
    public function registerWhereLike(string $column, $value, bool $not, string $table, string $escape, bool $and)
    {
        // Check if function is allowed within current command
        if ((Config::PDO_WHERE & Config::commandList[$this->command]) == 0) {
            throw new \Exception("Cannot register WHERE with current command: " . $this->command);
        }
        // Validate comparison symbol
        if (! is_bool($not)) {
            $message = "Expected 'not' to be boolean, '%s' given";
            $message = sprintf($message, gettype($table));
            throw new \Exception($message);
        }
        // Check if table & column exist
        $this->tableColumnCheck($table, $column);
        // Register Where command
        $this->where[] = new \SmartPDO\Parameters\Where\Like($table, $column, $value, $not, $escape, $and);
    }

    /**
     * Enable Distinct, columns must be defined
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     */
    public function setDistinct()
    {
        $this->distinct = true;
    }

    /**
     * Verify that a Table exists
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $table
     *            Tablename
     *            
     * @return boolean
     */
    public function tableExists(string $table)
    {
        return in_array($table, array_keys($this->dbTables));
    }

    /**
     * Check if a table exists with its columns
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $table
     *            Table name
     * @param string $column
     *            Column name
     * @throws \Exception
     */
    private function tableColumnCheck(string $table, string $column)
    {
        // Verify Source table is string
        if (! is_string($table)) {
            $message = "Expected 'table' to be string, '%s' given";
            $message = sprintf($message, gettype($table));
            throw new \Exception($message);
        }
        // Verify Source column is string
        if (! is_string($column)) {
            $message = "Expected 'column' to be string, '%s' given";
            $message = sprintf($message, gettype($column));
            throw new \Exception($message);
        }
        // Verify table exists
        if (! $this->tableExists($table)) {
            $message = "table `%s` does not exist!";
            $message = sprintf($message, $table);
            throw new \Exception($message);
        }
        // Verify columns exists
        if (! $this->columnExists($table, $column)) {
            $message = "column `%s`.`%s` does not exist!";
            $message = sprintf($message, $table, $column);
            throw new \Exception($message);
        }
    }
}