<?php
/**
 * File: GroupBy.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter SET
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class Set
{

	/**
	 * Column name
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	protected $column;
	
	
	/**
	 * SET Value
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var mixed
	 */
	protected $value;
	
	/**
	 * MODE SET parameter initialiser
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $table
	 *			Full table name
	 * @param string $column
	 *			Full column name
	 * @param mixed $value
	 *			Value to compare
	 */
	function __Construct(string $column, $value) {
		$this->column = $column;
		$this->value = $value;
	}
	
	/**
	 * Get the column name
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getColumn()
	{
		return $this->column;
	}
	
	
	/**
	 * Get the SET Value
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
	
}