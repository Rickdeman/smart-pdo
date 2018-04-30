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
 */
class Rows implements \SmartPDO\Interfaces\Rows
{

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
    private $values = array();

    /**
     * MySQL execution and Row Handling
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Interfaces\Database $db
     *            The SmartPDO Database handler
     * @param \SmartPDO\Parameters $param
     *            the SmartPDo Parameters
     *            
     * @throws \Exception
     */
    public function __Construct(\SmartPDO\Interfaces\Database $db, \SmartPDO\Parameters $param)
    {
        // Store PDO
        $this->mysql = $db;
        // Store parameters
        $this->parameters = $param;
        // Check if multiple tables are used
        $this->multipleTables = count($param->getTables()) > 1;
        
        // Trim the query
        $query = trim(self::_CreateQuery($param, $this->values));
        // Query command check
        switch ($param->getCommand()) {
            // Query: select
            case "SELECT":
            case "INSERT":
            case "UPDATE":
            case "DELETE":
                break;
            
            default:
                var_dump($query);
                throw new \Exception("Command '" . $param->getCommand() . "' not yet implemented!");
                break;
        }
        
        // Prepate the pdo
        $this->sth = $this->mysql->pdo->prepare($query);
        // Execute with values
        try {

            // Check if the database is readonly and WRITE permissions are required
            if (Config::$readOnly == true && (Config::PDO_WRITE & Config::commandList[$param->getCommand()]) != 0) {
                // Provide fake ID's
                $this->rowCount = 11;
                $this->insertedID = 11;
            } else {
                // Execute query with the pramters
                $this->sth->execute($this->values);
                // Check if current query is an INSERT
                if ($param->getCommand() == 'INSERT') {
                    // Store the insertID
                    $this->insertedID = $this->mysql->pdo->lastInsertId();
                }
                // Get and store the rowcount
                $this->rowCount = $this->sth->rowCount();
            }
        } catch (\Exception $ex) {
            // Something when wrong...
            echo $query . PHP_EOL;
            throw new \Exception($ex->getMessage());
        }
        
        if (get_class($db) == "SmartPDO\MySQL") {
            try {
                $query = "";
                $query .= 'SELECT `TABLE_ROWS`' . PHP_EOL;
                $query .= '	FROM `INFORMATION_SCHEMA`.`TABLES`' . PHP_EOL;
                $query .= '	WHERE `TABLE_SCHEMA` = ? AND TABLE_NAME = ?';
                
                $values = array(
                    $this->mysql->getDatabaseName(),
                    $param->getTable()
                );
                $sth = $this->mysql->pdo->prepare($query);
                $sth->execute($values);
                
                $this->tableRows = intval($sth->fetch()['TABLE_ROWS']);
            } catch (\Exception $ex) {
                // Something when wrong...
                echo $query . PHP_EOL;
                throw new \Exception($ex->getMessage());
            }
        }
        // Increase the counter, nice to have for testing after x commands
        self::$queryCounter ++;
    }

    /**
     * Build the MySQL Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     *            
     * @return mixed
     */
    public static function _CreateQuery(\SmartPDO\Parameters $param, array &$values)
    {
        // Check if more than 1 table is used
        $mTables = count($param->getTables()) > 1;
        $values = array();
        $columns = array();
        // Query Format
        $query = "{SELECT}{INSERT}{UPDATE}{DELETE}{JOIN}{WHERE}{GROUPBY}{ORDERBY}{LIMIT}";
        // Build the real Query
        $query = str_replace('{SELECT}', self::createSelect($param, $values, $columns, $mTables), $query);
        $query = str_replace('{INSERT}', self::createInsert($param, $values, $columns, $mTables), $query);
        $query = str_replace('{UPDATE}', self::createUpdate($param, $values, $columns, $mTables), $query);
        $query = str_replace('{DELETE}', self::createDelete($param, $values, $columns, $mTables), $query);
        $query = str_replace('{JOIN}', self::createJoins($param, $values, $columns, $mTables), $query);
        $query = str_replace('{WHERE}', self::createWhere($param, $values, $columns, $mTables), $query);
        $query = str_replace('{GROUPBY}', self::createGroupBy($param, $values, $columns, $mTables), $query);
        $query = str_replace('{ORDERBY}', self::createOrderBy($param, $values, $columns, $mTables), $query);
        $query = str_replace('{LIMIT}', self::createLimit($param, $values, $columns, $mTables), $query);
        return $query;
    }

