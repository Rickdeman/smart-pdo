<?php

/**
 * columns - Example #1
 *
 * Select only specified columns, since no joins, root table is used
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->columns ( "name" )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
