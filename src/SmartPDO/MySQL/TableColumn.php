<?php

/**
 * File: TableColumn.php
 */
namespace SmartPDO\MySQL;

/**
 * MySQL Table handler
 *
 * @version 1.1
 * @author Rick de Man <rick@rickdeman.nl>
 * 
 */
class TableColumn implements \SmartPDO\Interfaces\TableColumn
{
	/**
	 * For string columns, the maximum length in characters.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var int
	 */
	private $charMaxLength;
	
	/**
	 * For string columns, the maximum length in bytes.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var int
	 */
	private $charOctetLenght;
	
	/**
	 * For character string columns, the character set name.
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $charSetName;
	
	/**
	 * For character string columns, the collation name.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $collationName;
		
	/**
	 * Any comment included in the column definition.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $columnComment;
	
	/**
	 * The default value for the column.
	 * This is NULL if the column has an explicit default of NULL, or if the column definition includes no DEFAULT clause.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var mixed
	 */
	private $columnDefault;
	
	/**
	 * Whether the column is indexed
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $columnKey;
	
	/**
	 * The name of the column.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $columnName;
	
	/**
	 * The column data type.
	 * The DATA_TYPE value is the type name only with no other information.
	 * The COLUMN_TYPE value contains the type name and possibly other information such as the precision or length.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $columnType;
	
	/**
	 * The column data type.
	 * The DATA_TYPE value is the type name only with no other information.
	 * The COLUMN_TYPE value contains the type name and possibly other information such as the precision or length.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $dataType;
	
	/**
	 * For temporal columns, the fractional seconds precision.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var int
	 */
	private $datetimePrecision;
	
	/**
	 * Any additional information that is available about a given column.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var mixed
	 */
	private $extra;
	
	/**
	 * The column nullability.
	 * The value is YES if NULL values can be stored in the column, NO if not.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var bool
	 */
	private $isNullable;
	
	/**
	 * For numeric columns, the numeric precision.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var int
	 */
	private $numericPrecision;
	
	/**
	 * For numeric columns, the numeric scale.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var int
	 */
	private $numericScale;
	
	/**
	 * The position of the column within the table.
	 * ORDINAL_POSITION is necessary because you might want to say ORDER BY ORDINAL_POSITION.
	 * Unlike SHOW COLUMNS, SELECT from the COLUMNS table does not have automatic ordering.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var int
	 */
	private $ordinalPosition;
	
	/**
	 * The privileges you have for the column.
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string[]
	 */
	private $privileges;
	
	/**
	 * The name of the catalog to which the table containing the column belongs. This value is always def.
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $tableCatalog;
	
	/**
	 * The name of the table containing the column.
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $tableName;
	
	/**
	 * The name of the schema (database) to which the table containing the column belongs.
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @var string
	 */
	private $tableSchema;
	
