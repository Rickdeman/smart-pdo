<?php

/**
 * File: GroupBy.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter ORDER BY
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 *		
 */
class OrderBy
{

	/**
	 * Flag for ascending or not
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var bool
	 */
	private $ascending;

	/**
	 * Column name
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $column;

	/**
	 * Table name
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $table;

	/**
	 * ORDER BY parameter initialiser
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $table
	 *			Full table name
	 * @param string $column
	 *			Full column name
	 * @param bool $ascending
	 *			sorting order is ascending or not
	 */
	function __Construct(string $table, string $column, bool $ascending)
	{
		$this->table = $table;
		$this->column = $column;
		$this->ascending = $ascending;
	}

	/**
	 * Get the column name
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return string
	 */
	function getColumn()
	{
		return $this->column;
	}

	/**
	 * Get the table name
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return string
	 */
	function getTable()
	{
		return $this->table;
	}

	/**
	 * Check if ordering ascending or descending
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return bool
	 */
	function isAscending()
	{
		return $this->ascending === true;
	}
}