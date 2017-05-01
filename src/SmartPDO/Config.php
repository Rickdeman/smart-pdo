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
class Config {

	/**
	 * Default multi table seperator: table.column, change if required
	 *
	 * @var string
	 */
	public static $multiTableSeparator = ".";

	/**
	 * Whether the SmartPDO has read-only or read-write acces
	 *
	 * Used for testing/development
	 *
	 * @var string
	 */
	public static $readOnly = false;

	/**
	 * Array of commands with permissions flags
	 *
	 * @var array
	 */
	const commandList = array (
			'SELECT' => self::PDO_SELECT | self::PDO_JOIN | self::PDO_LIMIT | self::PDO_ORDERBY | self::PDO_WHERE | Config::PDO_GROUPBY,
			'UPDATE' => self::PDO_WRITE | self::PDO_UPDATE | self::PDO_WHERE,
			'INSERT' => self::PDO_WRITE | self::PDO_INSERT,
			'DELETE' => self::PDO_WRITE | self::PDO_DELETE | self::PDO_WHERE | self::PDO_ORDERBY | self::PDO_LIMIT
	);

	/**
	 * Flag for DELETE permissions
	 *
	 * @var INT
	 */
	const PDO_DELETE = 0b00000000001;

	/**
	 * Flag for GROUP BY permissions
	 *
	 * @var int
	 */
	const PDO_GROUPBY = 0b00000000010;

	/**
	 * Flag for INSERT permissions
	 *
	 * @var INT
	 */
	const PDO_INSERT = 0b00000000100;

	/**
	 * Flag for join permissions
	 *
	 * @var INT
	 */
	const PDO_JOIN = 0b00000001000;

	/**
	 * Flag for LIMIT permissions
	 *
	 * @var INT
	 */
	const PDO_LIMIT = 0b00000010000;

	/**
	 * Flag for ORDER BY permissions
	 *
	 * @var INT
	 */
	const PDO_ORDERBY = 0b00000100000;

	/**
	 * Flag for SELECT permissions
	 *
	 * @var INT
	 */
	const PDO_SELECT = 0b00001000000;

	/**
	 * Flag for UPDATE permissions
	 *
	 * @var INT
	 */
	const PDO_UPDATE = 0b00010000000;

	/**
	 * Flag for WHERE permissions
	 *
	 * @var INT
	 */
	const PDO_WHERE = 0b00100000000;

	/**
	 * Flag for WRITE permissions
	 *
	 * @var in
	 */
	const PDO_WRITE = 0b01000000000;
}