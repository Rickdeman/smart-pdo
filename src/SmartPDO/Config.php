<?php

/**
 * File: Config.php
 */
namespace SmartPDO;

/**
 * Smart PDO configuration
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *        
 */
class Config
{

    /**
     * Return MultiArray rows when using JOINS: ( [table][column] = value ), otherwise [tableColumn] = value
     *
     * @see $tableAliasSeparator
     *
     * @var bool
     */
    public static $multiArrayRows = true;

    /**
     * Whether the SmartPDO has read-only or read-write acces
     *
     * Used for testing/development
     *
     * @var string
     */
    public static $readOnly = false;

    /**
     * Default multi table seperator: table.column, change if required
     *
     * @var string
     */
    public static $tableAliasSeparator = ".";

    /**
     * Array of commands with permissions flags
     *
     * @var array
     */
    const commandList = array(
        'SELECT' => self::PDO_SELECT | self::PDO_DISTINCT | self::PDO_JOIN | self::PDO_LIMIT | self::PDO_ORDERBY | self::PDO_WHERE | Config::PDO_GROUPBY,
        'UPDATE' => self::PDO_WRITE | self::PDO_UPDATE | self::PDO_WHERE | self::PDO_LIMIT,
        'INSERT' => self::PDO_WRITE | self::PDO_INSERT,
        'DELETE' => self::PDO_WRITE | self::PDO_DELETE | self::PDO_WHERE | self::PDO_ORDERBY | self::PDO_LIMIT
    );

    /**
     * Available compare methods
     *
     * @var array
     */
    const compareList = array(
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
    const JoinList = array(
        "INNER JOIN",
        "LEFT JOIN",
        "RIGHT JOIN"
    );

    /**
     * Flag for DELETE permissions
     *
     * @var INT
     */
    const PDO_DELETE = 0b000000000001;

    /**
     * Flag for DELETE permissions
     *
     * @var INT
     */
    const PDO_DISTINCT = 0b000000000010;

    /**
     * Flag for GROUP BY permissions
     *
     * @var int
     */
    const PDO_GROUPBY = 0b000000000100;

    /**
     * Flag for INSERT permissions
     *
     * @var INT
     */
    const PDO_INSERT = 0b000000001000;

    /**
     * Flag for join permissions
     *
     * @var INT
     */
    const PDO_JOIN = 0b000000010000;

    /**
     * Flag for LIMIT permissions
     *
     * @var INT
     */
    const PDO_LIMIT = 0b000000100000;

    /**
     * Flag for ORDER BY permissions
     *
     * @var INT
     */
    const PDO_ORDERBY = 0b000001000000;

    /**
     * Flag for SELECT permissions
     *
     * @var INT
     */
    const PDO_SELECT = 0b000010000000;

    /**
     * Flag for UPDATE permissions
     *
     * @var INT
     */
    const PDO_UPDATE = 0b000100000000;

    /**
     * Flag for WHERE permissions
     *
     * @var INT
     */
    const PDO_WHERE = 0b001000000000;

    /**
     * Flag for WRITE permissions
     *
     * @var in
     */
    const PDO_WRITE = 0b010000000000;
}