    /**
     * Creates the DELETE part in the Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function createDelete(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if DELETE can be used with the current command
        if ((Config::PDO_DELETE & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Return result
        return sprintf("DELETE FROM `%s`", $param->getTable()) . PHP_EOL;
    }

    /**
     * Creates the INSERT part in the Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function createInsert(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if INSERT can be used with the current command
        if ((Config::PDO_INSERT & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Check if INSERTS is not null and has items
        if ($param->getInsert() === null || count($param->getInsert()) == 0) {
            // Nothing to be inserted
            return "";
        }
        // Load all columns ( keys )
        $pcolumns = array_keys($param->getInsert());
        // Dynamicly add ? for prepared statement
        $pvalues = array_fill(0, count($param->getInsert()), "?");
        // Add all values for the prepared statement
        $values = array_merge($values, array_values($param->getInsert()));
        // Return result
        return sprintf("INSERT INTO `%s` (`%s`) VALUES (%s)", $param->getTable(), implode('`, `', $pcolumns), implode(", ", $pvalues));
    }

    /**
     * Creates the GROUP BY part in the Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @throws \Exception
     *
     * @return string
     */
    private static function createGroupBy(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if ORDER BY can be used with the current command
        if ((Config::PDO_GROUPBY & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Load GROUP BY's
        $groups = $param->getGroup();
        // Result variable
        $result = "";
        // Check if ORDER BY is not null and has items
        if ($groups === null || count($groups) == 0) {
            // No ordering
            return "";
        }
        $list = array();
        // Loop throuhg all parameters
        foreach ($groups as $group) {
            // Load parameters
            $table = $group->getTable();
            $column = $group->getColumn();
            // Check if the column exists at first
            if (! $param->columnExists($table, $column)) {
                // Error message
                $message = "Column `%s`.`%s` does not exist!";
                $message = sprintf($message, $table, $column);
                // Error throw
                throw new \Exception($message);
            }
            // Check if multiple tables are used
            if ($values == true) {
                
                if (! $param->tableExists($table)) {
                    throw new \Exception(sprintf("Table `%s` does not exist!", $table));
                }
                if (! in_array($table, $param->getTables())) {
                    throw new \Exception(sprintf("Table `%s` is not available in this query!", $table));
                }
                // Verify Source columns exists
                if (! $param->columnExists($table, $column)) {
                    throw new \Exception(sprintf("Column `%s`.`%s` does not exist!", $table, $column));
                }
                
                $list[] = sprintf("`%s`.`%s`", $table, $column);
            } else {
                // Check if column is specified in current columns
                if (! (in_array($column, $columns) || in_array(sprintf("%s.%s", $table, $column), $columns))) {
                    // Error message
                    $message = "Column `%s`.`%s` is not available in this query!";
                    $message = sprintf($message, $table, $column);
                    // Error throw
                    throw new \Exception($message);
                } else {}
                // Add column to the list
                $list[] = sprintf("`%s`", $column);
            }
        }
        // Create result
        $result = sprintf("GROUP BY %s", implode(", ", $list)) . PHP_EOL;
        // Return result
        return $result;
    }

    /**
     * Creates the JOIN part in the Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function createJoins(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if JOIN can be used with the current command
        if ((Config::PDO_JOIN & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Check if JOINS is not null and has items
        if ($param->getJoins() === null || count($param->getJoins()) == 0) {
            // No inner joins defined
            return "";
        }
        // Create the result variable
        $result = '';
        // Load all JOINS
        $joins = $param->getJoins();
        // Loop throuhg all parameters
        foreach ($joins as $join) {
            // Pars the JOIN to syntax
            $result .= self::parseJoin($join);
        }
        // Place indentation and return result
        return preg_replace("/^./m", "$0", trim($result)) . PHP_EOL;
    }

    /**
     * Creates the LIMIT part in the Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function createLimit(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if LIMIT can be used with the current command
        if ((Config::PDO_LIMIT & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Get parameter limit
        $limit = $param->getLimit();
        // Check if limit is defined
        if ($limit === null) {
            return "";
        }
        // Determine if start posisition can be used or is 0
        if ($limit->getStart() == 0 || $param->getCommand() == "DELETE") {
            // Limit ITEMS
            return sprintf("LIMIT %s" . PHP_EOL, $limit->getItems());
        } else {
            // Limit START,ITEMS
            return sprintf("LIMIT %s, %s" . PHP_EOL, $limit->getStart(), $limit->getItems());
        }
    }

    /**
     * Creates the ORDER BY part in the Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function createOrderBy(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if ORDER BY can be used with the current command
        if ((Config::PDO_ORDERBY & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Load ORDERS
        $orders = $param->getOrder();
        // Check if ORDER BY is not null and has items
        if ($orders === null || count($orders) == 0) {
            // No ordering
            return "";
        }
        $list = array();
        // Loop throuhg all parameters
        foreach ($orders as $order) {
            $table = $order->getTable();
            $column = $order->getColumn();
            $asc = $order->isAscending();
            // Check if multiple tables are used
            if ($mTables) {
                // use `table`.`column` ASC|DESC
                $list[] = sprintf("`%s`.`%s` %s", $table, $column, ($asc ? "ASC" : "DESC"));
            } else {
                // use `column` ASC|DESC
                $list[] = sprintf("`%s` %s", $column, ($asc ? "ASC" : "DESC"));
            }
        }
        // Return result
        return sprintf("ORDER BY %s", implode(", ", $list)) . PHP_EOL;
    }

    /**
     * Creates the SELECT part in the Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @throws \Exception
     *
     * @return string
     */
    private static function createSelect(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if SELECT can be used with the current command
        if ((Config::PDO_SELECT & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Load all columns to be returned
        $pcolumns = $param->getColumns();
        // Load table name
        $rootTable = $param->getTable();
        // Check if multiple tables are used
        if ($mTables !== true) {
            // Check if only 1 columns is defined and its '*'
            if (count($pcolumns) == 1 && $pcolumns[0] == "*") {
                // Loop through all columns
                foreach (explode(',', $param->getDbTables()[$param->getTable()]) as $column) {
                    $columns[] = $column;
                }
                if ($param->isDistinct()) {
                    throw new \Exception("When using DISTINCT, columns must be defined!");
                }
                // Show ALL columns
                return sprintf("SELECT *%sFROM `%s`", PHP_EOL . "\t", $rootTable) . PHP_EOL;
            } else {
                // loop through columns to be shown
                foreach ($pcolumns as $column) {
                    // Verify colum exists
                    if (! $param->columnExists($rootTable, $column)) {
                        // Column does not exist
                        throw new \Exception(sprintf("column `%s`.`%s` does not exist!", $rootTable, $column));
                    }
                }
                $columns = $pcolumns;
                // Return result
                return sprintf(
                    "SELECT %s`%s` %sFROM `%s`",
                    $param->isDistinct() ? "DISTINCT " : "",
                    implode('`, `', $pcolumns),
                    PHP_EOL,
                    $rootTable) . PHP_EOL;
            }
        } else {
            // Multiple tables are used, fully named columns are now required
            $result = "SELECT" . PHP_EOL . "\t";
            // Create Column list for ALIAS defining
            $tableColumns = array();
            // Check if only 1 columns is defined and its '*'
            if (count($pcolumns) == 1 && $pcolumns[0] == "*") {
                if ($param->isDistinct()) {
                    throw new \Exception("When using DISTINCT, columns must be defined!");
                }
                // Show ALL columns, Loop through all tables
                foreach ($param->getTables() as $table) {
                    // Loop through all columns
                    foreach (explode(',', $param->getDbTables()[$table]) as $column) {
                        // Add new column with alias
                        $tableColumns[] = sprintf("`%s`.`%s` as `%s`", $table, $column, self::prependTableName($column, $table, $param->getPrefix()));
                        // Store used column(s)
                        $columns[] = $table . \SmartPDO\Config::$tableAliasSeparator . $column;
                    }
                }
            } else {
                if ($param->isDistinct()) {
                    $result = "SELECT DISTINCT" . PHP_EOL . "\t";
                }
                // Show specified columns, loop through all columns
                foreach ($pcolumns as $column) {
                    // to explode the column name
                    $tmp = explode(Config::$tableAliasSeparator, $column);
                    // Load table name, if specifyd else root table
                    $tmpTable = isset($tmp[1]) ? $param->getPrefix() . $tmp[0] : $rootTable;
                    // Load table column
                    $tmpColumn = isset($tmp[1]) ? $tmp[1] : $tmp[0];
                    // Verify Source table exists
                    if (! $param->tableExists($tmpTable)) {
                        throw new \Exception(sprintf("Table `%s` does not exist!", $tmpTable));
                    }
                    if (! in_array($tmpTable, $param->getTables())) {
                        throw new \Exception(sprintf("Table `%s` is not available in this query!", $tmpTable));
                    }
                    // Verify Source columns exists
                    if (! $param->columnExists($tmpTable, $tmpColumn)) {
                        throw new \Exception(sprintf("Column `%s`.`%s` does not exist!", $tmpTable, $tmpColumn));
                    }
                    // Add new column with alias
                    $tableColumns[] = sprintf(
                        "`%s`.`%s` as `%s`",
                        $tmpTable,
                        $tmpColumn,
                        self::prependTableName($tmpColumn, $tmpTable, $param->getPrefix()));
                    // Store used column(s)
                    $columns[] = $tmpTable . \SmartPDO\Config::$tableAliasSeparator . $column;
                }
            }
            // Add each table column in a seperate line
            $result .= implode(sprintf(",%s\t", PHP_EOL), $tableColumns) . PHP_EOL;
            // Add FROM table
            $result .= sprintf("FROM `%s`" . PHP_EOL, $param->getTable());
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
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function createUpdate(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if UPDATE can be used with the current command
        if ((Config::PDO_UPDATE & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Check if SET's is not null and has items
        if ($param->getSet() === null || count($param->getSet()) == 0) {
            // Nothing to be inserted
            $message = "Update requires values in order to UPDATE, none given";
            throw new \Exception($message);
        }
        $result = sprintf( "UPDATE `%s` SET" . PHP_EOL . "\t", $param->getTable());
        // Create empty Add Values
        $addValues = array();
        // Loop throuhg all WHERE parameters
        $parameters = $param->getSet();
        $last = end($parameters);
        foreach ($parameters as $s) {
        	$result .= sprintf("`%s` = ", $s->getColumn());

        	/**
        	 *
        	 * @var \SmartPDO\Parameters\WhereLogic $w
        	 */
        	switch (strtolower(get_class($s))) {
        		
        		case 'smartpdo\parameters\set':
        			$result .= "?";
        			break;
        			
        		case 'smartpdo\parameters\mod':
        			/**
        			 * @var \SmartPDO\Parameters\Mod $s
        			 */
        			$result .= sprintf("`%s` %s ?", $s->getColumn(), $s->getOperator() );
        			break;
        			
        		default:
        			throw new \Exception(get_class($s) . ' is not configured');
        			break;
        	}
        	if( $s!=$last){
        		$result .= "," . PHP_EOL . "\t";        		
        	}
        	
        	$addValues[] = $s->getValue();

        }
        // Add all values for the prepared statement
        $values = array_merge($values, $addValues);
        
        $result .= PHP_EOL;
        return $result;
            
    }

    /**
     * Creates the WHERE part in the Query
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters $param
     *            The Sql parameters
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @throws \Exception
     *
     * @return string
     */
    private static function createWhere(\SmartPDO\Parameters $param, array &$values, array &$columns, bool $mTables)
    {
        // Check if WHERE can be used with the current command
        if ((Config::PDO_WHERE & Config::commandList[$param->getCommand()]) == 0) {
            return "";
        }
        // Create the result variable
        $result = sprintf("WHERE %s\t( ", PHP_EOL);
        // Check if WHERE is not null and has items
        if ($param->getWhere() === null || count($param->getWhere()) == 0) {
            // Load all results
            return "WHERE 1" . PHP_EOL;
        }
        // Flag for if an OR/ANDn group has been placed
        $placeLogic = true;
        $depth = 1;
        // Loop throuhg all WHERE parameters
        $parameters = $param->getWhere();
        foreach ($parameters as $i => $w) {
            // Handle OR statements starting after first parameters
            if ($i > 0) {
                // Parameter must be an object!
                if (! is_object($w)) {
                    throw new \Exception("'" . $w[0] . "' is not configured as Class");
                }
                if ($placeLogic == true) {
                    $skip = array();
                    $skip[] = strtolower("SmartPDO\Parameters\Group");
                    
                    if (! in_array(strtolower(get_class($w)), $skip)) {
                        $result .= sprintf(" %s ", $w->isAnd() ? "AND" : "OR");
                    }
                } else {
                    // Reset OR flag
                    $placeLogic = true;
                }
            }
            if (is_object($w)) {
                if (! is_subclass_of($w, '\SmartPDO\Parameters\WhereLogic')) {
                    $message = "Object is given but not extended by '%s' ";
                    $message = sprintf($message, '\SmartPDO\Parameters\WhereLogic');
                    throw new \Exception($message);
                }
                /**
                 *
                 * @var \SmartPDO\Parameters\WhereLogic $w
                 */
                switch (strtolower(get_class($w))) {
                    
                    case "smartpdo\parameters\group":
                        $op = $w->isAnd() ? "AND" : "OR";
                        $result .= sprintf(" ) %s%s%s( ", $op, PHP_EOL, str_repeat("\t", $depth));
                        $placeLogic = false;
                        break;
                    
                    case "smartpdo\parameters\where":
                        $result .= self::parseWhere($w, $values, $columns, $mTables);
                        break;
                    
                    case "smartpdo\parameters\where\between":
                        $result .= self::parseWhereBetween($w, $values, $columns, $mTables);
                        break;
                    
                    case "smartpdo\parameters\where\in":
                        $result .= self::parseWhereIn($w, $values, $columns, $mTables);
                        break;
                    
                    case "smartpdo\parameters\where\like":
                        $result .= self::parseWhereLike($w, $values, $columns, $mTables);
                        break;
                    
                    default:
                        throw new \Exception(get_class($w) . ' is not configured');
                        break;
                }
            } else {
                
                // Checking what to do: WHERE, WHEREIN, LIKE etc.
                switch ($w[0]) {
                    case "IN":
                        if (self::$multipleTables == true) {
                            $result .= sprintf(
                                "`%s`.`%s` %sIN (%s)",
                                $w[1],
                                $w[2],
                                $w[4] != true ? "" : "NOT ",
                                implode(', ', array_fill(0, count($w[3]), "?")));
                            $this->values = array_merge($this->values, $w[3]);
                        } else {
                            $result .= sprintf("`%s` %sIN (%s)", $w[2], $w[4] != true ? "" : "NOT ", implode(', ', array_fill(0, count($w[3]), "?")));
                            $this->values = array_merge($this->values, $w[3]);
                        }
                        break;
                    
                    case "LIKE":
                        if (self::$multipleTables == true) {
                            $result .= sprintf("`%s`.`%s` %sLIKE ?", $w[1], $w[2], $w[4] == true ? 'NOT ' : '');
                        } else {
                            $result .= sprintf("`%s` %sLIKE ?", $w[2], $w[4] == true ? 'NOT ' : '');
                        }
                        $this->values[] = $w[3];
                        
                        if ($w[5] != "!") {
                            $result .= " ESCAPE ?";
                            $this->values[] = $w[5];
                        }
                        break;
                    
                    default:
                        throw new \Exception($w[0] . ' is not configured');
                        break;
                }
            }
        }
        // Trim result
        
        $result .= " )";
        $result = trim($result);
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
     *            Table column name
     * @param string $table
     *            table name
     * @param string $prefix
     *            Database tables prefix
     *            
     * @return string
     */
    private static function prependTableName(string $column, string $table, string $prefix)
    {
        return substr($table, strlen($prefix)) . Config::$tableAliasSeparator . $column;
    }

    /**
     * Parse JOIN to valid syntax
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters\Join $join
     *            Join Parameter to be parsed
     *            
     * @return string
     */
    private static function parseJoin(\SmartPDO\Parameters\Join $join)
    {
        // Load parameters
        $type = $join->getType();
        $tl = $join->getTableLeft();
        $cl = $join->getColumnLeft();
        $tr = $join->getTableRight();
        $cr = $join->getColumnRight();
        $com = $join->getComparison();
        
        // Result variable
        $result = "";
        
        // Add: [INNER LEFT RIGHT] JOIN `table`
        $result .= sprintf("%s `%s`%s", $type, $tr, PHP_EOL);
        // Add: on `table`.`column` = `table2`.`column2`
        $result .= sprintf("\tON `%s`.`%s` %s `%s`.`%s`" . PHP_EOL, $tl, $cl, $com, $tr, $cr);
        // Return syntax
        return $result;
    }

    /**
     * Parse WHERE to valid syntax
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters\Where $where
     *            Where Parameter to be parsed
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function parseWhere(\SmartPDO\Parameters\Where $where, array &$values, array &$columns, bool $mTables)
    {
        // Load parameters
        $table = $where->getTable();
        $column = $where->getColumn();
        $comparison = $where->getComparison();
        $value = $where->getValue();
        
        // Result variable
        $result = "";
        
        // Check if multiple tables are used due to JOINS
        if ($mTables == true) {
            // Add table name
            $result .= sprintf("`%s`.", $table);
        }
        
        // Check if value is NULL
        if ($value === NULL) {
            // IS NULL syntax
            $result .= sprintf("`%s` IS %sNULL", $column, $comparison === "=" ? "" : "NOT ");
        } else {
            // Comparison syntax
            $result .= sprintf("`%s` %s ?", $column, $comparison);
            // Add value
            $values[] = $where->getValue();
        }
        // Return syntax
        return $result;
    }

    /**
     * Parse WHERE BETWEEN to valid syntax
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Parameters\Where\Between $between
     *            Between parameter to be parsed
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function parseWhereBetween(\SmartPDO\Parameters\Where\Between $between, array &$values, array &$columns, bool $mTables)
    {
        // Load parameters
        $table = $between->getTable();
        $column = $between->getColumn();
        $start = $between->getStart();
        $stop = $between->getStop();
        $not = $between->isNot();
        
        // Result variable
        $result = "";
        
        // Check if start/stop is DateTime: Convert
        if (is_object($start) && get_class($start) == "DateTime") {
            $start = $start->format("Y-m-d H:i:s");
            $stop = $stop->format("Y-m-d H:i:s");
        }
        
        // Check if multiple tables are used due to JOINS
        if ($mTables == true) {
            // Add table name
            $result .= sprintf("`%s`.", $table);
        }
        
        // Add start/stop values
        $values[] = $start;
        $values[] = $stop;
        
        // Create BETWEEN syntax
        $result .= sprintf("`%s` %sBETWEEN ? AND ?", $column, $not ? 'NOT ' : '');
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
     *            WhereIn parameter to be parsed
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function parseWhereIn(\SmartPDO\Parameters\Where\In $in, array &$values, array &$columns, bool $mTables)
    {
        // Load parameters
        $table = $in->getTable();
        $column = $in->getColumn();
        
        // Result variable
        $result = "";
        
        // Check if multiple tables are used due to JOINS
        if ($mTables == true) {
            // Add table name
            $result .= sprintf("`%s`.", $table);
        }
        
        // register values
        $values = array_merge($values, array_values($in->getValues()));
        // Create prepared ? values for query
        $fill = implode(", ", array_fill(0, count($in->getValues()), "?"));
        // Finish syntax
        $result .= sprintf("`%s` %sIN (%s)", $column, $in->isNot() ? "NOT " : "", $fill);
        // Return syntax
        return $result;
    }

    /**
     * Parse WHERE LIKE to valid syntax
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     * @param \SmartPDO\Parameters\Where\Like $like
     *            Where like parameter to be parsed
     * @param array $values
     *            values to replace all '?'
     * @param array $columns
     *            columns which will be retrieved
     * @param bool $mTables
     *            Multiple tables or not
     *            
     * @return string
     */
    private static function parseWhereLike(\SmartPDO\Parameters\Where\Like $like, &$values, &$columns, $mTables)
    {
        // Load parameters
        $table = $like->getTable();
        $column = $like->getColumn();
        $escape = $like->getEscape();
        
        // Result variable
        $result = "";
        
        // Check if multiple tables are used due to JOINS
        if ($mTables == true) {
            // Add table name
            $result .= sprintf("`%s`.", $table);
        }
        // Add columns and statement
        $result .= sprintf("`%s` %sLIKE ?", $column, $like->isNot() ? "NOT " : "");
        $values[] = $like->getValue();
        
        // override ESCAPE character if different
        if ($escape != '!') {
            // $result .= sprintf ( " ESCAPE '%s'", $escape );
            $result .= " ESCAPE ?";
            $values[] = $escape;
        }
        
        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @return NULL|number|string
     */
    public function getInsertedID()
    {
        return ($this->parameters->getCommand() != 'INSERT' ? null : $this->insertedID);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @return string
     */
    public function getQuery()
    {
        // Query command must be SELECT
        return $this->sth->queryString;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @throws \Exception
     * @return array
     */
    public function getRows()
    {
        // Data can only be fetched once, return cached rows
        if ($this->rows != null) {
            return $this->rows;
        }
        // Query command must be SELECT
        if ($this->parameters->getCommand() != 'SELECT') {
            return null;
        }
        // Check if multiple tables are used
        if ($this->multipleTables === true && Config::$multiArrayRows === true) {
            // Create temp rows and tables
            $rows = array();
            $tables = array();
            // Loop through all rows
            foreach ($this->sth->fetchAll() as $key => $values) {
                // Check if tables are detected
                if (count($tables) == 0) {
                    // Loop through all keys ( columns )
                    foreach (array_keys($values) as $c) {
                        // split the string with the table separotor in the Config
                        $tmp = explode(Config::$tableAliasSeparator, $c);
                        // Check if table is not already defined
                        if (! isset($tables[$tmp[0]])) {
                            // Define table name
                            $tables[$tmp[0]] = array();
                        }
                    }
                }
                // Check if row keys ( copy of table ) does not exist
                if (! isset($rows[$key])) {
                    // Copy tables to the row ( only keys ) no filling
                    $rows[$key] = $tables;
                }
                // Loop through all values
                foreach ($values as $column => $value) {
                    // split the string with the table separotor in the Config
                    $tmp = explode(Config::$tableAliasSeparator, $column);
                    // Fill : [ROW] [Table] [COLUMN] = Value
                    $rows[$key][$tmp[0]][$tmp[1]] = $value;
                    // var_dump($tmp);
                }
            }
            // Overwrite rows
            $this->rows = $rows;
        } else {
            // Get and store the rows
            $this->rows = $this->sth->fetchAll();
        }
        // Return all rows
        return $this->rows;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @return int
     */
    public function getTotalRows()
    {
        return $this->tableRows;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @throws \Exception
     * @return number
     */
    public function rowCount()
    {
        return $this->rowCount;
    }
}