<?php
$desc = "Single value";
/**
 * insert - Example #2
 *
 * When INSERT in the database the 'insert ()' must be called first! due to checks
 * For example: You cannot do an INSERT when you do an SELECT
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'customer' )->insert ();

/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $row
 */
$rows = $table->value ( 'name', 'Customer test' )->execute ();

echo "ID : '" . $rows->getInsertedID () . "'" . PHP_EOL;
print_r ( $rows->getQuery () );
