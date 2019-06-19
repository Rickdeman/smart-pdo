<?php

/**
 * File: Limit.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class Limit
{

	/**
	 * Limit by x items
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var int
	 */
	private $items;

	/**
	 * start from row
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var int
	 */
	private $start;

	/**
	 * GROUP BY parameter initialiser
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * 
	 * @param string $items
	 *			Items to select/delete
	 * @param string $start
	 *			Start position
	 */
	function __Construct(int $items, int $start)
	{
		$this->items = $items;
		$this->start = $start;
	}

	/**
	 * Get the limit items
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return int
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * Get the limit start position
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return int
	 */
	public function getStart()
	{
		return $this->start;
	}
}