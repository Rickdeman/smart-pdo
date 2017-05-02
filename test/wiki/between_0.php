<?php

/**
 * between - Example #1
 *
 *	Get all rows where custom.ID is BETWEEN 2 & 3
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->andBetween ( 'ID', 2, 3 )->orBetween ( 'ID', 1, 2 )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );