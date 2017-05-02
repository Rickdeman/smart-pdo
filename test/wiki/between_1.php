<?php

/**
 * between - Example #2
 *
 *	Get all rows where custom.ID is NOT BETWEEN 2 & 3
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->andBetween ( 'ID', 2, 3, true )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );