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
	 * Array of commands with permissions flags
	 *
	 * @var array
	 */
	const commandList = array (
			'SELECT' => self::PDO_SELECT | self::PDO_JOIN | self::PDO_LIMIT | self::PDO_ORDERBY | self::PDO_WHERE,
			'UPDATE' => self::PDO_WRITE | self::PDO_UPDATE | self::PDO_WHERE,
			'INSERT' => self::PDO_WRITE | self::PDO_INSERT,
			'DELETE' => self::PDO_WRITE | self::PDO_DELETE | self::PDO_WHERE | self::PDO_ORDERBY | self::PDO_LIMIT
	);

	/**
	 * Flag for WRITE permissions
	 *
	 * @var in
	 */
	const PDO_WRITE = 0b000000001;

	/**
	 * Flag for SELECT permissions
	 *
	 * @var INT
	 */
	const PDO_SELECT = 0b000000010;

	/**
	 * Flag for INSERT permissions
	 *
	 * @var INT
	 */
	const PDO_INSERT = 0b000000100;

	/**
	 * Flag for UPDATE permissions
	 *
	 * @var INT
	 */
	const PDO_UPDATE = 0b000001000;

	/**
	 * Flag for join permissions
	 *
	 * @var INT
	 */
	const PDO_JOIN = 0b000010000;

	/**
	 * Flag for WHERE permissions
	 *
	 * @var INT
	 */
	const PDO_WHERE = 0b000100000;

	/**
	 * Flag for ORDER BY permissions
	 *
	 * @var INT
	 */
	const PDO_ORDERBY = 0b001000000;

	/**
	 * Flag for LIMIT permissions
	 *
	 * @var INT
	 */
	const PDO_LIMIT = 0b010000000;

	/**
	 * Flag for DELETE permissions
	 *
	 * @var INT
	 */
	const PDO_DELETE = 0b100000000;

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
	public static $multiTableSeparator = ".";
}