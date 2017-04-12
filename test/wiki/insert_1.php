<?php

/**
 * insert - Example #1
 *
 * When INSERT in the database the 'insert ()' must be called first! due to checks
 * For example: You cannot do an INSERT when you do an SELECT
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'customer' )->insert ();

/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->value ( 'name', 'Customer test' )->value ( 'info', 'HelloWorld' )->execute ();

echo "ID : '" . $rows->getInsertedID () . "'" . PHP_EOL;
print_r ( $rows->getQuery () );
