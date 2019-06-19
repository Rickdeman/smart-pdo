<?php
namespace SmartPDO\Interfaces;

interface TableColumn
{
    /**
     * For string columns, the maximum length in characters.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return number
     */
    public function charMaxLength();
    
    /**
     * For string columns, the maximum length in bytes.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return number
     */
    public function charOctetLenght();
    
    /**
     * For character string columns, the character set name.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function charSetName();
    
    /**
     * For character string columns, the collation name.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function collationName();
    
    /**
     * Any comment included in the column definition.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function columnComment();
    
    /**
     * The default value for the column.
     * This is NULL if the column has an explicit default of NULL, or if the column definition includes no DEFAULT clause.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return mixed
     */
    public function columnDefault();
    
    /**
     * Whether the column is indexed
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function columnKey();
    
    /**
     * The name of the column.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function columnName();
    
    /**
     * The column data type.
     * The DATA_TYPE value is the type name only with no other information.
     * The COLUMN_TYPE value contains the type name and possibly other information such as the precision or length.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function columnType();
    
    /**
     * The column data type.
     * The DATA_TYPE value is the type name only with no other information.
     * The COLUMN_TYPE value contains the type name and possibly other information such as the precision or length.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function dataType();
    
    /**
     * For temporal columns, the fractional seconds precision.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return number
     */
    public function datetimePrecision();
    
    /**
     * Any additional information that is available about a given column.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return mixed
     */
    public function extra();
    
    /**
     * The column nullability.
     * The value is YES if NULL values can be stored in the column, NO if not.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return boolean
     */
    public function isNullable();
    
    /**
     * For numeric columns, the numeric precision.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return number
     */
    public function numericPrecision();
    
    /**
     * For numeric columns, the numeric scale.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return number
     */
    public function numericScale();
    /**
     * The position of the column within the table.
     * ORDINAL_POSITION is necessary because you might want to say ORDER BY ORDINAL_POSITION.
     * Unlike SHOW COLUMNS, SELECT from the COLUMNS table does not have automatic ordering.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return number
     */
    public function ordinalPosition();
    
    /**
     * The privileges you have for the column.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return multitype:string
     */
    public function privileges();
    
    /**
     * The name of the catalog to which the table containing the column belongs. This value is always def.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function tableCatalog();
    
    /**
     * The name of the table containing the column.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function tableName();
    
    /**
     * The name of the schema (database) to which the table containing the column belongs.
     *
     * @version 1.1
     * @author Rick de Man <rick@rickdeman.nl>
     *
     * @return string
     */
    public function tableSchema();
}

