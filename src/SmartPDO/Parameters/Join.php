<?php

/**
 * File: Join.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter JOIN
 * 
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class Join {

	/**
	 * Source columns
	 * 
	 * @var string
	 */
	private $sourceColumn;

	/**
	 * Source table
	 * 
	 * @var string
	 */
	private $sourceTable;

	/**
	 * target columns
	 * 
	 * @var string
	 */
	private $targetColumn;

	/**
	 * target table
	 * 
	 * @var string
	 */
	private $targetTable;

	/**
	 * Type of JOIN
	 * 
	 * @var string
	 */
	private $typeJoin;

	/**
	 * JOIN parameter initialiser
	 * 
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 * @param string $type
	 *        	Type of join to be used
	 * @param string $sourceTable
	 *        	Fully qualified source table name including prefix
	 * @param string $sourceColumn
	 *        	Fully qualified source table column
	 * @param string $targetTable
	 *        	Fully qualified target table name including prefix
	 * @param string $targetColumn
	 *        	Fully qualified target table column
	 * @throws \Exception
	 */
	function __construct($type, $sourceTable, $sourceColumn, $targetTable, $targetColumn) {
		$this->typeJoin = $type;
		$this->sourceTable = $sourceTable;
		$this->sourceColumn = $sourceColumn;
		$this->targetTable = $targetTable;
		$this->targetColumn = $targetColumn;
	}

	/**
	 *
	 * @return string
	 */
	public function getSourceColumn() {
		return $this->sourceColumn;
	}

	/**
	 *
	 * @return string
	 */
	public function getSourceTable() {
		return $this->sourceTable;
	}

	/**
	 *
	 * @return string
	 */
	public function getTargetColumn() {
		return $this->targetColumn;
	}

	/**
	 *
	 * @return string
	 */
	public function getTargetTable() {
		return $this->targetTable;
	}

	/**
	 *
	 * @return string
	 */
	public function getType() {
		return $this->typeJoin;
	}
}