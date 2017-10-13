<?php

/**
 * File: Table.php
 */
namespace SmartPDO\MySQL;

/**
 * MySQL Table handler
 *
 * @author Rick de Man <rick@rickdeman.nl>
 * @version 1
 */
class Table implements \SmartPDO\Interfaces\Table
{

    /**
     * Flag for AND/OR, must be reset after each use!
     *
     * @var string
     */
    private $and = true;

    /**
     * Mysql class
     *
     * @var \SmartPDO\MySQL
     */
    private $mysql;

    /**
     * Number of times a OR should be placed
     *
     * @var integer
     */
    private $ors = 0;

    /**
     * Holds the parameter set for building querys
     *
     * @var \SmartPDO\Parameters
     */
    private $parameters;

    /**
     * Requestes table name without prefix
     *
     * @var string
     */
    private $tableName;

    /**
     * Contructor for the MySQL Table handler
     *
     * @author Rick de Man <rick@rickdeman.nl>
     * @version 1
     * @param \SmartPDO\Interfaces\Database $db
     *            SmartPDO Database Object
     * @param string $table
     *            Full table name
     */
    function __Construct(\SmartPDO\Interfaces\Database $db, string $table)
    {
        $this->parameters = new \SmartPDO\Parameters($db->getTables());
        
        // Store parameters
        $this->parameters->registerPrefix($db->getPrefix());
        $this->parameters->registerTable($table);
        $this->parameters->registerCommand("SELECT");
        
        // Store SmartPDO ( is interface )
        $this->mysql = $db;
        
        // Store table name without prefix
        $this->tableName = substr($table, strlen($db->getPrefix()));
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $column
     *            table column
     * @param double|int|\DateTime|string $start
     *            Start value
     * @param double|int|\DateTime|string $stop
     *            End value
     * @param bool $not
     *            Whether is must be in the list or not
     * @param string $table
     *            Target table, NULL for root table
     * @return \SmartPDO\MySQL\Table
     */
    public function between(string $column, $start, $stop, bool $not = false, string $table = null)
    {
        // Get tablename
        $tbl = $this->mysql->getTableName($table != null ? $table : $this->tableName);
        // Register dataset WHERE BETWEEN
        $this->parameters->registerWhereBetween($column, $start, $stop, $not, $tbl, $this->ors == 0);
        // Decrease OR counter if possible
        if ($this->ors > 0) {
            $this->ors --;
        }
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $columns
     *            Columns to be shown, fully named when using JOIN(s)
     * @return \SmartPDO\MySQL\Table
     */
    public function columns(string ...$columns)
    {
        // Register all columns
        $this->parameters->registerColumns(...$columns);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function delete()
    {
        // Register as DELETE command
        $this->parameters->registerCommand("DELETE");
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \SmartPDO\Interfaces\Table::distinct()
     *
     */
    public function distinct()
    {
        // Enable Distinct mode
        $this->parameters->setDistinct();
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @return \SmartPDO\MySQL\Table\Rows
     */
    public function execute()
    {
        return new \SmartPDO\MySQL\Table\Rows($this->mysql, $this->parameters);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \SmartPDO\Interfaces\Table::getDb()
     *
     * @return \SmartPDO\Interfaces\Database
     */
    public function getDb()
    {
        return $this->mysql;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \SmartPDO\Interfaces\Table::getTable()
     *
     * @return string
     */
    public function getTable()
    {
        return $this->tableName;
    }

    /**
     * Return all available tables for querys
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string[]
     */
    public function getTables()
    {
        return $this->parameters->getTables();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param bool $and
     *            True for an AND group otherwise OR
     */
    public function group(bool $and = false)
    {
        $this->parameters->registerGroup($and === true);
        // Set the and according to argument
        $this->and = $and === true;
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $column
     *            Column to be sorted by
     * @param string $table
     *            Target table, NULL for root table
     * @return \SmartPDO\MySQL\Table
     */
    public function groupBy(string $column, string $table = null)
    {
        // Get the tablename
        $tbl = $this->mysql->getTableName($table != null ? $table : $this->tableName);
        // Register GROUP BY
        $this->parameters->registerGroupBy($column, $tbl);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $column
     *            Column name
     * @param array $list
     *            (multiple) strings|numbers for WHERE IN
     * @param bool $not
     *            Whether is must be in the list or not
     * @param string $table
     *            Target table, NULL for master table
     * @return \SmartPDO\MySQL\Table
     */
    public function in(string $column, array $list, bool $not = false, string $table = null)
    {
        // Get tablename
        $tbl = $this->mysql->getTableName($table != null ? $table : $this->tableName);
        // Register dataset WHERE IN
        $this->parameters->registerWhereIn($column, $list, $not, $tbl, $this->ors == 0);
        // Decrease OR counter if possible
        if ($this->ors > 0) {
            $this->ors --;
        }
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableLeft
     *            Source table name
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $columnRight
     *            Target table column
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->innerJoin ( 'licences', 'customerID', 'customer', 'ID' ); <br>
     *          <br>
     *          Will result in:<br>
     *          INNER JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     *         
     */
    public function innerJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "INNER JOIN",
            $this->mysql->getTableName($tableLeft),
            $columnLeft,
            $this->mysql->getTableName($tableRight),
            $columnRight,
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->innerJoin2 ( 'customerID', 'customer' ); <br>
     *          <br>
     *          Will result in:<br>
     *          INNER JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     */
    public function innerJoin2(string $columnLeft, string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "INNER JOIN",
            $this->mysql->getTableName($this->tableName),
            $columnLeft,
            $this->mysql->getTableName($tableRight),
            "ID",
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->innerJoin3 ( 'customer' ); <br>
     *          <br>
     *          Will result in:<br>
     *          INNER JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     *         
     */
    public function innerJoin3(string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "INNER JOIN",
            $this->mysql->getTableName($this->tableName),
            $tableRight . "ID",
            $this->mysql->getTableName($tableRight),
            "ID",
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function insert()
    {
        // Register as INSERT command
        $this->parameters->registerCommand("INSERT");
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $tableLeft
     *            Source table name
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $columnRight
     *            Target table column
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->leftJoin ( 'licences', 'customerID', 'customer', 'ID' ); <br>
     *          <br>
     *          Will result in:<br>
     *          LEFT JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     */
    public function leftJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "LEFT JOIN",
            $this->mysql->getTableName($tableLeft),
            $columnLeft,
            $this->mysql->getTableName($tableRight),
            $columnRight,
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->leftJoin2 ( 'customerID', 'customer' ); <br>
     *          <br>
     *          Will result in:<br>
     *          LEFT JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     */
    public function leftJoin2(string $columnLeft, string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "LEFT JOIN",
            $this->mysql->getTableName($this->tableName),
            $columnLeft,
            $this->mysql->getTableName($tableRight),
            "ID",
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->leftJoin3 ( 'customer' ); <br>
     *          <br>
     *          Will result in:<br>
     *          LEFT JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     */
    public function leftJoin3(string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "LEFT JOIN",
            $this->mysql->getTableName($this->tableName),
            $tableRight . "ID",
            $this->mysql->getTableName($tableRight),
            "ID",
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $column
     *            Column name
     * @param mixed $value
     *            Value to be compared
     * @param bool $not
     *            if true will change to LIKE NOT
     * @param string|null $table
     *            Table name, null for root table
     * @param string $escape
     *            Escape character, which can be changed
     * @return \SmartPDO\MySQL\Table
     *
     */
    public function like(string $column, $value, bool $not = false, string $table = null, string $escape = "!")
    {
        // Get tablename
        $tbl = $this->mysql->getTableName($table != null ? $table : $this->tableName);
        // Register dataset WHERE LIKE
        $this->parameters->registerWhereLike($column, $value, $not, $tbl, $escape, $this->ors == 0);
        // Decrease OR counter if possible
        if ($this->ors > 0) {
            $this->ors --;
        }
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param int $items
     *            The maximum amount of rows to fetch
     * @param int $start
     *            The start index
     * @return \SmartPDO\MySQL\Table
     */
    public function limit(int $items, int $start = 0)
    {
        // Register LIMIT parameters
        $this->parameters->registerLimit($items, $start);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $column
     *            Column to be sorted by
     * @param bool $asc
     *            True for ascending, false for descending
     * @param string $table
     *            Target table, NULL for master table
     * @return \SmartPDO\MySQL\Table
     */
    public function orderBy(string $column, bool $asc = true, string $table = null)
    {
        $table = $this->mysql->getTableName($table != null ? $table : $this->tableName);
        $this->parameters->registerOrderBy($column, $asc, $table);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $tableLeft
     *            Source table name
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $columnRight
     *            Target table column
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     *            
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->rightJoin ( 'licences', 'customerID', 'customer', 'ID' ); <br>
     *          <br>
     *          Will result in:<br>
     *          RIGHT JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     */
    public function rightJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "RIGHT JOIN",
            $this->mysql->getTableName($tableLeft),
            $columnLeft,
            $this->mysql->getTableName($tableRight),
            $columnRight,
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->rightJoin2 ( 'customerID', 'customer' ); <br>
     *          <br>
     *          Will result in:<br>
     *          RIGHT JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     */
    public function rightJoin2(string $columnLeft, string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "RIGHT JOIN",
            $this->mysql->getTableName($this->tableName),
            $columnLeft,
            $this->mysql->getTableName($tableRight),
            "ID",
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @return \SmartPDO\MySQL\Table
     *
     * @example <code>
     *          $MySQL->getTable ( 'licences' )->rightJoin3 ( 'customer' ); <br>
     *          <br>
     *          Will result in:<br>
     *          RIGHT JOIN [licences] ON [licences].[customerID] = [customer].[ID] <br>
     *          </code>
     */
    public function rightJoin3(string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "RIGHT JOIN",
            $this->mysql->getTableName($this->tableName),
            $tableRight . "ID",
            $this->mysql->getTableName($tableRight),
            "ID",
            $comparison);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function select()
    {
        // Register as INSERT command
        $this->parameters->registerCommand("SELECT");
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $column
     *            table column
     * @param mixed $value
     *            Value to be updated
     *            
     * @return \SmartPDO\MySQL\Table
     */
    public function set(string $column, $value)
    {
        // Add update SET
        $this->parameters->registerSet($column, $value);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param integer $times
     *            The number of times a OR is requested
     *            
     * @return \SmartPDO\MySQL\Table
     */
    public function setOr(int $times = 1)
    {
        if ($times < 1) {
            throw new \Exception("times must be at least 1!");
        }
        // set the counter for OR('s)
        $this->ors = $times;
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function update()
    {
        // Register as UPDATE command
        $this->parameters->registerCommand("UPDATE");
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $column
     *            table column
     * @param string|integer $value
     *            Value to be inserted
     * @return \SmartPDO\MySQL\Table
     */
    public function value(string $column, $value)
    {
        // Register new INSERT key value
        $this->parameters->registerInsert($column, $value);
        // Return current object
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param string $column
     *            Columns name
     * @param mixed $value
     *            Value to compare, use NULL for 'IS NULL'
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @param string $table
     *            Specified table, NULL for master table
     * @return \SmartPDO\MySQL\Table
     */
    public function where(string $column, $value, string $comparison = '=', string $table = null)
    {
        // Get tablename
        $tbl = $this->mysql->getTableName($table != null ? $table : $this->tableName);
        // Register dataset WHERE
        $this->parameters->registerWhere($tbl, $column, $comparison, $value, $this->ors == 0);
        // Decrease OR counter if possible
        if ($this->ors > 0) {
            $this->ors --;
        }
        // Return current object
        return $this;
    }
}