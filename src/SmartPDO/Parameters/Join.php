<?php

/**
 * File: Join.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter JOIN
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class Join
{

	/**
	 * Source columns
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $columnLeft;

	/**
	 * target columns
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $columnRight;

	/**
	 * Comparison symbol
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $comparison;

	/**
	 * Source table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $tableLeft;

	/**
	 * target table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $tableRight;

	/**
	 * Type of JOIN
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $typeJoin;

	/**
	 * JOIN parameter initialiser
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @param string $type
	 *			Type of join to be used
	 * @param string $tableLeft
	 *			Fully qualified source table name including prefix
	 * @param string $columnLeft
	 *			Fully qualified source table column
	 * @param string $tableRight
	 *			Fully qualified target table name including prefix
	 * @param string $columnRight
	 *			Fully qualified target table column
	 * @param string $comparison
	 *			Comparision action see compareList for more info
	 */
	function __construct(string $type, string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=')
	{
		$this->typeJoin = $type;
		$this->tableLeft = $tableLeft;
		$this->columnLeft = $columnLeft;
		$this->tableRight = $tableRight;
		$this->columnRight = $columnRight;
		$this->comparison = $comparison;
	}

	/**
	 * Return the Column which belongs to the left table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getColumnLeft()
	{
		return $this->columnLeft;
	}

	/**
	 * Return the Column which belongs to the right table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getColumnRight()
	{
		return $this->columnRight;
	}

	/**
	 * Returns the Comparison symbol
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getComparison()
	{
		return $this->comparison;
	}

	/**
	 * Return the left table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getTableLeft()
	{
		return $this->tableLeft;
	}

	/**
	 * Return the right table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getTableRight()
	{
		return $this->tableRight;
	}

	/**
	 * Returns the typeof JOIN
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->typeJoin;
	}
}