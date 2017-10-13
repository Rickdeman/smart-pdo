<?php

/**
 * File: Database.php
 */
namespace SmartPDO\Interfaces;

/**
 * Interface for all SmartPDO handlers
 *
 * @author Rick de Man
 * @version 1
 */
interface Database
{

    /**
     * Verify a column exists within a table
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $column
     *            The Column to be 'found'
     * @param string $table
     *            The table to be used
     * @param bool $noException
     *            If the column or table is not found discard the exception
     *            
     * @return bool True if exists, otherwise false
     */
    public function columnExists(string $column, string $table, bool $noException = false);

    /**
     * Get the database which we are working with
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string
     */
    public function getDatabaseName();

    /**
     * Get a mysql table
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableName
     *            Name of the table within the database
     *            
     * @return \SmartPDO\Interfaces\Table
     */
    public function getTable($tableName);

    /**
     * Get all columns of from a table, prefix is not required
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableName
     *            Table of which the columns should be returned
     *            
     * @return array all table columns names
     */
    public function getTableColumns(string $tableName);

    /**
     * Get a tablename with the prefix
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @param string $tableName
     *            Table name without prefix
     *            
     * @return string
     */
    public function getTableName(string $tableName);

    /**
     * Get all tables with columns
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return array
     */
    public function getTables();

    /**
     * Get the prefix string
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string
     */
    public function getPrefix();
}