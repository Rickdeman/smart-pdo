<?php

/**
 * File: Table.php
 */
namespace SmartPDO\Interfaces;

/**
 * Interface for all SmartPDO Table handlers
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 */
interface Table
{

    /**
     * Mysql table constructor
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param \SmartPDO\Interfaces\Database $db
     *            SmartPDO Databse Database object
     * @param string $table
     *            Selected table name
     */
    function __Construct(\SmartPDO\Interfaces\Database $db, string $table);

    /**
     * add (AND) BETWEEN
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
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
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function between(string $column, $start, $stop, bool $not = false, string $table = null);

    /**
     * Set columns to be selected
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $columns
     *            Columns to be shown, fully named when using JOIN(s)
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function columns(string ...$columns);

    /**
     * Add an Ddecrement value setter
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *     
     * @param string $column
     *            Column name
     * @param float $dec
     * 			  value to be decremented by
     *
     * @return \SmartPDO\Interfaces\Table
     */
    public function decrement(string $column, float $dec = 1);
    
    /**
     * Creates a DELETE query
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return \SmartPDO\Interfaces\Table
     */
    public function delete();

    /**
     * Enable DISTINCT for a WHERE query, columns must be defined!
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return \SmartPDO\Interfaces\Table
     */
    public function distinct();

    /**
     * Execute query with created parameters
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return \SmartPDO\Interfaces\Rows
     */
    public function execute();

    
    /**
     * Return all active columns for querys
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string[]
     */
    public function getColumns();
    
    /**
     * Return the PDO object
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return \SmartPDO\Interfaces\Database
     */
    public function getDb();

    /**
     * Return the root table
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string
     */
    public function getTable();

    /**
     * Return all available tables for querys
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string[]
     */
    public function getTables();

    /**
     * create a AND/OR group
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param bool $and
     *            True for an AND group otherwise OR
     */
    public function group(bool $and = false);

    /**
     * Add GROUP BY
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * @param string $column
     *            Column to be sorted by
     * @param string $table
     *            Target table, NULL for root table
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function groupBy(string $column, string $table = null);

    /**
     * Add (AND) IN
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * @param string $column
     *            Column name
     * @param array $list
     *            (multiple) strings for WHERE IN
     * @param bool $not
     *            Whether is must be in the list or not
     * @param string $table
     *            Target table, NULL for root table
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function in(string $column, array $list, bool $not = false, string $table = null);

    /**
     * Add an Incremental value setter
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *     
     * @param string $column
     *            Column name
     * @param float $inc
     * 			  value to be incremented by
     * @param string $table
     *            Target table, NULL for root table
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function increment(string $column, float $inc = 1);
    
    /**
     * Add INNER JOIN
     *
     * @version 1.1
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
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function innerJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=');

    /**
     * Add INNER JOIN
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function innerJoin2(string $columnLeft, string $tableRight, string $comparison = '=');

    /**
     * Add INNER JOIN
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function innerJoin3(string $tableRight, string $comparison = '=');

    /**
     * Create an INSERT query
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return \SmartPDO\Interfaces\Table
     */
    public function insert();

    /**
     * Add LEFT JOIN
     *
     * @version 1.1
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
     *            
     * @return \SmartPDO\Interfaces\Table*
     */
    public function leftJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=');

    /**
     * Add LEFT JOIN
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function leftJoin2(string $columnLeft, string $tableRight, string $comparison = '=');

    /**
     * Add LEFT JOIN
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function leftJoin3(string $tableRight, string $comparison = '=');

    /**
     * add LIKE
     *
     * @author Rick de Man <rick@rickdeman.nl>
     * @version 1.1
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
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function like(string $column, $value, bool $not = false, string $table = null, string $escape = "!");

    /**
     * Add LIMIT
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param int $items
     *            The maximum amount of rows to fetch
     * @param int $start
     *            The start index
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function limit(int $items, int $start = 0);

    /**
     * Add ORDER BY
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            Column to be sorted by
     * @param bool $asc
     *            True for ascending, false for descending
     * @param string $table
     *            Target table, NULL for root table
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function orderBy(string $column, bool $asc = true, string $table = null);

    /**
     * Add RIGHT JOIN
     *
     * @version 1.1
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
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function rightJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=');

    /**
     * Add RIGHT JOIN
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $columnLeft
     *            Source table column
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function rightJoin2(string $columnLeft, string $tableRight, string $comparison = '=');

    /**
     * Add RIGHT JOIN
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableRight
     *            Target table
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function rightJoin3(string $tableRight, string $comparison = '=');

    /**
     * Create an SELECT query, default
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return \SmartPDO\Interfaces\Table
     */
    public function select();

    /**
     * Add SET
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            table column
     * @param mixed $value
     *            Value to be updated
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function set(string $column, $value);

    /**
     * Set the AND to OR for single time
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param integer $times
     *            The number of times a OR is requested
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function setOr(int $times = 1);

    /**
     * Create an UPDATE query
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return \SmartPDO\Interfaces\Table
     */
    public function update();

    /**
     * Add key value for inserting
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            table column
     * @param string|integer $value
     *            Value to be inserted
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function value(string $column, $value);

    /**
     * Add (AND) WHERE comparison
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            Columns name
     * @param mixed $value
     *            Value to match, use NULL for 'IS NULL'
     * @param string $comparison
     *            Comparision action, when value is NULL, use = or !=
     * @param string $table
     *            Specified table, NULL for root table
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function where(string $column, $value, string $comparison = '=', string $table = null);
}