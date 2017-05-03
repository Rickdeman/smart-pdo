<?php

/**
 * between - Example #2
 *
 *	Get all rows where licences.ID is BETWEEN 2 & 3, if 'licences' is not specified 'customer' is used
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->innerJoin ( 'licences' )->between ( 'ID', 2, 3, 'licences' )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
