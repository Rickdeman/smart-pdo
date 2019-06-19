<?php

/**
 * File: Table.php
 */
namespace SmartPDO\MySQL;

/**
 * MySQL Table handler
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class Table implements \SmartPDO\Interfaces\Table
{

    /**
     * Flag for AND/OR, must be reset after each use!
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @var string
     */
    private $and = true;

    /**
     * Mysql class
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @var \SmartPDO\Interfaces\Database
     */
    private $db;

    /**
     * Number of times a OR should be placed
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @var integer
     */
    private $ors = 0;

    /**
     * Holds the parameter set for building querys
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @var \SmartPDO\Parameters
     */
    private $parameters;

    /**
     * Requestes table name without prefix
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @var string
     */
    private $tableName;

    /**
     * Contructor for the MySQL Table handler
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @param \SmartPDO\MySQL $db
     *            SmartPDO Database Object
     * @param string $table
     *            Full table name
     */
    function __construct( \SmartPDO\Interfaces\Database $db, string $table)
    {
    	if(!get_class($db) == "SmartPDO\MySQL"){
    		throw new \Exception("Wrong Database type provided! expecterd : SmartPDO\MySQL");
    	}
        // Store parameters
    	$this->parameters = new \SmartPDO\Parameters($db, $table);
        // Store SmartPDO ( is interface )
        $this->db = $db;
        // Store table name without prefix
    	$this->tableName = $this->parameters->getTable();
    }

    /**
     * {@inheritdoc}
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @see \SmartPDO\Interfaces\Table::between()
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function between(string $column, $start, $stop, bool $not = false, string $table = null)
    {
        // Register dataset WHERE BETWEEN
        $this->parameters->registerWhereBetween(
        	$table != null ? $table : $this->tableName,
        	$column,
        	$start, 
        	$stop, 
        	$not, 
        	$this->ors == 0
        );
        // Decrease OR counter if possible
        if ($this->ors > 0) {
            $this->ors --;
        }
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::columns()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return \SmartPDO\MySQL\Table
     */
    public function columns(string ...$columns)
    {
        // Register all columns
        $this->parameters->registerColumns(...$columns);
        // Return current object
        return $this;
    }
  
    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::decrement()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function decrement(string $columns, float $dec = 1)
    {
    	// Register a Decrement
    	$this->parameters->registerMod($columns, $dec, '-');
    	// Return current object
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::delete()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function delete()
    {
        // Register as DELETE command
        $this->parameters->registerCommand("DELETE");
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::distinct()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function distinct()
    {
        // Enable Distinct mode
        $this->parameters->setDistinct();
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::execute()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table\Rows
     */
    public function execute()
    {
        // Execute the parameters
        return new \SmartPDO\MySQL\Table\Rows($this->db, $this->parameters);
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::getColumns()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string[]
     */
    public function getColumns()
    {
        // Return the Columns from the parameters
    	return $this->parameters->getColumns();
    }
    
    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::getDb()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\Interfaces\Database
     */
    public function getDb()
    {
        // Return the database
        return $this->db;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::getTable()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function getTable()
    {
        // Return the Table name
        return $this->tableName;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::getTables()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *        
     * @return string[]
     */
    public function getTables()
    {
        // Returns the table  which are used
        return $this->parameters->getTables();
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::group()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return \SmartPDO\MySQL\Table
     */
    public function group(bool $and = false)
    {
        $this->parameters->registerGroup($and === true);
        // Set the and according to argument
        $this->and = $and === true;
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::groupBy()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return \SmartPDO\MySQL\Table
     */
    public function groupBy(string $column, string $table = null)
    {
        // Get the tablename
        $table = $this->db->getTableName($table != null ? $table : $this->tableName);
        // Register GROUP BY
        $this->parameters->registerGroupBy($column, $table);
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::in()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return \SmartPDO\MySQL\Table
     */
    public function in(string $column, array $list, bool $not = false, string $table = null)
    {
        // Register dataset WHERE IN
        $this->parameters->registerWhereIn(
        	$table != null ? $table : $this->tableName,
        	$column,
        	$list,
        	$not,
        	$this->ors == 0
        );
        // Decrease OR counter if possible
        if ($this->ors > 0) {
            $this->ors --;
        }
        // Return current object
        return $this;
    }
    
    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::increment()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return \SmartPDO\MySQL\Table
     */
    public function increment(string $columns, float $inc = 1)
    {
    	// Register a Inrement
    	$this->parameters->registerMod($columns, $inc, '+');
    	// Return current object
    	return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::innerJoin()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function innerJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "INNER JOIN",
            $this->db->getTableName($tableLeft),
            $columnLeft,
            $this->db->getTableName($tableRight),
            $columnRight,
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::innerJoin2()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function innerJoin2(string $columnLeft, string $tableRight, string $comparison = '=')
    {
        $this->parameters->registerJoin(
            "INNER JOIN",
            $this->db->getTableName($this->tableName),
            $columnLeft,
            $this->db->getTableName($tableRight),
            "ID",
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::innerJoin3()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function innerJoin3(string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "INNER JOIN",
            $this->db->getTableName($this->tableName),
            $tableRight . "ID",
            $this->db->getTableName($tableRight),
            "ID",
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::insert()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function insert()
    {
        // Register as INSERT command
        $this->parameters->registerCommand("INSERT");
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::leftJoin()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function leftJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "LEFT JOIN",
            $this->db->getTableName($tableLeft),
            $columnLeft,
            $this->db->getTableName($tableRight),
            $columnRight,
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::leftJoin2()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function leftJoin2(string $columnLeft, string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "LEFT JOIN",
            $this->db->getTableName($this->tableName),
            $columnLeft,
            $this->db->getTableName($tableRight),
            "ID",
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::leftJoin3()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function leftJoin3(string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "LEFT JOIN",
            $this->db->getTableName($this->tableName),
            $tableRight . "ID",
            $this->db->getTableName($tableRight),
            "ID",
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::like()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function like(string $column, $value, bool $not = false, string $table = null, string $escape = "!")
    {
        // Register dataset WHERE LIKE
        $this->parameters->registerWhereLike(
        	$table != null ? $table : $this->tableName,
        	$column,
        	$value, 
        	$not, 
        	$escape, 
        	$this->ors == 0
        );
        // Decrease OR counter if possible
        if ($this->ors > 0) {
            $this->ors --;
        }
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::limit()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function limit(int $items, int $start = 0)
    {
        // Register LIMIT parameters
        $this->parameters->registerLimit($items, $start);
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::orderBy()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function orderBy(string $column, bool $asc = true, string $table = null)
    {
        $table = $this->db->getTableName($table != null ? $table : $this->tableName);
        // Reguster new ORDER BY
        $this->parameters->registerOrderBy($column, $asc, $table);
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::rightJoin()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function rightJoin(string $tableLeft, string $columnLeft, string $tableRight, string $columnRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "RIGHT JOIN",
            $this->db->getTableName($tableLeft),
            $columnLeft,
            $this->db->getTableName($tableRight),
            $columnRight,
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::rightJoin2()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function rightJoin2(string $columnLeft, string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "RIGHT JOIN",
            $this->db->getTableName($this->tableName),
            $columnLeft,
            $this->db->getTableName($tableRight),
            "ID",
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::rightJoin3()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function rightJoin3(string $tableRight, string $comparison = '=')
    {
        // Insert new INNER JOIN dataset
        $this->parameters->registerJoin(
            "RIGHT JOIN",
            $this->db->getTableName($this->tableName),
            $tableRight . "ID",
            $this->db->getTableName($tableRight),
            "ID",
            $comparison
        );
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::select()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function select()
    {
        // Register as INSERT command
        $this->parameters->registerCommand("SELECT");
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::set()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function set(string $column, $value)
    {
        // Add update SET
        $this->parameters->registerSet($column, $value);
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::setOr()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function setOr(int $times = 1)
    {
        if ($times < 1) {
            throw new \Exception("times must be at least 1!");
        }
        // set the counter for OR('s)
        $this->ors = $times;
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::update()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function update()
    {
        // Register as UPDATE command
        $this->parameters->registerCommand("UPDATE");
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::value()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function value(string $column, $value)
    {
        // Register new INSERT key value
        $this->parameters->registerInsert($column, $value);
        // Return current object
        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \SmartPDO\Interfaces\Table::where()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return \SmartPDO\MySQL\Table
     */
    public function where(string $column, $value, string $comparison = '=', string $table = null)
    {
        // Register dataset WHERE
        $this->parameters->registerWhere(
        	$table != null ? $table : $this->tableName, 
        	$column, 
        	$comparison, 
        	$value, 
        	$this->ors == 0
        );
        // Decrease OR counter if possible
        if ($this->ors > 0) {
            $this->ors --;
        }
        // Return current object
        return $this;
    }
}