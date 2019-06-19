<?php

/**
 * File: TableColumns.php
 */
namespace SmartPDO\MySQL;

/**
 * MySQL Table Columns
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class TableColumns implements \SmartPDO\Interfaces\TableColumns
{
    
    /**
     * Get the Columns names
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @var string[]
     */
    private $columnNames;
    
	/**
	 * Columns belonging to the table
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var \SmartPDO\MySQL\TableColumn[]
	 */
	private $columns;
	
	/**
	 * Name of the current Table
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @var string
	 */
	private $tableName;
	
	/**
	 * Create new TableColumns information 
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 */
	function __Construct(string $tableName){
		$this->columns = array();
		$this->NameIndex = array(); 
		$this->tableName = $tableName;
	}	
	
	/**
	 * Register a new column belonging to the current table
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @param \SmartPDO\MySQL\TableColumn $column
	 */
	public function addColumn(\SmartPDO\MySQL\TableColumn $column){
	    // Check if the TableName is a match
		if($this->tableName == $column->tableName()){
		    // Register the Column
			$this->columns[] = $column;
		}
	}
	
	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumns::getColumn()
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>

	 * @return \SmartPDO\Interfaces\TableColumn
	 */
	public function getColumn(string $column){
		try {
			// Loopup the matching value for its index
			return $this->columns[array_search($column, $this->getColumnNames())];			
		} catch (\Exception $e) {
		}
	}
	
	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumns::getColumnNames()
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string[]
	 */
	public function getColumnNames(){
	    // Check if the ColumnNames are already loaded
		if($this->columnNames!=null)
			return $this->columnNames;
		// Mapp all Columns to an array of string
		$this->columnNames = array_map(
			function(\SmartPDO\MySQL\TableColumn $col){
				// Only return the table name
				return $col->columnName();
			},
			$this->columns
		);
		// Return the resulss
		return $this->columnNames;
	}

	/**
	 * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumns::getTableName()
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
	 */
	public function getTableName(){
	    // Return the name of the current Table
		return $this->tableName;
	}
}