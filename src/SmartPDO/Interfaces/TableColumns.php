<?php
namespace SmartPDO\Interfaces;

interface TableColumns
{
	/**
	 * Get all columns from the table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string[]
	 */
	public function getColumnNames();
	
	/**
	 * Get a Column by its name
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param string $column
	 *            The requested column
	 *            
	 * @return \SmartPDO\Interfaces\TableColumn
	 */
	public function getColumn(string $column);
	
	/**
	 * Get the current table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getTableName();
}

