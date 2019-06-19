<?php

/**
 * File: Database.php
 */
namespace SmartPDO\Interfaces;

/**
 * Interface for all SmartPDO handlers
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 */
interface Database
{
    /**
     * Verify a column exists within a table
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableName
     *            The table to be used
     * @param string $column
     *            The Column to be 'found'
     * @param bool $noException
     *            If the column or table is not found discard the exception
     *            
     * @return bool
     */
	public function columnExists(string $tableName, string $column, bool $noException = false);
	
	/**
	 * Get the character which is used for joining/splitting column names
	 *
	 * @version 1.1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return string
	 */
	public function getColumnSeperator();
	
    /**
     * Get the database which we are working with
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string
     */
    public function getDatabaseName();
    
    /**
     * Get the prefix string
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function getPrefix();

    /**
     * Get a database table
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableName
     *            Name of the table within the database
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function getTable(string $tableName);

    /**
     * Get all columns namesfrom a table, prefix is not required
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableName
     *            Table of which the columns should be returned
     *            
     * @return string[]
     */
    public function getTableColumnNames(string $tableName);

    /**
     * Get all tables with columns
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @param string $tableName
     *            Table name without prefix
     *
     * @return \SmartPDO\Interfaces\TableColumns
     */
    public function getTableInfo(string $tableName);
    
    /**
     * Get all tables with columns
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return \SmartPDO\Interfaces\TableColumns[]
     */
    public function getTableInfos();
    
    /**
     * Get a tablename with the prefix
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @param string $tableName
     *            Table name without prefix
     *
     * @return string
     */
    public function getTableName(string $tableName);
    
    /**
     * Get all tables names
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string[]
     */
    public function getTableNames();
    
    /**
     * Check if a table exists
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @param string $tableName
     *            Table name without prefix
     *            
     * @return boolean
     */
    public function tableExists(string $tableName);
}