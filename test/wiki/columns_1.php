<?php
$desc = "MultiColumns with Join";
/**
 * columns - Example #2
 *
 * @see \SmartPDO\Config::$multiTableSeparator for the separator string
 *
 *      Select only specified columns, with a multiple tables.
 *      if the seperator is not found in the column name, the root table will be used
 *      if the seperator is found, the provided table will be used.
 *
 *      Unlike all the other methods, the columns will be validated at the very last moment
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'licences' )->columns ( "ID", "licences.customerID" )->innerJoin3 ( 'customer' )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
