<?php

/**
 * File: In.php
 */
namespace SmartPDO\Parameters\Where;

/**
 * SmartPdo Parameter WHERE
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 *		
 */
class In extends \SmartPDO\Parameters\WhereLogic
{

	/**
	 * values for IS IN
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var array
	 */
	private $values;

	/**
	 * FunctionDescription
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @param string $table
	 *			Full table name
	 * @param string $column
	 *			Full column name
	 * @param array $list
	 *			(multiple) strings|numbers for WHERE IN
	 * @param bool $not
	 *			Boolean for IS NOT
	 * @param bool $and
	 *			if the AND statement should be used or OR
	 */
	public function __Construct(string $table, string $column, array $list, bool $not, bool $and)
	{
		$this->table = $table;
		$this->column = $column;
		$this->values = $list;
		$this->not = $not;
		$this->and = $and === true;
	}

	/**
	 * Get all values for IS IN
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *		
	 * @return array
	 */
	function getValues()
	{
		return $this->values;
	}
}