	/**
	 * Constructor for a new Table Column within MySQL
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
	 * @param array $columnData Table Data row form MySQL
	 */
	function __Construct(array $columnData ){
		if(array_key_exists("TABLE_CATALOG",$columnData)){
			$this->tableCatalog = $columnData["TABLE_CATALOG"];
		}
		if(array_key_exists("TABLE_SCHEMA",$columnData)){
			$this->tableSchema = $columnData["TABLE_SCHEMA"];
		}
		if(array_key_exists("TABLE_NAME",$columnData)){
			$this->tableName = $columnData["TABLE_NAME"];
		}
		if(array_key_exists("COLUMN_NAME",$columnData)){
			$this->columnName = $columnData["COLUMN_NAME"];
		}
		if(array_key_exists("ORDINAL_POSITION",$columnData)){
			$this->ordinalPosition = intval($columnData["ORDINAL_POSITION"]);
		}
		if(array_key_exists("COLUMN_DEFAULT",$columnData)){
			$this->columnDefault = $columnData["COLUMN_DEFAULT"];
		}
		if(array_key_exists("IS_NULLABLE",$columnData)){
			$this->isNullable = $columnData["IS_NULLABLE"] != "NO";
		}
		if(array_key_exists("DATA_TYPE",$columnData)){
			$this->dataType = $columnData["DATA_TYPE"];
		}
		if(array_key_exists("CHARACTER_MAXIMUM_LENGTH",$columnData)){
			$this->charMaxLength = intval($columnData["CHARACTER_MAXIMUM_LENGTH"]);
		}
		if(array_key_exists("CHARACTER_OCTET_LENGTH",$columnData)){
			$this->charOctetLenght = intval($columnData["CHARACTER_OCTET_LENGTH"]);
		}
		if(array_key_exists("NUMERIC_PRECISION",$columnData)){
			$this->numericPrecision = intval($columnData["NUMERIC_PRECISION"]);
		}
		if(array_key_exists("NUMERIC_SCALE",$columnData)){
			$this->numericScale = intval($columnData["NUMERIC_SCALE"]);
		}
		if(array_key_exists("DATETIME_PRECISION",$columnData)){
			$this->datetimePrecision = intval($columnData["DATETIME_PRECISION"]);
		}
		if(array_key_exists("CHARACTER_SET_NAME",$columnData)){
			$this->charSetName = $columnData["CHARACTER_SET_NAME"];
		}
		if(array_key_exists("COLLATION_NAME",$columnData)){
			$this->collationName = $columnData["COLLATION_NAME"];
		}
		if(array_key_exists("COLUMN_TYPE",$columnData)){
			$this->columnType = $columnData["COLUMN_TYPE"];
		}
		if(array_key_exists("COLUMN_KEY",$columnData)){
			$this->columnKey = $columnData["COLUMN_KEY"];
		}
		if(array_key_exists("EXTRA",$columnData)){
			$this->extra = $columnData["EXTRA"];
		}
		if(array_key_exists("PRIVILEGES",$columnData)){
			$this->privileges = explode(',', $columnData["PRIVILEGES"]);
		}
		if(array_key_exists("COLUMN_COMMENT",$columnData)){
			$this->columnComment = $columnData["COLUMN_COMMENT"];
		}
	}
	
    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::charMaxLength()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return number
     */
    public function charMaxLength()
    {
        return $this->charMaxLength;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::charOctetLenght()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return number
     */
    public function charOctetLenght()
    {
        return $this->charOctetLenght;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::charSetName()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function charSetName()
    {
        return $this->charSetName;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::collationName()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function collationName()
    {
        return $this->collationName;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::columnComment()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function columnComment()
    {
        return $this->columnComment;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::columnDefault()
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return mixed
     */
    public function columnDefault()
    {
        return $this->columnDefault;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::columnKey()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function columnKey()
    {
        return $this->columnKey;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::columnName()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function columnName()
    {
        return $this->columnName;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::columnType()
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function columnType()
    {
        return $this->columnType;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::dataType()
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function dataType()
    {
        return $this->dataType;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::datetimePrecision()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return number
     */
    public function datetimePrecision()
    {
        return $this->datetimePrecision;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::extra()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return mixed
     */
    public function extra()
    {
        return $this->extra;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::isNullable()
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return boolean
     */
    public function isNullable()
    {
        return $this->isNullable;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::numericPrecision()
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return number
     */
    public function numericPrecision()
    {
        return $this->numericPrecision;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::numericScale()
     * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return number
     */
    public function numericScale()
    {
        return $this->numericScale;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::ordinalPosition()
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return number
     */
    public function ordinalPosition()
    {
        return $this->ordinalPosition;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::privileges()
	 *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return multitype:string 
     */
    public function privileges()
    {
        return $this->privileges;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::tableCatalog()
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function tableCatalog()
    {
        return $this->tableCatalog;
    }

    /**
     * {@inheritDoc}
	 * @see \SmartPDO\Interfaces\TableColumn::tableName()
	 * 
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     * 
     * @return string
     */
    public function tableName()
    {
        return $this->tableName;
    }

    /**
     * {@inheritDoc}
     * @see \SmartPDO\Interfaces\TableColumn::tableSchema()
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function tableSchema()
    {
        return $this->tableSchema;
    }
	
}