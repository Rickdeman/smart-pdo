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
	const commandList = array (
			'SELECT' => self::PDO_SELECT | self::PDO_JOIN | self::PDO_LIMIT | self::PDO_ORDERBY | self::PDO_WHERE,
			'UPDATE' => self::PDO_SET | self::PDO_WHERE,
			'INSERT' => self::PDO_INSERT,
			'DELETE' => self::PDO_WHERE
	);
	const PDO_SELECT = 0b00000001;
	const PDO_INSERT = 0b00000010;
	const PDO_SET = 0b00000100;
	const PDO_JOIN = 0b00001000;
	const PDO_WHERE = 0b00010000;
	const PDO_ORDERBY = 0b00100000;
	const PDO_LIMIT = 0b01000000;
}