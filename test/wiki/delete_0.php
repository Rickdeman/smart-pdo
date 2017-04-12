<?php

/**
 * delete - Example #1
 *
 * Delete rows withing a table, becarefull since it will delete everything!
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->delete ()->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );