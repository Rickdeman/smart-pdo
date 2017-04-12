<?php

/**
 * delete - Example #2
 *
 * Delete rows withing a table with where
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->delete ()->where ( "ID", 3 )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );